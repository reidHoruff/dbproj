<?php

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';

class prefs_page extends base_page {

  function header_title() {
    return 'Preferences Page for ' . $this->get_username();
  }

  function page_name() {
    return 'prefs.php';
  }

  function require_login() {
    return true;
  }

  /*
   * this block handles all POST requests
   */
  function handle_post($post) {
    if (isset($post['action'])) {

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
      }

      /*
       * set semester
       */
      else if ($post['action'] == 'set_semester') {
        $_SESSION['semester'] = $post['semester'];
      }

      else {
      }
    }
  }

  function render_body() {
    $course_pref_options = array(
      "none" => "none",
      "1" => "1",
      "2" => "2",
      "3" => "3"
    );
    dom::h3('section-title', 'Course Preferences for ' . CURRENT_YEAR);
    dom::push_div('section');
    $prefs = get_prefs_for_prof($this->get_username());
    while ($row = mysql_fetch_assoc($prefs)) {
      $default = $row['pref'];
      dom::push_div('course');
        dom::push_form('prefs.php');
          dom::label($row['code'] . ' - ' . $row['title']);
          dom::dropdown('pref', $course_pref_options, $default, true);
          dom::hidden('year', CURRENT_YEAR);
          dom::hidden('username', $this->get_username());
          dom::hidden('course_id', $row['id']);
          dom::hidden('action', 'update_course_prefs');
        dom::pop();
      dom::pop();
    }
    dom::pop();


    $load_pref_options = array(
      'none' => 'no preference',
      'fall' => "fall",
      'spring' => "spring"
    );

    $current_load_pref = get_load_preference($this->get_username());

    dom::h3('section-title', 'Teaching Load Preference');
    dom::push_div('section');
      dom::push_form('prefs.php');
        dom::dropdown('pref', $load_pref_options, $current_load_pref, true);
        dom::hidden('action', 'update_load_pref');
      dom::pop();
    dom::pop();


    $courses = all_course_data();

    dom::h3('section-title', 'Special Reqeusts');
    dom::push_div('section');
      dom::push_form('prefs.php');
        dom::label('Course:');
        dom::dropdown('course_id', $courses);
        dom::textinput('title', 'Title');
        dom::label('Justification');
        dom::textarea('justification');
        dom::hidden('username', $this->get_username());
        dom::hidden('action', 'special_request');
        dom::br();
        dom::submit();
      dom::pop();
    dom::pop();

    $semester = CURRENT_SEMESTER;
    if (isset($_SESSION['semester'])) {
      $semester = $_SESSION['semester'];
    }

    $sections = get_sections_assigned_to($this->get_username(), $semester);

    dom::h3('section-title', 'Assigned to me');
    dom::push_div('section');
      dom::push_form('prefs.php');
        dom::label('semester:');
        dom::dropdown('semester', list_semesters(), $semester, true);
        dom::hidden('action', 'set_semester');
        dom::br();
      dom::pop();

      dom::push_table();
        dom::push_tr();
          dom::push_th('Course Code');
          dom::push_th('Time');
          dom::push_th('Days');
          dom::push_th('Room');
          dom::push_th('Building');
        dom::pop();
        while ($r = mysql_fetch_assoc($sections)) {
          dom::push_tr();
            dom::push_td($r['code']);
            dom::push_td($r['time']);
            dom::push_td($r['days']);
            dom::push_td($r['room']);
            dom::push_td($r['building']);
          dom::pop();
        }
      dom::pop();
    dom::pop();
  }
}

(new prefs_page())->dump();
