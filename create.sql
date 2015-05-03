drop database if exists dbproj;
create database dbproj;
use dbproj;

/*
passwords shouldn't be stored in plaintext...
*/

create table eraiders (
  username char(255) not null,
  first_name char(255) not null,
  last_name char(255) not null,
  password char(255) not null,
  primary key (username)
);

create table instructors (
  id int not null AUTO_INCREMENT,
  username char(255) not null,
  title char(255) not null,
  type char (255) not null, /* [tenured, untenured, fti, gpti] */
  date_joined char(255) not null,
  foreign key (username) references eraiders(username),
  primary key (id)
);

create table load_preference (
  username char(255) not null,
  load_preference char(255) not null,
  /*
  fall, spring, none
  */
  foreign key (username) references eraiders(username)
);

/**
this trigger creates a 'load_prefernce' row when an instructor
is created of type instuctor'
*/
delimiter |
create trigger default_load_preference after insert on instructors 
  for each row begin
    if (new.type = 'tenured' or new.type = 'untenured') then
      insert into load_preference (username, load_preference)
      values
      (new.username, 'none');
    end if;
  end|
delimiter ;

create table special_requests (
  username char(255) not null,
  course_id int,
  title char(255) not null,
  justification text not null,
  foreign key (username) references instructors(username),
  foreign key (username) references eraiders(username)
);

/*
this vie gives us easy access to the professors,
that is, instructors of type professor [tenured, or untenured]
*/
create VIEW profs AS SELECT first_name from
eraiders INNER JOIN instructors ON
eraiders.username=instructors.username 
WHERE instructors.type='tenured' OR instructors.type='untenured';

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
  building char(100) not null,
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

create table prof_prefs(
  course_id int,
  username char(255),
  pref int,
  year int,
  foreign key (course_id) references courses(id),
  foreign key (username) references instructors(username)
);

create view prof_course_preferences as 
SELECT * FROM
courses LEFT JOIN prof_prefs on courses.id=prof_prefs.course_id;


/**
data eraiders
*/

insert into eraiders (first_name, last_name, username, password)
values ('Nelson', 'Rushton', 'n.rushton', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('Richard', 'Watson', 'r.watson', 'foor');

insert into eraiders (first_name, last_name, username, password)
values ('Y', 'Zhang', 'y.zhang', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('reid', 'horuff', 'thoruff', 'foo');


/**
data instructors
*/

insert into instructors (username, title, type, date_joined)
values ('n.rushton', 'CS Professor', 'tenured', '2000');

insert into instructors (username, title, type, date_joined)
values ('r.watson', 'CS Professor', 'tenured', '2000');

insert into instructors (username, title, type, date_joined)
values ('y.zhang', 'CS Professor', 'tenured', '2000');


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

