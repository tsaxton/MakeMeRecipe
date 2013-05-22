drop database if exists makemerecipe;
create database makemerecipe;
use makemerecipe;
create table userlist (userid int not null auto_increment, phonid int, primary key (userid));
create table recipelist (userid int,api_id int(3),searchid varchar(100), user_rating int, favorited bool, disliked bool, primary key (searchid,api_id));
CREATE USER 'orangeteam'@'localhost' IDENTIFIED BY 'eecs394';
GRANT ALL PRIVILEGES ON *.* TO 'eecs394orange'@'localhost' WITH GRANT OPTION;
