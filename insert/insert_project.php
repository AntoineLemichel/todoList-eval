<?php


require('../bdd.php');

if(isset($_POST['name']) and !empty($_POST['name'])){
  if(isset($_POST['deadline']) and !empty($_POST['deadline'])){
    if(isset($_POST['description']) and !empty($_POST['description'])){
      if(strlen($_POST['description']) < 255){
        if(strlen($_POST['name']) < 60){
          $insert_project = $bdd->prepare('INSERT INTO project (name, description, deadline) VALUES (:name, :description, :deadline)');
          $insert_project->execute(array(
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'deadline' => $_POST['deadline']
          ));
          header('Location: ../index.php');
        } else {
          echo "The name of project is too length. (Max 60 caracteres.)";
        }
      } else {
        echo "The description is too length. (Max 255 caracteres.)";
      }
    } else {
      echo "The field of description is empty.";
    }
  } else {
    echo "The field of deadline is empty.";
  }
} else {
  echo "The field of name is empty.";
}