<?php
require_once 'dom.php';
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
      dom::textinput('first_name', 'First Name:'); 
      dom::textinput('last_name', 'Last Name:'); 
      dom::textinput('title', 'Title:'); 
      dom::textinput('date_joined', 'Date Joined:'); 
      dom::label('Type:');
      dom::dropdown('type', $types);
      dom::hidden('action', 'add_prof'); 
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

  $courses = all_course_data();

  dom::h3('section-title', 'Add Section:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('section_number', 'Section Number:');
      dom::textinput('crn', 'CRN:');
      dom::textinput('capacity', 'Capacity:');  
      dom::textinput('enrollment', 'Enrollment:'); 
      dom::textinput('room', 'Room:'); 
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
 * link sections and instructor
 * */
function add_teacher_to_section() {
  $teachers = all_teachers_data();
  $sections = all_sections_data();

  dom::h3('section-title', 'Link Instructor and Section:');
  dom::push_div('section');
    dom::push_form('index.php');

      dom::label('Instructor:');
      dom::dropdown('inst_id', $teachers);

      dom::label('section:');
      dom::dropdown('course_id', $sections);

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
      dom::dropdown('ta_hours', list_ta_hours());

      dom::hidden('action', 'link_inst_sect'); 
      dom::submit();
    dom::pop();
  dom::pop();
}
