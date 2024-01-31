DROP DATABASE IF EXISTS  codesnack;
DROP USER IF EXISTS  codesnack@localhost;
create user codesnack@localhost identified WITH mysql_native_password  by 'codesnack';
create database codesnack;
grant all privileges on codesnack.* to codesnack@localhost with grant option;
commit;


USE codesnack;

CREATE TABLE user (
    user_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    id VARCHAR(50) NOT NULL,
    passwd VARCHAR(100) NOT NULL,
    nickname VARCHAR(50) NOT NULL,
    question INT NOT NULL,
    answer VARCHAR(50) NOT NULL,
    point INT DEFAULT 500
);

CREATE TABLE post (
    post_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    posttype INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE comment (
    comment_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    post_id BIGINT NOT NULL,
    comment TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (post_id) REFERENCES post(post_id)
);

CREATE TABLE notice (
    notice_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
