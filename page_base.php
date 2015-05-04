<?php

/*
 * This is base class that all pages
 * inherit from. It provides/abstracts
 * basic functionality that is common across
 * all pages and makes new page creation trivial.
 * There are only a few functions that must be overwritten
 * to provede uniform functionality across pages.
 */

require_once 'dom.php';
require_once 'helpers.php';

class base_page {

  /*
   * must overwrite for each page:
   * eg return value would be 'index.php'.
   *
   * This allows the post handler to know
   * where to redirect back to. it is also used 
   * to salt session keys so that messages don't
   * clash across multiple pages.
   */
  function page_name() {
    return 'base';
  }

  /*
   * option to overwrite:
   * if returns true then the page will
   * not allow request, POST or GET, if the
   * requester is not logged in.
   */
  function require_login() {
    return false;
  }

  function require_inst_login() {
    return false;
  }

  function require_business_login() {
    return false;
  }

  /*
   * overwrite this so set the page header title.
   */
  function header_title() {
    return 'Course Management System';
  }

  /*
   * called on GET requests before any html is rendered.
   * can be thought of as an init() function
   */
  function pre_render() {
  }

  /*
   * this should be overwritten to contain 
   * the body DOM construction
   */
  function render_body() {
    dom::h3('', "hello world!");
  }

  /*
   * called on POST requests. page
   * is not rendered on POST requests. only
   * this method is called. Page is the GET redirected
   * back to page_name()
   */
  function handle_post($post) {
  }

  /*
   * this can be overwritten but you probably don't want to.
   */
  function handle_get($post) {
    $this->pre_render();
    $this->render_head();
    $this->render_body();
    dom::dump();
  }


  /*
   * the following four functions may be called to set
   */
  final function set_message($m) {
    $_SESSION['message' . $this->page_name()] = $m;
  }

  final function set_error($e) {
    $_SESSION['error' . $this->page_name()] = $e;
  }

  private function get_message() {
    return get($_SESSION, 'message'.$this->page_name());
  }

  private function get_error() {
    return get($_SESSION, 'error'.$this->page_name());
  }

  /*
   * logs user out and clears all session data
   */
  final function logout() {
    session_unset();
    session_destroy();
  }

  final function set_inst_is_loggedin() {
    $_SESSION['loggedin-inst'] = true;
  }

  final function set_business_is_loggedin() {
    $_SESSION['loggedin-business'] = true;
  }

  /*
   * returns true if instructor is logged in.
   */
  final function is_inst_logged_in() {
    return isset($_SESSION['loggedin-inst']) and $_SESSION['loggedin-inst'] == true;
  }

  final function is_business_logged_in() {
    return isset($_SESSION['loggedin-business']) and $_SESSION['loggedin-business'] == true;
  }

  final function is_logged_in() {
    return $this->is_inst_logged_in() || $this->is_business_logged_in();
  }

  final function set_username($un) {
    $_SESSION['username'] = $un;
  }

  final function get_username() {
    return $_SESSION['username'];
  }

  /*
   * renders the basic page template layout and
   * messages and error messages. then clears messages and errors.
   */
  private function render_head() {
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

  /*
   * Point of entry.
   * the only function that should be called directly by a page.
   */
  final function dump() {
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
      and $this->is_logged_in() == false) {
      die("permission denied");
    }

    if (
      $this->require_inst_login() == true 
      and $this->is_inst_logged_in() == false) {
      die("permission denied");
    }

    if (
      $this->require_business_login() == true 
      and $this->is_business_logged_in() == false) {
      die("permission denied");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      /*
       * after POST save messages in session and redirect
       * to same page but with a GET to avoid
       * annoying POST resubmission messages
       * on the browser's end.
       */
      $this->handle_post($_POST);
      header('Location: ' . $this->page_name());
    } 
    else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      $this->handle_get($_GET);
    }
    else {
      die('unsupported request');
    }
  }
}
