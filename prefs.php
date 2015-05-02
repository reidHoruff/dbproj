<?php

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';

class prefs_page extends base_page {

  function header_title() {
    return 'Prefferences Page';
  }

  function page_name() {
    return 'prefs.php';
  }

  function require_login() {
    return false;
  }

  /*
   * this block handles all POST requests
   */
  function pre_render() {
  }

  function render_body() {
    dom::h3("", "prefs");
    dom::h3("", $this->get_username());
    dom::h3("", $this->is_inst_logged_in());
    dom::h3("", $this->require_login());
  }
}

(new prefs_page())->dump();
