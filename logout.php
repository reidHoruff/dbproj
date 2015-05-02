<?php

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';

class logout_page extends base_page {

  function header_title() {
    return 'Logout';
  }

  function page_name() {
    return 'logout.php';
  }

  function require_login() {
    return false;
  }

  /*
   * this block handles all POST requests
   */
  function pre_render() {
    $this->logout();
  }

  function render_body() {
    dom::h3("", "logout successful");
  }
}

(new logout_page())->dump();
