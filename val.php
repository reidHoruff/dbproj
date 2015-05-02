<?php
/*
 * validation for forms submitted
 */

function val_book($post) {
  if (strlen($post['title']) < 1) {
    return "title is too short";
  }
  return true;
}


