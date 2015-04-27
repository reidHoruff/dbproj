<?php

$dom = null;
$current = null;

/*
 * starts a DOM node
 */
function gen_dom() {
  global $dom, $current;
  $dom = new DOMDocument();
  $current = array();
  $current[] = $dom;
}

/*
 * writes xml to the browser
 * and destroys the current DOM
 */
function gen_dump() {
  global $dom, $current;
  echo $dom->saveXML();
  $dom = null;
  $current = null;
}

function pop_dom() {
  global $current;
  array_pop($current);
}

function dom_push($elem) {
  global $current;
  curr_dom()->appendChild($elem);
  $current[] = $elem;
}

function curr_dom() {
  global $current;
  return end($current);
}

/*
 * generates a dropdown of name $name
 * and adds elements from key value pairs
 * in $elements.
 * adds element to current node.
 */
function gen_dropdown($name, $elements) {
  global $dom;
  $select = $dom->createElement('select');
  $select->setAttribute('name', $name);

  foreach ($elements as $key => $value) {
    $option = $dom->createElement('option', $value);
    $option->setAttribute('value', $key);
    $select->appendChild($option);
  }

  curr_dom()->appendChild($select);
  curr_dom()->appendChild($dom->createElement('br'));
}

function gen_textinput($name, $text) {
  global $dom;
  $label = $dom->createElement('label', $text);
  curr_dom()->appendChild($label);

  $input = $dom->createElement('input');
  $input->setAttribute('name', $name);
  $input->setAttribute('type', 'text');
  curr_dom()->appendChild($input);

  curr_dom()->appendChild($dom->createElement('br'));
}

function gen_submit() {
  global $dom;
  $button = $dom->createElement('button', 'Submit');
  $button->setAttribute('type', 'submit');
  curr_dom()->appendChild($button);
}

function gen_h3($class, $text) {
  global $dom;
  $h3 = $dom->createElement('h3', $text);
  $h3->setAttribute('class', $class);
  curr_dom()->appendChild($h3);
}

function gen_hidden($name, $value) {
  global $dom;
  $input = $dom->createElement('input');
  $input->setAttribute('type', 'hidden');
  $input->setAttribute('name', $name);
  $input->setAttribute('value', $value);
  curr_dom()->appendChild($input);
}

function push_div($class) {
  global $dom;
  $div = $dom->createElement('div');
  $div->setAttribute('class', $class);
  dom_push($div);
}

function push_form($action) {
  global $dom;
  $form = $dom->createElement('form');
  $form->setAttribute('action', $action);
  $form->setAttribute('method', 'POST');
  dom_push($form);
}

function gen_ul($data) {
  global $dom;
  $ul = $dom->createElement('ul');

  foreach ($data as $d) {
    $li = $dom->createElement('li', $d);
    $ul->appendChild($li);
  }

  curr_dom()->appendChild($ul);
}

function gen_link($href, $text) {
  global $dom;
  $a = $dom->createElement('a', $text);
  $a->setAttribute('href', $href);
  curr_dom()->appendChild($a);
}

/*
 * generates the main HTML tag and body
 */
function gen_body() {
  global $dom;

  $html = $dom->createElement('html');
  dom_push($html);

  $head = $dom->createElement('head');
  dom_push($head);

  $link = $dom->createElement('link');
    $link->setAttribute('rel', 'stylesheet');
    $link->setAttribute('type', 'text/css');
    $link->setAttribute('href', 'style.css');
  curr_dom()->appendChild($link);

  pop_dom();

  $body = $dom->createElement('body');
  dom_push($body);
  push_div('header boarder');
  gen_h3('', 'Course Management Sys');
  gen_link('#', 'link1');
  pop_dom();
  push_div('content');
}
