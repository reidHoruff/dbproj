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
        if (instructor_login($post['username'], $post['password']) == 1) {
            $this->set_inst_is_loggedin(true);
            $this->set_username($post['username']);
            header("Location: prefs.php");
            die();
        } else {
          $this->set_inst_is_loggedin(false);
          $this->set_message('foobar');
          $this->set_error("unable to login");
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
