<?php
require("../../bdd.php");
echo $_POST['index'];
if(isset($_POST['name_list']) and !empty($_POST['name_list'])){
  if(isset($_POST['deadline_list']) and !empty($_POST['deadline_list'])){
    $req_insert = $bdd->prepare('INSERT INTO list (name, deadline, id_project, done) VALUES (:name, :deadline, :id_project, :done)');
    $req_insert->execute(array(
      'name' => $_POST['name_list'],
      'deadline' => $_POST['deadline_list'],
      'id_project' => $_POST['index'],
      'done' => 0
    ));
    header('Location: '. $_SERVER['HTTP_REFERER']);
  } else {
    echo "The deadline input cant not be empty.";
  }
} else {
  echo "The name of list cant not be empty.";
}


