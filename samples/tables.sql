-- When opening mysql from terminal, run "mysql -u root -p < [path to tables.sql]", 

create database if not exists db;
use db;

create table if not exists admin (
    username varchar(100),
    password varchar(100),
    primary key(username)

);
create table if not exists request( -- make one entry for each specific book request?
    reqId integer,-- primary key?
    bookTitle varchar(100),
    author varchar(100),
    edition real,
    publisher varchar(100),
    ISBN integer,-- primary key?
    semester varchar(100),
    primary key (reqId, ISBN)
);
create table if not exists professor(
    email varchar(100),-- likely primary key
    name varchar(100),
    username varchar(100),-- can be blank, blank triggers account creation
    password varchar(100),
    reqId integer,
    primary key(email),
    foreign key (reqid) references request(reqid)
);
-- default entries
insert into admin(username, password) values ("admin", "password");
