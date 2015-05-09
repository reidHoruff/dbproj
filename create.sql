drop database if exists dbproj;
create database dbproj;
use dbproj;

/*
 *passwords shouldn't be stored in plaintext...
 */

 
 /*
  * Eraiders account table includes eraider account info
  * and name.
  */
create table eraiders (
  username char(255) not null,
  first_name char(255) not null,
  last_name char(255) not null,
  password char(255) not null,
  primary key (username)
);


/*
 * Instructors table includes instructors info.
 * Instructors must have an eraider account before insertion.
 * The tables eraiders and instructors link on username.
 */
create table instructors (
  id int not null AUTO_INCREMENT,
  username char(255) not null,
  title char(255) not null,
  type char (255) not null, /* [tenured, untenured, fti, gpti] */
  date_joined char(255) not null,
  foreign key (username) references eraiders(username),
  primary key (id)
);

/*
 * Site admins with elevated access to debugging
 * Buisiness admins must have eraider account before insertion.
 * The tables eraiders and business admin link on username.
 */
create table business_admins (
  id int not null AUTO_INCREMENT,
  username char(255) not null,
  foreign key (username) references eraiders(username),
  primary key (id)
);

/*
 * This table denotes what semester the teacher has a preference for
 * teaching in. It links to the instructors table on username.
 */
create table load_preference (
  username char(255) not null,
  load_preference char(255) not null,
  /*
  fall, spring, none
  */
  foreign key (username) references instructors(username)
);

/*
 *this trigger creates a 'load_prefernce' row when an instructor
 *is created of type instuctor'
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

/*
 * This table denotes a request for a teacher to teach a class
 * and the justification for why they believe they should teach the
 * class. The table links to the instructors table on username.
 */
create table special_requests (
  username char(255) not null,
  course_id int,
  title char(255) not null,
  justification text not null,
  foreign key (username) references instructors(username)
);

/*
 * This view gives us easy access to the professors,
 * that is, instructors of type professor [tenured, or untenured]
 */
create VIEW profs AS SELECT first_name from
eraiders INNER JOIN instructors ON
eraiders.username=instructors.username 
WHERE instructors.type='tenured' OR instructors.type='untenured';

/*
 * TA's table 
 */
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
  is_lab char(10) not null default 'n',
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
  year int,
  enrollment int not null,
  building char(100) not null,
  room char(100) not null,
  lecture_type char(100) not null,
  time char(255) not null,
  crn char(5) not null,
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

CREATE VIEW full_sections AS 
SELECT 
  instructors.id AS inst_id,
  capacity, 
  days, 
  section_number, 
  semester, 
  enrollment, 
  lecture_type, 
  time, 
  crn,
  eraiders.username AS inst_username,
  first_name,
  last_name,
  year
FROM
courses 
INNER JOIN sections ON courses.id=sections.course_id
INNER JOIN instructor_to_section ON sections.id=instructor_to_section.section_id
INNER JOIN instructors ON instructors.id=instructor_to_section.instructor_id
INNER JOIN eraiders ON instructors.username=eraiders.username;

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


/*
 * Dummy data eraider inserts
 */

insert into eraiders (first_name, last_name, username, password)
values ('Nelson', 'Rushton', 'n.rushton', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('Richard', 'Watson', 'r.watson', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('Namin', 'Akbar', 'n.akbar', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('Susan', 'Mengel', 's.mengle', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('Y', 'Zhang', 'y.zhang', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('reid', 'horuff', 'thoruff', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('garrison', 'ritchie', 'gritchie', 'foo');

insert into eraiders (first_name, last_name, username, password)
values ('jonathan', 'montgomery', 'jmontgomery', 'foo');


/*
 *dummy data instructors inserts
 */

insert into instructors (username, title, type, date_joined)
values ('n.rushton', 'CS Professor', 'tenured', '2000');

insert into instructors (username, title, type, date_joined)
values ('r.watson', 'CS Professor', 'tenured', '2000');

insert into instructors (username, title, type, date_joined)
values ('y.zhang', 'CS Professor', 'tenured', '2000');


/*
 *data courses
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


/*
 *data tas
 */

insert into tas (first_name, last_name) values
('Garrison', 'Ritchie');

insert into tas (first_name, last_name) values
('Jonathan', 'Montgomery');

insert into tas (first_name, last_name) values
('Reid', 'Horuff');

