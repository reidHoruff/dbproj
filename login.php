<?php

/*
 * login page for professors
 */

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'forms.php';
require_once 'dom.php';

class login_page extends base_page {

  function header_title() {
    return 'TTU Instructor Login';
  }

  function page_name() {
    return 'login.php';
  }

  /*
   * this block handles all POST requests
   */
  function handle_post($post) {
    if (isset($post['action'])) {
      /* 
       * action for adding a professor 
       */
      if ($post['action'] == 'instructor_login') {
        $u = $post['username'];
        $p = $post['password'];

        if (instructor_login($u, $p) == 1) {
            $this->set_inst_is_loggedin();
            $this->set_username($u);
        } 

        if (business_login($u, $p) == 1) {
            $this->set_business_is_loggedin();
            $this->set_username($u);
        } 

        if ($this->is_logged_in()) {
          header("Location: prefs.php");
          die();
        } else {
          $this->set_error("unable to login.");
        }
      } 

      if (mysql_error()) {
        $this->set_error(mysql_error());
      }
    } 
  }

  function render_body() {
    login_form();
  }
}

(new login_page())->dump();
