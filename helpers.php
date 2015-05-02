<?
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
