-- When opening mysql from terminal, run "mysql -u root -p < [path to tables.sql]", 

create database if not exists db;
use db;

create table if not exists admin (
	adminId integer not null auto_increment,
    username varchar(100) not null,
    password varchar(100) not null,
    -- useless for now, but will use if we implement a force password reset
    updateNeeded bool, 
    primary key(adminId)
);

create table if not exists book(
    bookTitle varchar(100) not null,
    author varchar(100) not null,
    edition real not null,
    publisher varchar(100) not null,
    ISBN integer not null,
    primary key (ISBN)
);
create table if not exists professor(
    profId integer not null auto_increment,    
    email varchar(100) not null,
    name varchar(100) not null,
    username varchar(100),-- can be blank, blank triggers account creation
    password varchar(100),
    -- useless for now, but will use if we implement a force password reset
    updateNeeded bool,
    primary key(profId)
);
-- tracks each book request by each professor in each semester
create table if not exists request(
    profId integer not null,
    semester varchar(100) not null,
    ISBN integer not null,    
    primary key (profId, ISBN, semester),
    foreign key (profId) references professor(profId),
    foreign key (ISBN) references book(ISBN)
);
-- default entries
insert into admin(username, password) values ("admin", "password");
