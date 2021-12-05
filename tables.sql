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
    username varchar(100) default '',-- can be blank, blank triggers account creation
    password varchar(100) default '',
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

-- test data
INSERT into professor(email, name) values("danreplay3@gmail.com", "danny");
INSERT into professor(email, name) values("test@gmail.com", "Jacob");
INSERT into professor(email, name) values("randomEmail@gmail.com", "Dr. Bacon");

INSERT into book(ISBN, bookTitle, author, edition, publisher) values(1111, "The cat in the hat", "dr. seuss", 1, "some publisher");
INSERT into book(ISBN, bookTitle, author, edition, publisher) values(1112, "The book about nothing", "samuel nothing", 1, "some publisher");
INSERT into book(ISBN, bookTitle, author, edition, publisher) values(12312, "Coding for dummies", "for dummies guy", 1, "some publisher");
INSERT into book(ISBN, bookTitle, author, edition, publisher) values(312, "The key to happiness", "dr. success", 1, "some publisher");

INSERT into request(profId, isbn, semester) values(1, 12312, "Summer 2021");
INSERT into request(profId, isbn, semester) values(1, 312, "Summer 2021");
INSERT into request(profId, isbn, semester) values(1, 1111, "Fall 2021");
INSERT into request(profId, isbn, semester) values(1, 1112, "Fall 2021");
INSERT into request(profId, isbn, semester) values(1, 312, "Fall 2021");
INSERT into request(profId, isbn, semester) values(2, 1112, "Fall 2021");
INSERT into request(profId, isbn, semester) values(3, 312, "Fall 2021");
INSERT into request(profId, isbn, semester) values(3, 12312, "Fall 2021");
INSERT into request(profId, isbn, semester) values(3, 12312, "Spring 2022");
INSERT into request(profId, isbn, semester) values(3, 312, "Spring 2022");
