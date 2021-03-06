<?php

/*
 * this is a preference page that is only available
 * for professors that have logged in.
 */

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';
require_once 'forms.php';

class prefs_page extends base_page {

  function header_title() {
    return 'Preferences Page for ' . $this->get_username();
  }

  function page_name() {
    return 'prefs.php';
  }

  /*
   * require instructor to be logged in
   */
  function require_inst_login() {
    return true;
  }

  /*
   * this block handles all POST requests
   */
  function handle_post($post) {

    /**
     * action is to update course pref.
     * old preference is deleted if exists
     * and new one is added only if preference is not 'none'
     */
    if ($post['action'] == 'update_course_prefs') {
      delete_existing_pref($this->get_username(), $post['course_id']);
      if ($post['pref'] != 'none') {
        mysql_insert_dang('prof_prefs', $post);
      }
    }

    /*
     * action is to update load distribution.
     * A preference for this already exists because
     * one was is created via a trigger when an professor
     * is added.
     */
    else if ($post['action'] == 'update_load_pref') {
      update_load_preference($this->get_username(), $post['pref']);
    }

    /*
     * create special request
     */
    else if ($post['action'] == 'special_request') {
      mysql_insert_dang('special_requesta', $post);
      $this->set_message("special request submitted.");
    }

    /*
     * set semester
     */
    else if ($post['action'] == 'set_semester') {
      $_SESSION['semester'] = $post['semester'];
      $_SESSION['year'] = $post['year'];
    }

    else {
    }
  }

  function render_body() {
    $username = $this->get_username();
    prof_course_pref_form($username);
    prof_load_pref_form($username);
    prof_special_request_form($username);

    $semester = CURRENT_SEMESTER;
    if (isset($_SESSION['semester'])) {
      $semester = $_SESSION['semester'];
    }

    $year = CURRENT_YEAR;
    if (isset($_SESSION['year'])) {
      $year = $_SESSION['year'];
    }

    $sections = get_sections_assigned_to($this->get_username(), $semester, $year);

    dom::h3('section-title', 'Assigned to me');
    dom::push_div('section');
      dom::push_form('prefs.php');
        dom::label('semester:');
        dom::dropdown('semester', list_semesters(), $semester, true);
        dom::label('year:');
        dom::dropdown('year', list_years(), $year, true);
        dom::hidden('action', 'set_semester');
        dom::br();
      dom::pop();

      dom::push_table();
        dom::push_tr();
          dom::th('Course Code');
          dom::th('Title');
          dom::th('Time');
          dom::th('Days');
          dom::th('Room');
          dom::th('Building');
          dom::th('Semester');
          dom::th('Year');
        dom::pop();
        while ($r = mysql_fetch_assoc($sections)) {
          dom::push_tr();
            dom::td($r['code']);
            dom::td($r['title']);
            dom::td($r['time']);
            dom::td($r['days']);
            dom::td($r['room']);
            dom::td($r['building']);
            dom::td($r['semester']);
            dom::td($r['year']);
          dom::pop();
        }
      dom::pop();
    dom::pop();
  }
}

(new prefs_page())->dump();
