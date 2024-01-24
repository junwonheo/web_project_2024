const express = require('express');
const app = express();
const port = 3000;
const path = require('path')
const dbconfig = require('./conifg/dbconfig.json')
const bodyParser = require('body-parser');
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));


app.use(express.urlencoded({ extended: true }))
app.use(express.json())
app.use('/html', express.static(path.join(__dirname, 'html')));
app.use('/css', express.static(path.join(__dirname, 'css')));

app.listen(port, () => {
  console.log("server start!");
});
const mysql = require('mysql2');
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
app.post('/html/register.html', (req, res) => {
  promisePool.query(`
  INSERT INTO codesnack.user 
  ( username, id, passwd, nickname, question, answer, point)
  VALUES 
  (
  '${req.body.username}', '${req.body.id}', '${req.body.password}', 
  '${req.body.nickname}', '${req.body.question}', '${req.body.miss}', 500)
`).then(() => {
  res.redirect('http://localhost:3000/html/login.html');
  })
    .catch(err => {
      console.log(err);
      if (err.errno === 1062) {
        const body = { success: false, msg: "아이디가 이미 존재합니다." };
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
app.post('/login/login.html', (req, res) => {
  const { username, password } = req.body;

  if (username === 'admin' && password === 'password') {
      res.json({ success: true });
      res.redirect('http://localhost:3000/html/index.html');
  } else {
      res.json({ success: false });
  }
});



/*const express = require('express')
const mysql = require('mysql')
const app = express()
const port = 3000
const path = require('path')
const static = require('serve-static')
const dbconfig = require('./conifg/dbconfig.json')
app.use('/css', express.static(path.join(__dirname, 'css')));

// Database 
const pool = mysql.createPool({
  connectionLimit: 50,
  host: 'localhost',
  username: dbconfig.username,
  password: dbconfig.password,
  database: dbconfig.database,
  debug: false

})

app.use(express.urlencoded({ extended: true }))
app.use(express.json())
app.use('/html', express.static(path.join(__dirname, 'html')));

app.post('/process/adduser', (req, res) => {
  console.log('/process/adduser 호출됨 ' + req)

  const paramName = req.body.username;
  const paramId = req.body.id;
  const paramPassWd = req.body.password;
  const paramNickName = req.body.nickname;
  const paramQuestion = req.body.question;
  const paramAnswer = req.body.miss;

  pool.getConnection((err, conn) => {
    if (err) {
      conn.release();
      console.log('err');
      return;
    }
    console.log('connect');


    const exec = conn.query('insert into user(username, id , password, nickname, question, miss) values (?,?,password(?),?,?,?) ',
      [paramName, paramId, paramPassWd, paramNickName, paramQuestion, paramAnswer],
      (err, result) => {
        conn.release();
        console.log('실행된 sql' + exec.sql)
        if (err) {
          console.log - ('err')
          console.log(err);
          return;
        }
        if (result) {
          console.dir(result)
          console.log('insert 성공')
        }
        else {
          console.log('insert 실패')
        }
      }
    )
  })
})
app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
});

/*

app.use(express.static(path.join(__dirname, 'css')));

app.get('/', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/index.html'));
  });
app.get('/index.html', function(request, response) {
  response.sendFile(path.join(__dirname + '/html/index.html'));
});
app.get('/login.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/login.html'));
  });
  app.get('/register.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/register.html'));
  });
  app.get('/find-id.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/find-id.html'));
  });
  app.get('/find-pw.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/find-pw.html'));
  });
  app.get('/notice-board.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/notice-board.html'));
  });
  app.get('/notice-text.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/notice-text.html'));
  });
  app.get('/free-board.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/free-board.html'));
  });app.get('/free-text.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/free-text.html'));
  });
  app.get('/market-board.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/market-board.html'));
  });
  app.get('/market-text.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/market-text.html'));
  });

  app.get('/suggestions-board.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/suggestions-board.html'));
  });
  app.get('/suggestions-text.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/suggestions-text.html'));
  });
  app.get('/qna-board.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/qna-board.html'));
  });
  app.get('/qna-text.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/qna-text.html'));
  });
  app.get('/pointshop.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/pointshop.html'));
  });
  app.get('/write-post-page.html', function(request, response) {
    response.sendFile(path.join(__dirname + '/html/write-post-page.html'));
  });




*/