<?php
session_start();

require_once 'db.php';
require_once 'helpers.php';

function set_message($m) {
  global $_SESSION;
  $_SESSION['message'] = $m;
}

function get_message() {
  return $_SESSION['message'];
}

function set_error($e) {
  global $_SESSION;
  $_SESSION['error'] = $e;
}

function get_error() {
  return $_SESSION['error'];
}

/*
 * this block handels all POST requests
 */
if (isset($_POST['action'])) {

  /* 
   * action for adding a professor 
   */
  if ($_POST['action'] == 'add_prof') {
    create_professor($_POST['fname'], $_POST['lname'], $_POST['title'], $_POST['type'], $_POST['date_joined']); 
    set_message("Teacher successfully added.");
  } 
  
  /*
   * action for adding a book
   */
  else if ($_POST['action'] == 'add_book') {
    create_book($_POST['title'], $_POST['publisher'], $_POST['edition'], $_POST['isbn']); 
    set_message("Text book successfully added.");
  }

  /*
   * action for adding a course
   */
  else if ($_POST['action'] == 'add_course') {
    create_course($_POST['c_number'], $_POST['title'], $_POST['desc']); 
    set_message("course successfully added.");
  }  
  
  else {
  }

  /*
   * after POST save messages in session and redirect
   * to same page but with a GET to avoid
   * annoying POST resubmission messages
   * on the browser's end.
   */
  set_error(mysql_error());
  header("Location: index.php");
  die();
} 

/* 
 * begin HTML rendering... 
 */
dom_init();
push_body();

/*
 * this displays the last error that mySQL encountered, if any,
 * and displays it. else it displays the user message if any.
 *
 * This works pretty well assuming that a single query/operation is
 * mode per POST.
 */
$mysql_error = get_error();
$message = get_message();

if ($mysql_error) {
  push_div('error');
  gen_h3('', $mysql_error);
  dom_pop();
} 

else if ($message) {
  push_div('message');
  gen_h3('', $message);
  dom_pop();
}

/*
 * now clear messages...
 */
set_message(null);
set_error(null);

/* 
 * add instructor form 
 */
$types = array(
  "tenured" => "Tenured Professor",
  "untenured" => "Untenured Professor",
  "fti" => "FTI",
  "gpti" => "GPTI",
);
gen_h3('section-title', 'Add Instructor:');
push_div('section');
push_form('index.php');
gen_textinput('fname', 'First Name:'); 
gen_textinput('lname', 'Last Name:'); 
gen_textinput('title', 'Title:'); 
gen_textinput('date_joined', 'Date Joined:'); 
gen_dropdown('type', $types);
gen_hidden('action', 'add_prof'); 
gen_submit();
dom_pop();
dom_pop();

/* 
 * add text book form 
 * */
gen_h3('section-title', 'Add Text Book:');
push_div('section');
push_form('index.php');
gen_textinput('title', 'Title:'); 
gen_textinput('publisher', 'Publisher:'); 
gen_textinput('edition', 'Edition:'); 
gen_textinput('isbn', 'ISBN:'); 
gen_hidden('action', 'add_book'); 
gen_submit();
dom_pop();
dom_pop();

/* 
 * add course form 
 * */
gen_h3('section-title', 'Add Course:');
push_div('section');
push_form('index.php');
gen_textinput('c_number', 'Course Number:'); 
gen_textinput('title', 'Title:'); 
gen_textinput('desc', 'Description:'); 
gen_hidden('action', 'add_course'); 
gen_submit();
dom_pop();
dom_pop();

/*
 * list professors
 */
$profs = get_all_profs();
$names = array();
while ($row = mysql_fetch_assoc($profs)) {
  $names[] = $row['first_name'];
}
gen_h3('section-title', 'List Professors');
push_div('section');
gen_ul($names);
dom_pop();

/*
 * list books
 */
$books = get_all_books();
$names = array();
while ($row = mysql_fetch_assoc($books)) {
  $names[] = $row['title'];
}
gen_h3('section-title', 'List Text Books:');
push_div('section');
gen_ul($names);
dom_pop();

/*
 * list courses
 */
$courses = get_all_courses();
$names = array();
while ($row = mysql_fetch_assoc($courses)) {
  $names[] = $row['title'];
}
gen_h3('section-title', 'List Courses:');
push_div('section');
gen_ul($names);


/* dump HTML */
dom_dump();
