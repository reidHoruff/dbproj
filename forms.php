<?
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
      dom::textinput('fname', 'First Name:'); 
      dom::textinput('lname', 'Last Name:'); 
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
 * add course form 
 * */
function add_course_form() {
  dom::h3('section-title', 'Add Course:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('c_number', 'Course Number:'); 
      dom::label('Type:');
      dom::dropdown('required', array('y' => "Required", "n" => "Elective"));
      dom::textinput('title', 'Title:'); 
      dom::textinput('desc', 'Description:'); 
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

  $teachers = array();
  $all_teachers = get_all_profs();
  while ($row = mysql_fetch_assoc($all_teachers)) {
    $teachers[$row['id']] = $row['first_name'] . " " . $row['last_name'];
  }

  $courses = array();
  $all_courses = get_all_courses();
  while ($row = mysql_fetch_assoc($all_courses)) {
    $courses[$row['course_num']] = $row['title'];
  }

  dom::h3('section-title', 'Add Section:');
  dom::push_div('section');
    dom::push_form('index.php');
      dom::textinput('section', 'Section Number:');
      dom::textinput('capacity', 'Capacity:');  
      dom::textinput('enrollment', 'Enrollment:'); 
      dom::textinput('room', 'Room:'); 
      dom::textinput('time', 'Time:'); 

      dom::label('Days:');
      dom::dropdown('type', $days);

      dom::label('Instructor:');
      dom::dropdown('teacher', $teachers);

      dom::label('Course:');
      dom::dropdown('crn', $courses);

      dom::label('Lecture:');
      dom::dropdown('f2f', array('ftf' => 'Face to face', 'dis' => 'Distance lecture'));

      dom::hidden('action', 'add_section'); 
      dom::submit();
    dom::pop();
  dom::pop();
}
