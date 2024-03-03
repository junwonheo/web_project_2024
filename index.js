const express = require('express');
const mysql = require('mysql2');
const session = require('express-session');
const path = require('path')
const dbconfig = require('./conifg/dbconfig.json')
const bodyParser = require('body-parser');
const multer = require('multer');
const fs = require('fs');
const http = require('http');
const { Console } = require('console');
const app = express();
const port = 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.urlencoded({ extended: true }))
app.use(express.json())
app.use('/views', express.static(path.join(__dirname, 'views')));
app.use('/html', express.static(path.join(__dirname, 'html')));
app.use('/css', express.static(path.join(__dirname, 'css')));
app.set('view engine', 'ejs');
//세션
app.use(session({
  secret: dbconfig.secret,
  resave: false,
  saveUninitialized: true,
  cookie: { maxAge: 60 * 60 * 1000 } // set to true if you're using https
}))
// 이미지 파일을 저장할 디렉토리와 파일 이름 설정
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, 'uploads/');
  },
  filename: function (req, file, cb) {
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
    const extension = path.extname(file.originalname);
    cb(null, uniqueSuffix + extension);
  }
});
//서버열기
app.listen(port, () => {
  console.log("server start!");
});
//sql
const pool = mysql.createPool({
  host: dbconfig.host,
  port: dbconfig.port,
  user: dbconfig.user,
  database: dbconfig.database,
  password: dbconfig.password,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
})
const promisePool = pool.promise();
//회원가입
app.post('/register', (req, res) => {
  console.log(req.body);
  promisePool.query(`
  INSERT INTO codesnack.user 
  ( username, id, passwd, nickname, question, answer, point)
  VALUES 
  (
  '${req.body.username}', '${req.body.id}', '${req.body.password}', 
  '${req.body.nickname}', '${req.body.question}', '${req.body.miss}', 500)
`).then(() => {
    res.render('/login');
  })
    .catch(err => {
      console.log(err);
      if (err.errno === 1062) {
        const body = { success: false, msg: "실패." };
        return res.json(body);
      }
    });
});
//아이디 중복
app.get('/checkduplicate1', (req, res) => {
  const id = req.query.id; // 클라이언트로부터 전달받은 아이디

  // 아이디 중복 확인을 위해 데이터베이스에서 아이디 조회
  promisePool.query('SELECT * FROM user WHERE id = ?', [id])
    .then(([rows]) => {
      // 중복된 아이디가 이미 존재하는 경우
      const duplicate = rows.length > 0;
      const response = { duplicate };
      return res.json(response);
    })
    .catch(err => {
      console.error(err);
      const response = { duplicate: false };
      return res.json(response);
    });
});
//닉네임 중복 
app.get('/checkduplicate2', (req, res) => {
  const nickname = req.query.nickname; // 클라이언트로부터 전달받은 닉네임

  // 닉네임 중복 확인을 위해 데이터베이스에서 닉네임 조회
  promisePool.query('SELECT * FROM user WHERE nickname = ?', [nickname])
    .then(([rows]) => {
      // 중복된 닉네임이 이미 존재하는 경우
      const duplicate = rows.length > 0;
      const response = { duplicate };
      return res.json(response);
    })
    .catch(err => {
      console.error(err);
      const response = { duplicate: false };
      return res.json(response);
    });
});
// 로그인 
app.post('/login', (req, res) => {
  const id = req.body.id;
  const password = req.body.password;
  console.log('로그인 요청' + id + ' ' + password)

  // 아이디를 사용하여 데이터베이스에서 사용자를 조회합니다.
  pool.getConnection((err, conn) => {
    if (err) {
      conn.release();
      res.end();
      return;
    }
    const exec = conn.query('select userId, id, passwd, nickname, point from user where id=? and passwd =?',
      [id, password],
      (err, rows) => {
        conn.release();
        console.log('실행된 sql ' + exec.sql);
        if (err) {
          console.dir(err);
          return;
        }
        if (rows.length > 0) {

          console.log('아이디 [%s], 패스워드[%s]', id, rows[0].passwd);
          req.session.user = { login: true, id: id, password: rows[0].passwd, nickname: rows[0].nickname, userId: rows[0].userId, point: rows[0].point };
          console.log('로그인 성공')
          console.log(req.session);
          console.log(req.session.user);
          res.redirect('/index');
        }
        else {

          console.log('로그인 실패')
          res.redirect('/login');

        }
      }
    )
  })
});
//로그아웃
app.get('/logout', (req, res) => {
  req.session.destroy((error) => {
    if (error) {
      console.error('오류 발생: ', error);
      console.log('세션에 사용자 정보 있음:', req.session.user);
    } else {
      console.log('로그아웃 완료');
      res.redirect('/');
    }
  });
});
//게시판 글쓰기 
const upload = multer({ storage: storage });
app.post('/write-post-page', upload.single('image'), (req, res) => {
  // 폼 데이터를 받아옵니다.
  const Id = req.session.user.id;
  const board = req.body.board;
  const title = req.body.title;
  const content = req.body.content;
  const image = req.file ? req.file.path : null;
  console.log('받은 board:', board);
  console.log('받은 title:', title);
  console.log('받은 content:', content);
  console.log('받은 image:', image);
  // 받아온 폼 데이터를 적절히 활용하여 원하는 작업을 수행합니다.
  // 예를 들어, 데이터베이스에 저장하거나 다른 처리를 수행할 수 있습니다.
  promisePool
    .query('SELECT userId FROM user WHERE id = ?', [Id])
    .then(([rows]) => {
      const userId = rows[0].userId;

      // 다음 작업을 위해 userId를 설정
      return Promise.resolve(userId); // userId를 찾는 작업 완료 후 다음 작업으로 이동
    })
    .then((userId) => {
      promisePool.query(
        `INSERT INTO codesnack.post 
  (userId, postType, title, content, image, timeStamp)
  VALUES (?, ?, ?, ?, ?, NOW())`,
        [userId, board, title, content, image]
      ).then(() => {
        console.log('게시물이 성공적으로 저장되었습니다.');
        res.json({
          success: true,
        });
      })
        .catch((error) => {
          console.error('게시물 저장 중 오류가 발생했습니다:', error);
          return res.json({
            success: false,
          });
        });
    })
    .catch((error) => {
      console.error('게시물 저장 중 오류가 발생했습니다:', error);
      return res.json({
        success: false,
      });
    });

  // 응답을 보냅니다.
});
//게시판 홈
app.get('/free-board', (req, res) => {
  const pageSize = 4; // 한 페이지당 게시물 14개
  const page = req.query.page || 1; // 페이지 번호 기본값 1
  const startIndex = (page - 1) * pageSize; // DB에서 가져올 게시물의 시작 위치를 계산
  promisePool.query('SELECT COUNT(*) AS totalcount FROM post WHERE postType = 1;')
    .then((rows) => {
      const totalcount = rows[0][0].totalcount;
      const totalPages = Math.ceil(totalcount / pageSize);

      // count 값과 totalPages를 다음 then 블럭으로 전달
      return { totalcount, totalPages };
    })
    .then(({ totalcount, totalPages }) => {
      promisePool.query('SELECT postId, title, content, timeStamp FROM post WHERE postType = 1 ORDER BY postId DESC LIMIT ?, ?',
        [startIndex, pageSize])
        .then((result) => {
          if (req.session.user && req.session.user.login) {
            // 로그인 상태일 때
            res.render('free-board', {
              login: req.session.user.login,
              nickname: req.session.user.nickname,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          } else {
            // 비로그인 상태일 때
            res.render('free-board', {
              login: false,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          }
        })
    })
    .catch(error => {
      console.log('쿼리 실행 중 에러가 발생했습니다:', error);
    });
});
app.get('/market-board', (req, res) => {
  const pageSize = 4; // 한 페이지당 게시물 12개
  const page = req.query.page || 1; // 페이지 번호 기본값 1
  const startIndex = (page - 1) * pageSize; // DB에서 가져올 게시물의 시작 위치를 계산
  promisePool.query('SELECT COUNT(*) AS totalcount FROM post WHERE postType = 2;')
    .then((rows) => {
      const totalcount = rows[0][0].totalcount;
      const totalPages = Math.ceil(totalcount / pageSize);
      // count 값과 totalPages를 다음 then 블럭으로 전달
      return { totalcount, totalPages };
    })
    .then(({ totalcount, totalPages }) => {
      promisePool.query('SELECT postId, title, content, timeStamp FROM post WHERE postType = 2 ORDER BY postId DESC LIMIT ?, ?', [startIndex, pageSize])
        .then((result) => {

          if (req.session.user && req.session.user.login) {
            // 로그인 상태일 때
            res.render('market-board', {
              login: req.session.user.login,
              nickname: req.session.user.nickname,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          } else {
            // 비로그인 상태일 때
            res.render('market-board', {
              login: false,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          }
        })
    })
    .catch(error => {
      console.log('쿼리 실행 중 에러가 발생했습니다:', error);
    });
});
app.get('/suggestions-board', (req, res) => {
  const pageSize = 4; // 한 페이지당 게시물 12개
  const page = req.query.page || 1; // 페이지 번호 기본값 1
  const startIndex = (page - 1) * pageSize; // DB에서 가져올 게시물의 시작 위치를 계산
  promisePool.query('SELECT COUNT(*) AS totalcount FROM post WHERE postType = 3;')
    .then((rows) => {
      const totalcount = rows[0][0].totalcount;
      const totalPages = Math.ceil(totalcount / pageSize);
      // count 값과 totalPages를 다음 then 블럭으로 전달
      return { totalcount, totalPages };
    })
    .then(({ totalcount, totalPages }) => {
      promisePool.query('SELECT postId, title, content, timeStamp FROM post WHERE postType = 3 ORDER BY postId DESC LIMIT ?, ?', [startIndex, pageSize])
        .then((result) => {

          if (req.session.user && req.session.user.login) {
            // 로그인 상태일 때
            res.render('suggestions-board', {
              login: req.session.user.login,
              nickname: req.session.user.nickname,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          } else {
            // 비로그인 상태일 때
            res.render('suggestions-board', {
              login: false,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          }
        })
    })
    .catch(error => {
      console.log('쿼리 실행 중 에러가 발생했습니다:', error);
    });
});
app.get('/qna-board', (req, res) => {
  const pageSize = 4; // 한 페이지당 게시물 12개
  const page = req.query.page || 1; // 페이지 번호 기본값 1
  const startIndex = (page - 1) * pageSize; // DB에서 가져올 게시물의 시작 위치를 계산
  promisePool.query('SELECT COUNT(*) AS totalcount FROM post WHERE postType = 4;')
    .then((rows) => {
      const totalcount = rows[0][0].totalcount;
      const totalPages = Math.ceil(totalcount / pageSize);
      // count 값과 totalPages를 다음 then 블럭으로 전달
      return { totalcount, totalPages };
    })
    .then(({ totalcount, totalPages }) => {
      promisePool.query('SELECT postId, title, content, timeStamp FROM post WHERE postType = 4 ORDER BY postId DESC LIMIT ?, ?', [startIndex, pageSize])
        .then((result) => {
          console.log(result[0][0].postId)
          if (req.session.user && req.session.user.login) {
            // 로그인 상태일 때
            res.render('qna-board', {
              login: req.session.user.login,
              nickname: req.session.user.nickname,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          } else {
            // 비로그인 상태일 때
            res.render('qna-board', {
              login: false,
              totalcount: totalcount,
              boards: result,
              currentPage: parseInt(page),
              totalPages: totalPages,
              pageSize: pageSize
            });
          }
        })
    })
    .catch(error => {
      console.log('쿼리 실행 중 에러가 발생했습니다:', error);
    });
});

// 자유 게시글 보기 + 댓글
app.get('/free-text', (req, res) => {
  //게시글 
  const postId = req.query.no;
  promisePool.query('SELECT * FROM post WHERE postId = ?', [postId])
    .then((result) => {
      const boards = result;
      const login = req.session.user && req.session.user.login;
      const nickname = req.session.user ? req.session.user.nickname : null;
      if (login) {
        req.session.user.postId = req.query.no;
      }

      // 댓글 조회
      promisePool.query('SELECT COUNT(*) AS totalcount FROM comment WHERE postId = ?', [postId])
        .then((rows) => {
          const totalcount = rows[0][0].totalcount;
          console.log(totalcount);
          promisePool.query('SELECT userId, comment, Timestamp FROM comment WHERE postId = ? ORDER BY commentId DESC',
            [postId])
            .then(async (comment) => {
              const promises = comment[0].map(c =>
                promisePool.query('SELECT nickname FROM user WHERE userId = ?', [c.userId])
              );

              const users = await Promise.all(promises);
              const nicknames = users.map(user => user[0][0].nickname);

              console.log(nicknames);  // 닉네임 배열을 출력합니다.
              res.render('free-text', {
                login: login,
                users: nicknames,
                nickname: nickname,
                totalcount: totalcount,
                comment: comment,
                boards: result
    
              });
            });
          /*
          promisePool.query('SELECT userId, comment, Timestamp FROM comment WHERE postId = ? ORDER BY commentId DESC',
            [postId])
            .then((comment) => {
              const userIds = comment[0].map(c => c.userId);
              console.log(userIds)
              
              console.log(comment[0][0].userId);
              console.log(comment[0][1].userId);
              console.log(comment[0][2].userId);
              console.log(comment[0][3].userId);
              
              promisePool.query('SELECT  nickname FROM user WHERE userId IN (?)', [userIds])
                .then((users) => {
                  console.log(users[0].length);
                  console.log(users[0][0])
                  console.log(users[0][1])
                  console.log(users[0][2])
                  console.log(users[0][3])
               
                  //const nicknames = users[0].map(u => u.nickname);
                  //console.log(nicknames);
                  //const nicknameMap = new Map(users[0].map(u => [u.userId, u.nickname]));
                  //const nicknames = userIds.map(id => nicknameMap.get(id));
                  //console.log(nicknames);

*/
          
        })
    })
    .catch((error) => {
      console.error(error);
    });
})

app.post('/free-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    const postId = req.session.user.postId;
    const userId = req.session.user.userId;
    const comment = req.body.comment;

    console.log(postId)
    console.log(userId)
    console.log(comment)

    promisePool.query(
      `INSERT INTO codesnack.comment
(userId, postId, comment, timeStamp)
VALUES (?, ?, ?,NOW())`,
      [userId, postId, comment]
    ).then(() => {
      console.log("댓글저장됨")
      res.redirect(`/free-text?no=${postId}`);
    })
  }
  else {
    // 로그인 상태가 아닌 경우, 인덱스 페이지로 리디렉션
    res.redirect('/login');
  }


});
//마켓 게시글 + 댓글
app.get('/market-text', (req, res) => {
  //게시글 
  const postId = req.query.no;
  promisePool.query('SELECT * FROM post WHERE postId = ?', [postId])
    .then((result) => {
      const boards = result;
      const login = req.session.user && req.session.user.login;
      const nickname = req.session.user ? req.session.user.nickname : null;
      if (login) {
        req.session.user.postId = req.query.no;
      }

      // 댓글 조회
      promisePool.query('SELECT COUNT(*) AS totalcount FROM comment WHERE postId = ?', [postId])
        .then((rows) => {
          const totalcount = rows[0][0].totalcount;
          console.log(totalcount);
          promisePool.query('SELECT userId, comment, Timestamp FROM comment WHERE postId = ? ORDER BY commentId DESC',
            [postId])
            .then(async (comment) => {
              const promises = comment[0].map(c =>
                promisePool.query('SELECT nickname FROM user WHERE userId = ?', [c.userId])
              );
              const users = await Promise.all(promises);
              const nicknames = users.map(user => user[0][0].nickname);
              console.log(nicknames);  // 닉네임 배열을 출력합니다.
              res.render('market-text', {
                login: login,
                users: nicknames,
                nickname: nickname,
                totalcount: totalcount,
                comment: comment,
                boards: result
    
              });
            });  
        })
    })
    .catch((error) => {
      console.error(error);
    });
})
app.post('/market-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    const postId = req.session.user.postId;
    const userId = req.session.user.userId;
    const comment = req.body.comment;

    console.log(postId)
    console.log(userId)
    console.log(comment)

    promisePool.query(
      `INSERT INTO codesnack.comment
(userId, postId, comment, timeStamp)
VALUES (?, ?, ?,NOW())`,
      [userId, postId, comment]
    ).then(() => {
      console.log("댓글저장됨")
      res.redirect(`/market-text?no=${postId}`);
    })
  }
  else {
    // 로그인 상태가 아닌 경우, 인덱스 페이지로 리디렉션
    res.redirect('/login');
  }


});
// 건의
app.get('/suggestions-text', (req, res) => {
  //게시글 
  const postId = req.query.no;
  promisePool.query('SELECT * FROM post WHERE postId = ?', [postId])
    .then((result) => {
      const boards = result;
      const login = req.session.user && req.session.user.login;
      const nickname = req.session.user ? req.session.user.nickname : null;
      if (login) {
        req.session.user.postId = req.query.no;
      }

      // 댓글 조회
      promisePool.query('SELECT COUNT(*) AS totalcount FROM comment WHERE postId = ?', [postId])
        .then((rows) => {
          const totalcount = rows[0][0].totalcount;
          console.log(totalcount);
          promisePool.query('SELECT userId, comment, Timestamp FROM comment WHERE postId = ? ORDER BY commentId DESC',
            [postId])
            .then(async (comment) => {
              const promises = comment[0].map(c =>
                promisePool.query('SELECT nickname FROM user WHERE userId = ?', [c.userId])
              );

              const users = await Promise.all(promises);
              const nicknames = users.map(user => user[0][0].nickname);

              console.log(nicknames);  // 닉네임 배열을 출력합니다.
              res.render('suggestions-text', {
                login: login,
                users: nicknames,
                nickname: nickname,
                totalcount: totalcount,
                comment: comment,
                boards: result
    
              });
            });
        })
    })
    .catch((error) => {
      console.error(error);
    });
})
app.post('/suggestions-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    const postId = req.session.user.postId;
    const userId = req.session.user.userId;
    const comment = req.body.comment;

    console.log(postId)
    console.log(userId)
    console.log(comment)

    promisePool.query(
      `INSERT INTO codesnack.comment
(userId, postId, comment, timeStamp)
VALUES (?, ?, ?,NOW())`,
      [userId, postId, comment]
    ).then(() => {
      console.log("댓글저장됨")
      res.redirect(`/suggestions-text?no=${postId}`);
    })
  }
  else {
    // 로그인 상태가 아닌 경우, 인덱스 페이지로 리디렉션
    res.redirect('/login');
  }


});
//qna 
app.get('/qna-text', (req, res) => {
  //게시글 
  const postId = req.query.no;
  promisePool.query('SELECT * FROM post WHERE postId = ?', [postId])
    .then((result) => {
      const boards = result;
      const login = req.session.user && req.session.user.login;
      const nickname = req.session.user ? req.session.user.nickname : null;
      if (login) {
        req.session.user.postId = req.query.no;
      }

      // 댓글 조회
      promisePool.query('SELECT COUNT(*) AS totalcount FROM comment WHERE postId = ?', [postId])
        .then((rows) => {
          const totalcount = rows[0][0].totalcount;
          console.log(totalcount);
          promisePool.query('SELECT userId, comment, Timestamp FROM comment WHERE postId = ? ORDER BY commentId DESC',
            [postId])
            .then(async (comment) => {
              const promises = comment[0].map(c =>
                promisePool.query('SELECT nickname FROM user WHERE userId = ?', [c.userId])
              );

              const users = await Promise.all(promises);
              const nicknames = users.map(user => user[0][0].nickname);

              console.log(nicknames);  // 닉네임 배열을 출력합니다.
              res.render('qna-text', {
                login: login,
                users: nicknames,
                nickname: nickname,
                totalcount: totalcount,
                comment: comment,
                boards: result
    
              });
            });
        })
    })
    .catch((error) => {
      console.error(error);
    });
})
app.post('/qna-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    const postId = req.session.user.postId;
    const userId = req.session.user.userId;
    const comment = req.body.comment;

    console.log(postId)
    console.log(userId)
    console.log(comment)

    promisePool.query(
      `INSERT INTO codesnack.comment
(userId, postId, comment, timeStamp)
VALUES (?, ?, ?,NOW())`,
      [userId, postId, comment]
    ).then(() => {
      console.log("댓글저장됨")
      res.redirect(`/qna-text?no=${postId}`);
    })
  }
  else {
    // 로그인 상태가 아닌 경우, 인덱스 페이지로 리디렉션
    res.redirect('/login');
  }


});

app.get('/', function (req, res) {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('index', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때

    res.render('index', { login: false });
  }
});
app.get('/find-id', (req, res) => {
  res.render('find-id');
});
app.get('/find-pw', (req, res) => {
  res.render('find-pw');
});

app.get('/free-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('free-text', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});
app.get('/index', function (req, res) {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('index', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('index', { login: false });
  }
});
app.get('/login', (req, res) => {
  res.render('login');
});
app.get('/market-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('market-text', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});
app.get('/notice-board', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('notice-board', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('notice-board', { login: false });
  }
});
app.get('/notice-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('notice-text', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});
app.get('/pointshop', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('pointshop', { login: req.session.user.login, nickname: req.session.user.nickname, point: req.session.user.point });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});

app.get('/qna-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('qna-text', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});
app.get('/register', (req, res) => {
  res.render('register');
});

app.get('/suggestions-text', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('suggestions-text', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});
app.get('/write-post-page', (req, res) => {
  if (req.session.user && req.session.user.login) {
    // 로그인 상태일 때
    res.render('write-post-page', { login: req.session.user.login, nickname: req.session.user.nickname });
  } else {
    // 비로그인 상태일 때
    res.render('login', { login: false });
  }
});



app.post('/html/write-post-page.html', (req, res) => {
  const Id = req.session.ss_id;
  const title = req.body.title;
  const board = req.body.board;
  const content = req.body.content;
  let userId;
  
  promisePool
    .query('SELECT userId FROM user WHERE id = ?', [Id])
    .then(([rows]) => {
     userId = rows[0].userId;
  
      // 다음 작업을 위해 userId를 설정
      return Promise.resolve(); // userId를 찾는 작업 완료 후 다음 작업으로 이동
    })
    .then(() => {
      promisePool.query(
        `INSERT INTO codesnack.post 
        (userId, postType, title, content, image, timeStamp)
        VALUES ('${userId}','${board}', '${title}','${content}', 0, '${new Date()}')`,
      ).then(() => {
        console.log('게시물이 성공적으로 저장되었습니다.');
        res.send('게시물이 업로드되었습니다.');
      })
      .catch((error) => {
        console.error('게시물 저장 중 오류가 발생했습니다:', error);
        res.status(500).send('게시물을 업로드하는 도중 오류가 발생했습니다.');
      });
    })
    .catch((error) => {
      console.error('게시물 저장 중 오류가 발생했습니다:', error);
      res.status(500).send('게시물을 업로드하는 도중 오류가 발생했습니다.');
    });
});
