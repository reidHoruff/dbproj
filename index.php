<?php
session_start();

require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';
require_once 'forms.php';

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
 * this block handles all POST requests
 */
if (isset($_POST['action'])) {

  /* 
   * action for adding a professor 
   */
  if ($_POST['action'] == 'add_prof') {
    create_professor(
      $_POST['fname'], 
      $_POST['lname'], 
      $_POST['title'], 
      $_POST['type'], 
      $_POST['date_joined']
    ); 
    set_message("Teacher successfully added.");
  } 
  
  /*
   * action for adding a book
   */
  else if ($_POST['action'] == 'add_book') {
    create_book(
      $_POST['title'], 
      $_POST['publisher'], 
      $_POST['edition'], 
      $_POST['isbn']
    ); 
    set_message("Text book successfully added.");
  }

  /*
   * action for adding a course
   */
  else if ($_POST['action'] == 'add_course') {
    create_course(
      $_POST['c_number'], 
      $_POST['title'], 
      $_POST['desc']
    ); 
    set_message("Course successfully added.");
  }  
  
  /*
   * action for adding a section
   */
  else if ($_POST['action'] == 'add_section') {
    create_section(
      $_POST['c_number'], 
      $_POST['section'], 
      $_POST['capacity'], 
      $_POST['days'],  
      $_POST['enrollment'], 
      $_POST['room'], 
      $_POST['time'], 
      $_POST['crn']
    ); 
    set_message("Section successfully added.");
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
dom::init();
dom::push_body();

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
  dom::push_div('error');
    dom::h3('', $mysql_error);
  dom::pop();
} 

else if ($message) {
  dom::push_div('message');
    dom::h3('', $message);
  dom::pop();
}

/*
 * now clear messages...
 */
set_message(null);
set_error(null);

add_instructor_form();
add_course_form();
add_section_form();
add_text_book_form();

/* dump HTML */
dom::dump();
