drop database if exists dbproj;
create database dbproj;
use dbproj;

create table profs (
  id int not null AUTO_INCREMENT,
  first_name char(255) not null,
  last_name char(255) not null,
  title char(255) not null,
  type char (255) not null, /* [tenured, untenured, fti, gpti] */
  date_joined char(255) not null,
  primary key (id)
);

create table courses (
  course_num char(100) not null,
  title char(100) not null,
  description char(100),
  catalog int not null,
  primary key (course_num)
);

create table sections (
  course_num char(100) not null,
  section char(100) not null,
  capacity int not null,
  days char(100) not null,
  enrollment int not null,
  room char(100) not null,
  time char(255) not null,
  crn char(255) not null,
  primary key (crn),
  foreign key (course_num) references courses(course_num)
);

create table books (
  isbn char(255) not null,
  title char(255) not null,
  publisher char(255) not null,
  edition char(255) not null,
  primary key (isbn)
);
