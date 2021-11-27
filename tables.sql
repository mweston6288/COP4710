-- When opening mysql from terminal, run "mysql -u root -p < [path to tables.sql]", 

create database if not exists db;
use db;

create table if not exists admin (
	adminId integer not null auto_increment,
    username varchar(100) not null default '',
    password varchar(100) not null default '',
    -- useless for now, but will use if we implement a force password reset
    updateNeeded bool default false, 
    primary key(adminId)
);

create table if not exists book(
    bookTitle varchar(100) not null default '',
    author varchar(100) not null default '',
    edition real not null default 0,
    publisher varchar(100) not null default '',
    ISBN integer not null,
    primary key (ISBN)
);
create table if not exists professor(
    profId integer not null auto_increment,    
    email varchar(100) not null default '',
    name varchar(100) not null default '',
    username varchar(100) default '', -- can be blank, blank triggers account creation
    password varchar(100) default '',
    -- useless for now, but will use if we implement a force password reset
    updateNeeded bool default false,
    primary key(profId)
);
-- tracks each book request by each professor in each semester
create table if not exists request(
    requestId integer not null auto_increment,
    profId integer not null,
    semester varchar(100) not null default '',
    ISBN integer not null,    
    primary key (requestId),
    foreign key (profId) references professor(profId),
    foreign key (ISBN) references book(ISBN)
);
-- default entries
insert into admin(username, password) values ("admin", "password");
