<?php

/*
 * everything here is susceptible to injection
 * but thats fine.
 */

$username = "root3";
$password = "root";
$server = "localhost";
$dbname = 'dbproj';

$conn = mysql_connect($server, $username, $password);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

mysql_select_db($dbname);

function create_professor($fname, $lname, $title, $type, $date_joined) {
  mysql_query("insert into profs (first_name, last_name, title, type, date_joined) values ('$fname', '$lname', '$title', '$type', '$date_joined');");
}

function create_book($title, $publisher, $edition, $isbn) {
  mysql_query("insert into books (title, publisher, edition, isbn) values ('$title', '$publisher', '$edition', '$isbn');");
}

function get_all_profs() {
  return mysql_query("select * from profs;");
}

function get_all_books() {
  return mysql_query("select * from books;");
}
