-- When opening mysql from terminal, run "mysql -u root -p < [path to tables.sql]",

create database if not exists db;
use db;

create table if not exists admin (
	adminId integer not null auto_increment,
    username varchar(100) not null unique,
    password varchar(100) not null,
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
    email varchar(100) not null unique,
    name varchar(100) not null,
    username varchar(100) unique,-- can be blank, blank triggers account creation
    password varchar(100),
    primary key(profId)
);

-- tracks each book request by each professor in each semester
create table if not exists request(
	-- easier tracking in code
    requestId integer not null auto_increment unique,
    profId integer not null,
    semester varchar(100) not null,
    ISBN integer not null,
    -- makes each request per semester unique
    primary key (profId, ISBN, semester),
    foreign key (profId) references professor(profId),
    foreign key (ISBN) references book(ISBN)
);

-- tracks the current semester
create table if not exists currentSemester(
    semester varchar(100) not null,
    year integer not null
);

create table if not exists reminder(
    reminder date,
    primary key(reminder)
);

-- default entries
insert into admin(username, password) values ("admin", "password");
insert into currentSemester(semester, year) values ("Spring", 2022);
