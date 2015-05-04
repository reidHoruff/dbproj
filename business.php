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
  }

  function render_body() {
    dom::h3('', "hello " . $this->get_username());
  }
}

(new business_admin_page())->dump();
