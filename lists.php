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
  }

  function render_body() {
    list_instructors();
    list_sections();
    list_books();
    list_courses();
  }
}

(new list_page())->dump();
