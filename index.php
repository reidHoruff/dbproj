<?php

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';
require_once 'forms.php';

class index_page extends base_page {

  /*
   * this block handles all POST requests
   */
  function pre_render() {
    if (isset($_POST['action'])) {
      /* 
       * action for adding a professor 
       */
      if ($_POST['action'] == 'add_prof') {
        mysql_insert_dang('instructors', $_POST);
        $this->set_message("Teacher successfully added.");
      } 
      
      /*
       * action for adding a book
       */
      else if ($_POST['action'] == 'add_book') {
        mysql_insert_dang('books', $_POST);
        $this->set_message("Text book successfully added.");
      }

      /*
       * action for adding a course
       */
      else if ($_POST['action'] == 'add_course') {
        mysql_insert_dang('courses', $_POST);
        $this->set_message("Course successfully added.");
      }  

      /*
       * action for adding a ta
       */
      else if ($_POST['action'] == 'add_ta') {
        mysql_insert_dang('tas', $_POST);
        $this->set_message("Course successfully added.");
      }  
      
      
      /*
       * action for adding a section
       */
      else if ($_POST['action'] == 'add_section') {
        mysql_insert_dang('sections', $_POST);
        $this->set_message("Section successfully added.");
      } 

      /*
       * link section and instructor
       */
      else if ($_POST['action'] == 'link_inst_sect') {
        mysql_insert_dang('instructor_to_section', $_POST);
        $this->set_message("Section and instructor successfully linked.");
      } 

      /*
       * link ta to section
       */
      else if ($_POST['action'] == 'link_ta_to_section') {
        mysql_insert_dang('ta_to_section', $_POST);
        $this->set_message("TA Linked to Section.");
      } 
      
      else {
      }
      /*
       * after POST save messages in session and redirect
       * to same page but with a GET to avoid
       * annoying POST resubmission messages
       * on the browser's end.
       */
      $this->set_error(mysql_error());
      header("Location: index.php");
      die();
    } 
  }

  function render_body() {
    add_instructor_form();
    add_course_form();
    add_section_form();
    add_text_book_form();
    add_ta_form();

    add_teacher_to_section();
    add_ta_to_section();
  }
}

(new index_page())->dump();
