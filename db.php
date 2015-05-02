<?php

/*
 * everything here is susceptible to injection
 * but thats fine.
 */

$username = "root3";
$password = "root";
$server = "localhost";
$dbname = 'dbproj';

$conn = mysql_connect($server, $username, $password);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

mysql_select_db($dbname);


//Creation Functions
function create_professor($fname, $lname, $title, $type, $date_joined) {
  mysql_query("insert into instructors (first_name, last_name, title, type, date_joined) values ('$fname', '$lname', '$title', '$type', '$date_joined');");
}

function create_book($title, $publisher, $edition, $isbn) {
  mysql_query("insert into books (title, publisher, edition, isbn) values ('$title', '$publisher', '$edition', '$isbn');");
}

function create_course($code, $title, $desc, $required){
  mysql_query("insert into courses (code, title, description, required) values ('$code', '$title', '$desc', '$required')");
}

function create_section($course_id, $section, $capacity, $days, $enrollment, $room, $time, $crn){
  mysql_query("insert into sections (course_id, section, capacity, days, enrollment, room, time, crn) values ('$c_number', '$section', '$capacity', '$days', '$enrollment', '$room', '$time', '$crn');");
}

function link_instructor_section($inst_id, $course_id){
  mysql_query("insert into instructor_to_section (instructor_id, section_id) values ('$inst_id', '$course_id')");
}

//Getting Functions
function get_all_profs() {
  return mysql_query("select * from instructors;");
}

function get_all_books() {
  return mysql_query("select * from books;");
}

function get_all_courses(){
  return mysql_query("select * from courses;");
}

function get_all_sections(){
  return mysql_query("select * from sections;");
}
