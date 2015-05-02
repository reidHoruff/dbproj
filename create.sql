drop database if exists dbproj;
create database dbproj;
use dbproj;

create table instructors (
  id int not null AUTO_INCREMENT,
  first_name char(255) not null,
  last_name char(255) not null,
  title char(255) not null,
  type char (255) not null, /* [tenured, untenured, fti, gpti] */
  date_joined char(255) not null,
  primary key (id)
);

create table courses (
  id int not null AUTO_INCREMENT,
  code char(100) not null,
  required char(100) not null,
  title char(100) not null,
  description char(100),
  catalog int not null,
  primary key (id)
);

create table sections (
  id int not null AUTO_INCREMENT,
  course_id int,
  capacity int not null,
  days char(100) not null,
  semester char(100) not null,
  enrollment int not null,
  room char(100) not null,
  time char(255) not null,
  crn char(255) not null,
  foreign key (course_id) references courses(id),
  primary key (id)
);

create table books (
  id int not null AUTO_INCREMENT,
  isbn char(255) not null,
  title char(255) not null,
  publisher char(255) not null,
  edition char(255) not null,
  primary key (id)
);


/*
 * links
**/

create table instructor_to_section (
  instructor_id int,
  section_id int,
  foreign key (instructor_id) references instructors(id),
  foreign key (section_id) references sections(id)
);

create table section_to_lab_section (
  section_id int,
  lab_section_id int,
  foreign key (section_id) references sections(id),
  foreign key (lab_section_id) references sections(id)
);
