<?php

/*
 * this page is for debugging.
 * lists various schemas and tables.
 * will eventually allow SQL execution for forther
 * dubugging purposes.
 */

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';

/*
 * list professors
 */
function list_instructors() {
  $profs = get_all_profs();
  $names = array();
  while ($row = mysql_fetch_assoc($profs)) {
    $names[] = $row['username'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'];
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
    $names[] = $row['title'] . ' - ' . $row['isbn'] . ' - ' . $row['publisher'];
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


class list_page extends base_page {

  function header_title() {
    return 'Lists for debugging';
  }

  function page_name() {
    return 'lists.php';
  }

  /*
   * this block handles all POST requests
   */
  function handle_post($post) {
    /* 
     * action for adding a professor 
     */
    if ($_POST['action'] == 'sql') {
    } 

    else {
    }
    /*
     * after POST save messages in session and redirect
     * to same page but with a GET to avoid
     * annoying POST resubmission messages
     * on the browser's end.
     */
    if (mysql_error()) {
      $this->set_error(mysql_error());
    }
  }

  function render_body() {
    dom::h3('', 'Raw SQL');
    dom::push_form('lists.php');
      dom::textarea("sql");
      dom::br();
      dom::hidden('action', 'sql');
      dom::submit();
    dom::pop();
    list_instructors();
    list_sections();
    list_books();
    list_courses();
  }
}

(new list_page())->dump();
