CREATE DATABASE esercitazione;
use esercitazione;

CREATE TABLE users(  
    id integer NOT NULL PRIMARY KEY AUTO_INCREMENT ,
    username varchar(16) NOT NULL UNIQUE,
    password  varchar(255) NOT NULL,
    name  varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    surname varchar(255) NOT NULL,
    npreferiti integer DEFAULT 0
) Engine= InnoDB;

CREATE TABLE posts (
    id integer primary key auto_increment,
    user integer not null,
    time timestamp not null default current_timestamp,
    nlikes integer default 0,
    content json,
    foreign key(user) references users(id) on delete cascade on update cascade
) Engine = InnoDB;

CREATE TABLE likes (
    user integer not null,
    post integer not null,
    index xuser(user),
    index xpost(post),
    foreign key(user) references users(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade,
    primary key(user, post)
) Engine = InnoDB;

CREATE TABLE favorites (
    user integer not null,
    post integer not null,
    index xuser(user),
    index xpost(post),
    foreign key(user) references users(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade,
    primary key(user, post)
) Engine = InnoDB;


DELIMITER //
CREATE TRIGGER likes_trigger
AFTER INSERT ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes + 1
WHERE id = new.post;
END //
DELIMITER ;


DELIMITER //
CREATE TRIGGER unlikes_trigger
AFTER DELETE ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes - 1
WHERE id = old.post;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER favorites_trigger
AFTER INSERT ON favorites
FOR EACH ROW
BEGIN
UPDATE users
SET npreferiti = npreferiti + 1
WHERE id = new.user;
END //
DELIMITER ;


DELIMITER //
CREATE TRIGGER unfavorites_trigger
AFTER DELETE ON favorites
FOR EACH ROW
BEGIN
UPDATE users
SET npreferiti = npreferiti - 1
WHERE id = old.user;
END //
DELIMITER ;


/*dati (in questo modo la password degli utenti non è criptata quindi non sarà possibile 
entrare con questi account ma servono per poter mettere all'interno del database dei post e dei like)*/
INSERT INTO users(id,username,password,name,email,surname,npreferiti) VALUES("1","kappa","cane23","Enzo","rossi@gmail.com","Rossi","0");
INSERT INTO users(id,username,password,name,email,surname,npreferiti) VALUES("2","Max","lifeisstrange","warren","stranavita@gmail.com","Boh","0");

INSERT INTO posts(id,user,nlikes,content) VALUES("1","1","0",JSON_OBJECT("anno", "2021",
"differenza", "38 ",
"goal_fatti", "69 ",
"goal_subiti", "31",
"pareggi", "4 ",
"posizione", "1",
"punti", "86 ",
"sconfitte", "4 ",
"url", "https://a.espncdn.com/i/teamlogos/soccer/500/103.png",
"vittorie", "26" ));

INSERT INTO posts(id,user,nlikes,content) VALUES("2","2","0",JSON_OBJECT("anno", "2017",
"differenza","62 ",
"goal_fatti", "86 ",
"goal_subiti","24",
"pareggi", "3 ",
"posizione", "1",
"punti", "95 ",
"sconfitte", "3 ",
"url", "https://a.espncdn.com/i/teamlogos/soccer/500/111.png",
"vittorie", "30 "));

INSERT INTO posts(id,user,nlikes,content) VALUES("3","2","0",JSON_OBJECT("anno", "2020",
"differenza", "41 ",
"goal_fatti", "64 ",
"goal_subiti", "23",
"pareggi", "3 ",
"posizione", "1",
"punti", "83 ",
"sconfitte", "3 ",
"url", "https://a.espncdn.com/i/teamlogos/soccer/500/166.png",
"vittorie", "24 "));

INSERT INTO likes(user,post)VALUES("1","1");
INSERT INTO likes(user,post)VALUES("2","1");
INSERT INTO likes(user,post)VALUES("1","2");
INSERT INTO likes(user,post)VALUES("2","2");
INSERT INTO likes(user,post)VALUES("2","3");
INSERT INTO favorites(user,post)VALUES("2","2");
 INSERT INTO favorites(user,post)VALUES("1","1");
 INSERT INTO favorites(user,post)VALUES("2","1");
