<?php

/*
 * file that contains various forms.
 */

require_once 'dom.php';

/**
 * add eraider
 */
function add_eraider_form() {
  dom::h3('section-title', 'Add Eraider:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('first_name', 'First Name:'); 
      dom::textinput('last_name', 'Last Name:'); 
      dom::textinput('username', 'Username:'); 
      dom::password('password', 'Temp Password:'); 
      dom::password('password2', 'Confirm Pass:'); 
      dom::hidden('action', 'add_eraider'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * add instructor form 
 */
function add_instructor_form() {
  $types = array(
    "tenured" => "Tenured Professor",
    "untenured" => "Untenured Professor",
    "fti" => "FTI",
    "gpti" => "GPTI",
  );
  dom::h3('section-title', 'Add Instructor:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::label('Username:');
      dom::dropdown('username', all_eraiders_data());
      dom::textinput('title', 'Title:'); 
      dom::textinput('date_joined', 'Date Joined:'); 
      dom::label('Type:');
      dom::dropdown('type', $types);
      dom::hidden('action', 'add_instructor'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * link business admin form
 */
function link_business_admin_form() {
  dom::h3('section-title', 'Make business admin:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::label('Username:');
      dom::dropdown('username', all_eraiders_data());
      dom::hidden('action', 'add_business_admin'); 
      dom::submit();
    dom::pop();
  dom::pop();
}


/* 
 * add text book form 
 * */
function add_text_book_form() {
  dom::h3('section-title', 'Add Text Book:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('title', 'Title:'); 
      dom::textinput('publisher', 'Publisher:'); 
      dom::textinput('edition', 'Edition:'); 
      dom::textinput('isbn', 'ISBN:'); 
      dom::hidden('action', 'add_book'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * add TA Form
 * */
function add_ta_form() {
  dom::h3('section-title', 'Add TA:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('first_name', 'First name:'); 
      dom::textinput('last_name', 'Last name:'); 
      dom::hidden('action', 'add_ta'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * add course form 
 * */
function add_course_form() {
  dom::h3('section-title', 'Add Course:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('code', 'Course Number:'); 
      dom::label('Type:');
      dom::dropdown('required', array('y' => "Required", "n" => "Elective"));
      dom::label('Lab:');
      dom::dropdown('is_lab', array('n' => "no", "y" => "yes"));
      dom::textinput('title', 'Title:'); 
      dom::textinput('description', 'Description:'); 
      dom::hidden('action', 'add_course'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/*
 * add section form
 * */
function add_section_form() {
  $days = array(
    "mwf" => "M/W/F",
    "tth" => "T/Th",
  );

  $buildings = array(
    "Honlden Hall" => "Holden Hall",
    "Computer Science" => "Computer Science",
    "Electrical Engineering" => "Electrical Engineering",
    "Civil Engineering" => "Civil Engineering"
  );

  $courses = all_course_data();

  dom::h3('section-title', 'Add Section:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('section_number', 'Section Number:');
      dom::textinput('crn', 'CRN:');
      dom::textinput('capacity', 'Capacity:');  
      dom::textinput('enrollment', 'Enrollment:'); 
      dom::textinput('room', 'Room:'); 

      dom::label('Building:');
      dom::dropdown('building', $buildings);

      dom::textinput('time', 'Time:'); 

      dom::label('Course:');
      dom::dropdown('course_id', $courses);

      dom::label('Days:');
      dom::dropdown('days', $days);

      dom::label('Semester:');
      dom::dropdown('semester', list_semesters());


      dom::label('Lecture Style:');
      dom::dropdown('lecture_type', array('ftf' => 'Face to face', 'dis' => 'Distance lecture'));

      dom::hidden('action', 'add_section'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * link instructor to section
 * */
function add_teacher_to_section() {
  $teachers = all_teachers_data();
  $sections = all_sections_data();

  dom::h3('section-title', 'Link Instructor and Section:');
  dom::push_div('section');
    dom::push_form('index.php');

      dom::label('Instructor:');
      dom::dropdown('instructor_id', $teachers);

      dom::label('section:');
      dom::dropdown('section_id', $sections);

      dom::hidden('action', 'link_inst_sect'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * link ta to section
 * */
function add_ta_to_section() {
  $tas = all_ta_data();
  $sections = all_sections_data();

  dom::h3('section-title', 'Link TA and Section:');
  dom::push_div('section');
    dom::push_form('index.php');

      dom::label('TA:');
      dom::dropdown('ta_id', $tas);

      dom::label('Section:');
      dom::dropdown('section_id', $sections);

      dom::label('Weekly Hours');
      dom::dropdown('hours', list_ta_hours());

      dom::hidden('action', 'link_ta_to_section'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/* 
 * login page
 * */
function login_form() {

  dom::h3('section-title', 'login:');
  dom::push_div('section');
    dom::push_form('login.php');
      dom::textinput('username', "Username:");
      dom::password('password', "Password:");
      dom::hidden('action', 'instructor_login'); 
      dom::submit();
    dom::pop();
  dom::pop();
}

/*
 * course prefernce form for professor
 * preferences page.
 */
function prof_course_pref_form($username) {
  $course_pref_options = array(
    "none" => "none",
    "1" => "1",
    "2" => "2",
    "3" => "3"
  );
  dom::h3('section-title', 'Course Preferences for ' . CURRENT_YEAR);
  dom::push_div('section');
  $prefs = get_prefs_for_prof($username);
  while ($row = mysql_fetch_assoc($prefs)) {
    $default = $row['pref'];
    dom::push_div('course');
      dom::push_form('prefs.php');
        dom::label($row['code'] . ' - ' . $row['title']);
        dom::dropdown('pref', $course_pref_options, $default, true);
        dom::hidden('year', CURRENT_YEAR);
        dom::hidden('username', $username);
        dom::hidden('course_id', $row['id']);
        dom::hidden('action', 'update_course_prefs');
      dom::pop();
    dom::pop();
  }
  dom::pop();
}

/*
 * load preference form for professor
 * preference page.
 */
function prof_load_pref_form($username) {
  $load_pref_options = array(
    'none' => 'no preference',
    'fall' => "fall",
    'spring' => "spring"
  );

  $current_load_pref = get_load_preference($username);

  dom::h3('section-title', 'Teaching Load Preference');
  dom::push_div('section');
    dom::push_form('prefs.php');
      dom::dropdown('pref', $load_pref_options, $current_load_pref, true);
      dom::hidden('action', 'update_load_pref');
    dom::pop();
  dom::pop();
}

/*
 * special request form for professors that are logged in
 */
function prof_special_request_form($username) {
  $courses = all_course_data();

  dom::h3('section-title', 'Special Reqeusts');
  dom::push_div('section');
    dom::push_form('prefs.php');
      dom::label('Course:');
      dom::dropdown('course_id', $courses);
      dom::textinput('title', 'Title');
      dom::label('Justification');
      dom::textarea('justification');
      dom::hidden('username', $username);
      dom::hidden('action', 'special_request');
      dom::br();
      dom::submit();
    dom::pop();
  dom::pop();
}
