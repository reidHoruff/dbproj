<?php

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
  function pre_render() {
    if (isset($_POST['action'])) {
      /* 
       * action for adding a professor 
       */
      if ($_POST['action'] == 'instructor_login') {
        if (instructor_login(
          $_POST['username'], 
          $_POST['password']) == 1) {
            $this->set_inst_is_loggedin(true);
            $this->set_username($username);
          header("Location: prefs.php");
          die();
        } else {
          $this->set_inst_is_loggedin(false);
          $this->set_error("unable to login");
        }
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
      header("Location: login.php");
      die();
    } 
  }

  function render_body() {
    login_form();
  }
}

(new login_page())->dump();
