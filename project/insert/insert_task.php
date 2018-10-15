<?php
require('../../bdd.php');
if(isset($_POST['name_task']) and !empty($_POST['name_task'])){
  if(isset($_POST['deadline_task']) and !empty($_POST['deadline_task'])){
    $req_insert = $bdd->prepare('INSERT INTO task (name, deadline, done, list_id) VALUES (:name, :deadline, :done, :list_id)');
    $req_insert->execute(array(
      'name' => $_POST['name_task'],
      'deadline' => $_POST['deadline_task'],
      'done' => 0,
      'list_id' => $_POST['select_list']
    ));
    echo $_POST['select_list'];
    header('Location: '. $_SERVER['HTTP_REFERER']);

  } else {
    echo "The input deadline cant be not empty.";
  }
} else {
  echo "The input name cant be not empty.";
}