<?php
require_once 'db.php';

$message = null;

function set_message($m) {
  global $message;
  $message = $m; 
}

if (isset($_POST['action'])) {

  /* 
   * action for adding a professor 
   */
  if ($_POST['action'] == 'add_prof') {
    create_professor($_POST['fname'], $_POST['lname']); 
    set_message("professor successfully added.");
  } 
  
  /*
   * action for adding a book
   */
  else if ($_POST['action'] == 'add_book') {
    create_book($_POST['title'], $_POST['publisher'], $_POST['edition'], $_POST['isbn']); 
    set_message("text book successfully added.");
  } 
  
  else {
  }
}

?>

<html>
  <head>
    <link href="style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="header border">
        <h2>Course Management System</h2>
        <a href="#">link1</a>
        <a href="#">link2</a>
    </div>

    <div class="content">

<?php 
/*
 * this displays the last error that mySQL encountered, if any,
 * and displays it. else it displays the user message if any.
 *
 * This works pretty well assuming that a single query/operation is
 * mode per POST.
 */
$mysql_error = mysql_error($conn);
if ($mysql_error) {
  echo <<<EOL
    <div class="error">
      <h2>{$mysql_error}</h2>
    </div>
EOL;
} else if ($message) {
  echo <<<EOL
    <div class="message">
      <h2>{$message}</h2>
    </div>
EOL;
}
?>

      <!-- add professor -->
      <h3 class="section-title">Add Professor:</h3>
      <div class="section">
        <form method="post" action="/dbproj/index.php">
          First name: <input type="text" name="fname"/>
          <br/>
          Last name: <input type="text" name="lname"/>
          <br/>
          <input type="radio" name="tenured" value="true">Tenured</input>
          <br>
          <input type="radio" name="tenured" value="false" checked=true>Untenured</input>
          <br>
          <button type="submit" name="action" value="add_prof">submit</button>
        </form>
      </div>

      <!-- add text book -->
      <h3 class="section-title">Add Text Book:</h3>
      <div class="section">
        <form method="post" action="/dbproj/index.php">
          Title: <input type="text" name="title"/>
          <br/>
          Publisher: <input type="text" name="publisher"/>
          <br/>
          edition: <input type="text" name="edition"/>
          <br/>
          ISBN: <input type="text" name="isbn"/>
          <br/>
          <button type="submit" name="action" value="add_book">submit</button>
        </form>
      </div>

      <!-- list profs -->
      <h3 class="section-title">List Professors:</h3>
      <div class="section">
        <ul>
          <?php
            $profs = get_all_profs();
            while ($row = mysql_fetch_assoc($profs)) {
              echo "<li>{$row['first_name']} {$row['last_name']}</li>";
            }
          ?>
        </ul>
      </div>

      <!-- list books -->
      <h3 class="section-title">List Text Books:</h3>
      <div class="section">
        <ul>
          <?php
            $books = get_all_books();
            while ($row = mysql_fetch_assoc($books)) {
              echo "<li>{$row['title']} : {$row['isbn']}</li>";
            }
          ?>
        </ul>
      </div>

    </div>
  </body>
</html>
