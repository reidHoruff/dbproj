<?php

require_once 'dom.php';

class base_page {

  function init() {
    session_start();
  }

  function set_message($m) {
    global $_SESSION;
    $_SESSION['message'] = $m;
  }

  function get_message() {
    return $_SESSION['message'];
  }

  function set_error($e) {
    global $_SESSION;
    $_SESSION['error'] = $e;
  }

  function get_error() {
    return $_SESSION['error'];
  }

  function pre_render() {
  }

  function render_head() {
    /* 
     * begin HTML rendering... 
     */
    dom::init();
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
  }

  function render_body() {
  }

  function dump() {
    $this->init();
    $this->pre_render();
    $this->render_head();
    $this->render_body();
    dom::dump();
  }
}
