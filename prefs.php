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
  function pre_render() {
    if (isset($_POST['action'])) {
      if ($_POST['action'] == 'update_course_prefs') {
        delete_existing_pref($this->get_username(), $_POST['course_id']);
        if ($_POST['pref'] != 'none') {
          mysql_insert_dang('prof_prefs', $_POST);
        }
        header('Location: prefs.php');
      }

      else if ($_POST['action'] == 'update_load_pref') {
        update_load_pref($this->get_username(), $_POST['pref']);
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
    dom::h3('', 'Course Preferences for ' . CURRENT_YEAR);
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
      'fall' => "fall",
      'none' => 'no preference',
      'spring' => "spring"
    );

    $current_load_pref = get_load_preference($this->get_username());

    dom::h3('', 'Load Preferences');
    dom::push_div('section');
      dom::push_form('prefs.php');
        dom::dropdown('pref', $load_pref_options, $current_load_pref);
        dom::hidden('action', 'update_load_pref');
      dom::pop();
    dom::pop();
  }
}

(new prefs_page())->dump();
