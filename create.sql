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

create table tas (
  id int not null AUTO_INCREMENT,
  first_name char(255) not null,
  last_name char(255) not null,
  primary key (id)
);

create table courses (
  id int not null AUTO_INCREMENT,
  code char(100) not null,
  required char(100) not null,
  is_lab char(10) not null,
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
  section_number char(100) not null,
  semester char(100) not null,
  enrollment int not null,
  room char(100) not null,
  lecture_type char(100) not null,
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

create table ta_to_section (
  section_id int,
  ta_id int,
  hours int,
  foreign key (section_id) references sections(id),
  foreign key (ta_id) references tas(id)
);

create table section_to_lab_section (
  section_id int,
  lab_section_id int,
  foreign key (section_id) references sections(id),
  foreign key (lab_section_id) references sections(id)
);


/**
data instructors
*/


insert into instructors (first_name, last_name, title, type, date_joined)
values ('Nelson', 'Rushton', 'CS Professor', 'tenured', '2000');

insert into instructors (first_name, last_name, title, type, date_joined)
values ('Richard', 'Watson', 'CS Professor', 'tenured', '2000');

insert into instructors (first_name, last_name, title, type, date_joined)
values ('Gregory', 'Gelfond', 'CS junior instructor', 'fti', '2010');

insert into instructors (first_name, last_name, title, type, date_joined)
values ('Namin', 'Akbar', 'CS professor', 'tenured', '2005');

insert into instructors (first_name, last_name, title, type, date_joined)
values ('Susan', 'Mengel', 'CS professor', 'tenured', '2000');

insert into instructors (first_name, last_name, title, type, date_joined)
values ('Y', 'Zhang', 'CS professor', 'tenured', '2005');

insert into instructors (first_name, last_name, title, type, date_joined)
values ('Noel', 'Lopez-Binetez', 'CS professor', 'tenured', '2000');

/**
data courses
*/

insert into courses (code, required, title, description, catalog) values
('CS1401', 'y', 'programming principles 1', '', 1);

insert into courses (code, required, title, description, catalog) values
('CS1402', 'y', 'programming principles 2', '', 1);

insert into courses (code, required, title, description, catalog) values
('CS2364', 'y', 'data structures', '', 1);

insert into courses (code, required, title, description, catalog) values
('CS3401', 'y', 'design and analasys of algorighms', '', 1);

insert into courses (code, required, title, description, catalog) values
('MATH2301', 'y', 'calculus II', '', 1);

/**
data books
*/

insert into books (isbn, title, publisher, edition) values
('3652037357', 'Intro to Java', 'McGraw', '12');

insert into books (isbn, title, publisher, edition) values
('65247534', 'Intro to C++', 'McGraw', '12');

insert into books (isbn, title, publisher, edition) values
('734730745', 'On Calculus Principles', 'McGraw', '100');


/**
data tas
*/

insert into tas (first_name, last_name) values
('Garrison', 'Ritchie');

insert into tas (first_name, last_name) values
('Jonathon', 'Montgomery');

insert into tas (first_name, last_name) values
('Reid', 'Horuff');

