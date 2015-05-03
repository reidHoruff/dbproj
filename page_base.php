<?php

require_once 'dom.php';
require_once 'helpers.php';

class base_page {

  function init() {
  }

  function page_name() {
    return 'base';
  }

  function set_message($m) {
    global $_SESSION;
    $_SESSION['message' . $this->page_name()] = $m;
  }

  function require_login() {
    return false;
  }

  function header_title() {
    return 'Course Management System';
  }

  function get_message() {
    return $_SESSION['message' . $this->page_name()];
  }

  function set_error($e) {
    global $_SESSION;
    $_SESSION['error' . $this->page_name()] = $e;
  }

  function logout() {
    $this->set_inst_is_loggedin(false);
  }

  function set_inst_is_loggedin($logged_in) {
    if ($logged_in != true) {
      $this->set_username(null);
    }
    $_SESSION['loggedin-inst'] = $logged_in;
  }

  function is_inst_logged_in() {
    return isset($_SESSION['loggedin-inst']) and $_SESSION['loggedin-inst'] == true;
  }

  function set_username($un) {
    $_SESSION['username'] = $un;
  }

  function get_username() {
    return $_SESSION['username'];
  }

  function get_error() {
    return $_SESSION['error' . $this->page_name()];
  }

  function pre_render() {
    /** to be overwritten */
  }

  function render_body() {
    /* to be over written */
  }

  function render_head() {
    /* 
     * begin HTML rendering... 
     */
    dom::init($this);
    dom::push_body();

    /*
     * this displays the last error that mySQL encountered, if any,
     * and displays it. else it displays the user message if any.
     *
     * This works pretty well assuming that a single query/operation is
     * mode per POST.
     */
    $mysql_error = $this->get_error();
    $message = $this->get_message();

    if ($mysql_error) {
      dom::push_div('error');
        dom::h3('', $mysql_error);
      dom::pop();
    } 

    else if ($message) {
      dom::push_div('message');
        dom::h3('', $message);
      dom::pop();
    }

    /*
     * clear message and error
     */
    $this->set_error(null);
    $this->set_message(null);
  }

  function dump() {
    /*
     * should be first thing called
     */
    session_start();
    /**
     * deny requests to page if login is required and
     * user is not logged int
     */
    if (
      $this->require_login() == true 
      and $this->is_inst_logged_in() == false) {
      die("permission denied " . bool($this->is_inst_logged_in()) . " " . bool($this->require_login()));
    }

    $this->init();
    $this->pre_render();
    $this->render_head();
    $this->render_body();
    dom::dump();
  }
}
