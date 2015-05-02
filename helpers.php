<?php
require_once 'dom.php';

/*
 * list professors
 */
function list_professors() {
  $profs = get_all_profs();
  $names = array();
  while ($row = mysql_fetch_assoc($profs)) {
    $names[] = $row['first_name'];
  }
  dom::h3('section-title', 'List Professors');
  dom::push_div('section');
    dom::ul($names);
  dom::pop();
}

/*
 * list books
 */
function list_books() {
  $books = get_all_books();
  $names = array();
  while ($row = mysql_fetch_assoc($books)) {
    $names[] = $row['title'];
  }
  dom::h3('section-title', 'List Text Books:');
  dom::push_div('section');
    dom::ul($names);
  dom::pop();
}

/*
 * list courses
 */
function list_courses() {
  $courses = get_all_courses();
  $names = array();
  while ($row = mysql_fetch_assoc($courses)) {
    $names[] = $row['title'];
  }
  dom::h3('section-title', 'List Courses:');
  dom::push_div('section');
    dom::ul($names);
  dom::pop();
}

/*
 * list sections
 */
function list_sections() {
  $sections = get_all_sections();
  $names = array();
  while ($row = mysql_fetch_assoc($sections)) {
    $names[] = $row['crn'];
  }
  dom::h3('section-title', 'List Sections:');
  dom::push_div('section');
    dom::ul($names);
  dom::pop();
}

/**
 * list semesters
 */
function list_semesters() {
  $semesters = array();
  for ($i = 2015; $i < 2017; $i++) {
    $str = 'Spring ' . $i;
    $semesters[$str] = $str;
    $str = 'Fall ' . $i;
    $semesters[$str] = $str;
    $str = 'Summer I ' . $i;
    $semesters[$str] = $str;
    $str = 'Summer II ' . $i;
    $semesters[$str] = $str;
  }
  return $semesters;
}

/**
 * list TA hours
 */
function list_ta_hours() {
  $hours = array();
  for ($i = 1; $i <= 20; $i++) {
    $hours[$i] = $i;
  }
  return $hours;
}


/**
 * aggregates all data from schemas for
 * the purpose of html drop down selectors
 */

function all_teachers_data() {
  $teachers = array();
  $all_teachers = get_all_profs();
  while ($row = mysql_fetch_assoc($all_teachers)) {
    $teachers[$row['id']] = $row['first_name'] . " " . $row['last_name'];
  }
  return $teachers;
}

function all_sections_data() {
  $sections = array();
  $all_sections = get_all_sections();
  while ($row = mysql_fetch_assoc($all_sections)) {
    $sections[$row['id']] = $row['crn'];
  }
  return $sections;
}

function all_course_data() {
  $courses = array();
  $all_courses = get_all_courses();
  while ($row = mysql_fetch_assoc($all_courses)) {
    $courses[$row['id']] = $row['code'] . ' - ' . $row['title'];
  }
  return $courses;
}

function all_ta_data() {
  $tas = array();
  $all_tas = get_all_tas();
  while ($row = mysql_fetch_assoc($all_tas)) {
    $tas[$row['id']] = $row['first_name'] . ' ' . $row['last_name'];
  }
  return $tas;
}


