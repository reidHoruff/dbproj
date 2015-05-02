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
    mysql_insert_dang('instructors', $_POST);
    set_message("Teacher successfully added.");
  } 
  
  /*
   * action for adding a book
   */
  else if ($_POST['action'] == 'add_book') {
    mysql_insert_dang('books', $_POST);
    set_message("Text book successfully added.");
  }

  /*
   * action for adding a course
   */
  else if ($_POST['action'] == 'add_course') {
    mysql_insert_dang('courses', $_POST);
    set_message("Course successfully added.");
  }  

  /*
   * action for adding a ta
   */
  else if ($_POST['action'] == 'add_ta') {
    mysql_insert_dang('tas', $_POST);
    set_message("Course successfully added.");
  }  
  
  
  /*
   * action for adding a section
   */
  else if ($_POST['action'] == 'add_section') {
    mysql_insert_dang('sections', $_POST);
    set_message("Section successfully added.");
  } 

  /*
   * link section and instructor
   */
  else if ($_POST['action'] == 'link_inst_sect') {
    mysql_insert_dang('instructor_to_section', $_POST);
    set_message("Section and instructor successfully linked.");
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
add_ta_form();

add_teacher_to_section();
add_ta_to_section();
/* dump HTML */
dom::dump();
