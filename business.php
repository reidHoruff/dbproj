<?php

/*
 * this is a preference page that is only available
 * for business admins that have logged int
 */

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';
require_once 'forms.php';

class business_admin_page extends base_page {

  function header_title() {
    return 'Busniess Admin Page for ' . $this->get_username();
  }

  function page_name() {
    return 'business.php';
  }

  /*
   * require business admin to be logged in
   */
  function require_business_login() {
    return true;
  }

  /*
   * this block handles all POST requests
   */
  function handle_post($post) {

    if ($action == 'instructor_history') {
      $n = $post['n'];
      $instructor = $post['instructor'];
      $_SESSION['instructor'] = $instructor;
      $_SESSION['n'] = $n;
    } else if ($action = 'see_teacher_prefs') {
      $year = $post['year'];
      $teacher_id = $post['teacher_id'];
      $_SESSION['year'] = $year;
    }
  }

  function render_body() {
    list_prof_past_courses_form();
  }
}

function list_prof_past_courses_form() {
  $courses = all_course_data();
  $instructors = all_teachers_data();
  $since_year = array();
  for ($i = 1; $i < 30; $i++) {
    $since_year[$i] = $i;
  }

  /*
   * currently selected values
   */
  $current_instructor = get($_SESSION, 'instructor');
  $current_n = get($_SESSION, 'n');

  dom::h3('section-title', 'View Instructor\'s Teaching History');
  dom::push_div('section');
    dom::push_form();
      dom::label('Instructor:');
      dom::dropdown('instructor', $instructors, $current_instructor, true);
      dom::label('Past Year:');
      dom::dropdown('n', $since_year, $current_n, true);
      dom::hidden('action', 'instructor_history');
    dom::pop();

    if (isset($_SESSION['instructor'])) {
      $teaching_history = list_teaching_history(
        $_SESSION['instructor'],
        CURRENT_YEAR - $_SESSION['n']
      );

      while ($row = mysql_fetch_assoc($teaching_history)) {
        dom::label($row['year']);
      }
    }
  dom::pop();
}

(new business_admin_page())->dump();
