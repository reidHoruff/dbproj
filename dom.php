<?php

class dom {
  static $dom = null;
  static $current = null;

  /*
   * starts a DOM node
   */
  static function init() {
    global $dom, $current;
    $dom = new DOMDocument();
    $current = array();
    $current[] = $dom;
  }

  /*
   * writes xml to the browser
   * and destroys the current DOM
   */
  static function dump() {
    global $dom, $current;
    echo $dom->saveXML();
    $dom = null;
    $current = null;
  }

  /*
   * pops off last element
   */
  static function pop() {
    global $current;
    array_pop($current);
  }

  /*
   * sets $elem as current
   * working node by pushing it
   * onto the working dom stack
   */
  static function push($elem) {
    global $current;
    self::append($elem);
    $current[] = $elem;
  }

  /*
   * appends element to current working
   * element (top of working stack)
   */
  static function append($elem) {
    global $current;
    return end($current)->appendChild($elem);
  }

  /*
   * everything below defines element
   * creation.
   * /

  /*
   * generates a dropdown of name $name
   * and adds elements from key value pairs
   * in $elements.
   * adds element to current node.
   */
  static function dropdown($name, $elements) {
    global $dom;
    $select = $dom->createElement('select');
    $select->setAttribute('name', $name);

    if (empty($elements)) {
      $option = $dom->createElement('option', "");
      $option->setAttribute('value', "");
      $select->appendChild($option);
    }

    foreach ($elements as $key => $value) {
      $option = $dom->createElement('option', $value);
      $option->setAttribute('value', $key);
      $select->appendChild($option);
    }

    self::append($select);
    self::append($dom->createElement('br'));
  }

  static function label($text) {
    global $dom;
    self::append($dom->createElement('label', $text));
  }

  static function textinput($name, $text) {
    global $dom;
    self::label($text);
    $input = $dom->createElement('input');
    $input->setAttribute('name', $name);
    $input->setAttribute('type', 'text');
    self::append($input);

    self::append($dom->createElement('br'));
  }

  static function submit() {
    global $dom;
    $button = $dom->createElement('button', 'Submit');
    $button->setAttribute('type', 'submit');
    self::append($button);
  }

  static function h3($class, $text) {
    global $dom;
    $h3 = $dom->createElement('h3', $text);
    $h3->setAttribute('class', $class);
    self::append($h3);
  }

  static function hidden($name, $value) {
    global $dom;
    $input = $dom->createElement('input');
    $input->setAttribute('type', 'hidden');
    $input->setAttribute('name', $name);
    $input->setAttribute('value', $value);
    self::append($input);
  }

  static function push_div($class) {
    global $dom;
    $div = $dom->createElement('div');
    $div->setAttribute('class', $class);
    self::push($div);
  }

  static function push_form($action) {
    global $dom;
    $form = $dom->createElement('form');
    $form->setAttribute('action', $action);
    $form->setAttribute('method', 'POST');
    self::push($form);
  }

  static function ul($data) {
    global $dom;
    $ul = $dom->createElement('ul');

    foreach ($data as $d) {
      $li = $dom->createElement('li', $d);
      $ul->appendChild($li);
    }

    self::append($ul);
  }

  static function link($href, $text) {
    global $dom;
    $a = $dom->createElement('a', $text);
    $a->setAttribute('href', $href);
    self::append($a);
  }

  /*
   * generates the main HTML tag and body
   */
  static function push_body() {
    global $dom;

    $html = $dom->createElement('html');
    self::push($html);

    $head = $dom->createElement('head');
    self::push($head);

    $link = $dom->createElement('link');
      $link->setAttribute('rel', 'stylesheet');
      $link->setAttribute('type', 'text/css');
      $link->setAttribute('href', 'style.css');
    self::append($link);

    self::pop();

    $body = $dom->createElement('body');
    self::push($body);
    self::push_div('header boarder');
    self::h3('', 'Course Management Sys');
    self::link('#', 'link1');
    self::pop();
    self::push_div('content');
  }
}
