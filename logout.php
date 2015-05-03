<?php

/* 
 * when visited current user is logged out 
 * */

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
  function handle_post($post) {
    $this->logout();
  }

  /*
   * logout before page is rendered
   * so that header is rendered accordingly.
   */
  function pre_render() {
    $this->logout();
  }

  function render_body() {
    dom::h3("center", "logout successful.");
  }
}

(new logout_page())->dump();
