<?php
require_once 'dom.php';

const CURRENT_YEAR = 2015;
const CURRENT_SEMESTER = 'Spring 2015';

/**
 * list semesters
 */
function list_semesters() {
  $semesters = array();
  for ($i = CURRENT_YEAR; $i < CURRENT_YEAR + 3; $i++) {
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
    $teachers[$row['id']] = $row['username'] . ' - ' . $row['first_name'] . " " . $row['last_name'];
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

function all_eraiders_data() {
  $data = array();
  $all = get_all_eraiders();
  while ($row = mysql_fetch_assoc($all)) {
    $data[$row['username']] = $row['username'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'];
  }
  return $data;
}

/*
 *
 * php sucks...
 */
function bool($b) {
  if ($b) {
    return 'true';
  } else {
    return 'false';
  }
}

function get($arr, $key, $default=null) {
  if (isset($arr[$key])) {
    return $arr[$key];
  } else {
    return $default;
  }
}


