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

create table sections (
  id int not null AUTO_INCREMENT,
  section char(100) not null,
  capacity int not null,
  days char(100) not null,
  enrollment int not null,
  room char(100) not null,
  time char(255) not null,
  crn char(255) not null,
  primary key (id)
);

create table courses (
  id int not null AUTO_INCREMENT,
  section char(100) not null,
  capacity int not null,
  days char(100) not null,
  enrollment int not null,
  room char(100) not null,
  time char(255) not null,
  crn char(255) not null,
  primary key (id)
);

create table books (
  id int not null AUTO_INCREMENT,
  title char(255) not null,
  publisher char(255) not null,
  edition char(255) not null,
  isbn char(255) not null,
  primary key (id)
);
