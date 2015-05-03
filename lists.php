<?php

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';

class list_page extends base_page {

  function header_title() {
    return 'TTU Administrator Panel - Lists for debugging';
  }

  function page_name() {
    return 'lists.php';
  }

  /*
   * this block handles all POST requests
   */
  function pre_render() {
    if (isset($_GET['action'])) {
      /* 
       * action for adding a professor 
       */
      if ($_GET['action'] == 'sql') {
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
