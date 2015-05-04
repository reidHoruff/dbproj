<?php

require_once 'page_base.php';
require_once 'db.php';
require_once 'helpers.php';
require_once 'dom.php';
require_once 'forms.php';
require_once 'val.php';

class index_page extends base_page {

  function header_title() {
    return 'TTU Administrator Panel';
  }

  function page_name() {
    return 'index.php';
  }

  /*
   * this block handles all POST requests
   */
  function handle_post($post) {
    if (isset($post['action'])) {
      $action = $post['action'];
      /* 
       * action for adding a instructor
       */
      if ($action == 'add_instructor') {
        mysql_insert_dang('instructors', $post, array('password2'));
        $this->set_message("Eraider successfully added.");
      } 

      /* 
       * action for adding eraider
       */
      if ($action == 'add_eraider') {
        mysql_insert_dang('eraiders', $post, array('password2'));
        $this->set_message("Teacher successfully added.");
      } 

      /* 
       * action for business admin
       */
      if ($action == 'add_business_admin') {
        mysql_insert_dang('business_admins', $post);
        $this->set_message("Business administrator successfully added.");
      } 
      
      /*
       * action for adding a book
       */
      else if ($action == 'add_book') {
        mysql_insert_dang('books', $post);
        $this->set_message("Text book successfully added.");
      }

      /*
       * action for adding a course
       */
      else if ($action == 'add_course') {
        mysql_insert_dang('courses', $post);
        $this->set_message("Course successfully added.");
      }  

      /*
       * action for adding a ta
       */
      else if ($action == 'add_ta') {
        mysql_insert_dang('tas', $post);
        $this->set_message("Course successfully added.");
      }  
      
      /*
       * action for adding a section
       */
      else if ($action == 'add_section') {
        mysql_insert_dang('sections', $post);
        $this->set_message("Section successfully added.");
      } 

      /*
       * link section and instructor
       */
      else if ($action == 'link_inst_sect') {
        mysql_insert_dang('instructor_to_section', $post);
        $this->set_message("Section and instructor successfully linked.");
      } 

      /*
       * link ta to section
       */
      else if ($action == 'link_ta_to_section') {
        mysql_insert_dang('ta_to_section', $post);
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
    } 
  }

  function render_body() {
    add_eraider_form();
    add_instructor_form();
    link_business_admin_form();
    add_course_form();
    add_section_form();
    add_text_book_form();
    add_ta_form();

    add_teacher_to_section();
    add_ta_to_section();
  }
}

(new index_page())->dump();
