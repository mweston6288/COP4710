-- When opening mysql from terminal, run "mysql -u root -p < [path to tables.sql]", 

create database if not exists db;
use db;

create table if not exists admin (
    username varchar(100),
    password varchar(100),
    updateNeeded bool,
    primary key(username)
);

create table if not exists book(
    bookTitle varchar(100),
    author varchar(100),
    edition real,
    publisher varchar(100),
    ISBN integer,-- primary key?
    primary key (ISBN)
);
create table if not exists request( -- make one entry for each specific book request?
    profId integer,-- primary key?
    semester varchar(100),
    ISBN integer,-- primary key?    
    primary key (profId, ISBN, semester)
    foreign key (profId) references professor(profId),
    foreign key (ISBN) references book(ISBN)
);
create table if not exists professor(
    email varchar(100),-- likely primary key
    name varchar(100),
    username varchar(100),-- can be blank, blank triggers account creation
    password varchar(100),
    profId integer,
    updateNeeded bool,
    primary key(email),
);
-- default entries
insert into admin(username, password) values ("admin", "password");
