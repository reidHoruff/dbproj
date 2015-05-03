<?php

/*
 * everything here is susceptible to injection
 * but thats fine.
 */

$username = "root";
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

function create_ta($fname, $lname) {
  mysql_query("insert into tas (first_name, last_name) values ('$fname', '$lname');");
}

function create_book($title, $publisher, $edition, $isbn) {
  mysql_query("insert into books (title, publisher, edition, isbn) values ('$title', '$publisher', '$edition', '$isbn');");
}

function create_course($code, $title, $desc, $required){
  mysql_query("insert into courses (code, title, description, required) values ('$code', '$title', '$desc', '$required')");
}

function create_section($course_id, $section, $capacity, $days, $enrollment, $room, $time, $crn){
  mysql_query("insert into sections (course_id, section_number, capacity, days, enrollment, room, time, crn) values ('$course_id', '$section', '$capacity', '$days', '$enrollment', '$room', '$time', '$crn');");
}

function link_instructor_section($inst_id, $course_id){
  mysql_query("insert into instructor_to_section (instructor_id, section_id) values ('$inst_id', '$course_id')");
}

function link_ta_section($ta_id, $section_id, $hours){
  mysql_query("insert into ta_to_section (section_id, ta_id, hours) values ('$ta_id', '$section_id', '$hours')");
}

//Getting Functions
function get_all_profs() {
  return mysql_query("select * from instructors inner join eraiders on instructors.username=eraiders.username;");// or die(mysq_ery());
}

function get_prefs_for_prof($username) {
  return mysql_query("select * from courses left join (select * from prof_prefs where username='$username') as t on courses.id=t.course_id;");
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

function get_all_tas(){
  return mysql_query("select * from tas;");
}

function get_all_eraiders(){
  return mysql_query("select * from eraiders;");
}

function get_load_preference($username) {
  return mysql_result(mysql_query("select load_preference from load_preference where username='$username'"), 0);
}

function update_load_preference($username, $pref) {
  mysql_query("update load_preference set load_preference='$pref' where username='$username';");
}

function delete_existing_pref($username, $course_id) {
  $year = CURRENT_YEAR;
  mysql_query("delete from prof_prefs where username='$username' and year='$year' and course_id='$course_id';");
}

function get_sections_assigned_to($username, $semester) {
  return mysql_query("select * from sections inner join instructor_to_section on sections.id=instructor_to_section.section_id inner join courses on courses.id=sections.course_id where instructor_to_section.instructor_id=(select id from instructors where username='$username') and sections.semester='$semester';");
}

/**
 * login functions
 */

function instructor_login($username, $password) {
  return mysql_result(mysql_query("select count(*) from instructors inner join eraiders on instructors.username=eraiders.username where eraiders.username='$username' and eraiders.password='$password'"), 0);
}

/**
 * **we understand that this isn't necessarily
 * the best practice.**
 *
 * this takes a key values pair
 * and assumes them to be a mapping of
 * column names and data for that column and
 * inserts the data into a new row in $table.
 *
 * $values = array(
 * "name" => "joe",
 * "age" => "35"
 * );
 *
 * becomes
 *
 * insert into people (name, age) values ("joe", "35");
 */
function mysql_insert_dang($table, $values, $exclude = array()) {
  unset($values['action']);
  echo $values;
  foreach ($values as $key => $value) {
    if (in_array($key, $exclude)) {
      unset($values[$key]);
    } else {
      $values[$key] = '"' . mysql_real_escape_string($value) . '"';
    }
  }
  $sql = "insert into $table"
    . '(' . implode(',', array_keys($values)) . ')'
    . 'values'
    . '(' . implode(',', $values) . ');';
  echo $sql;
  mysql_query($sql);
}
