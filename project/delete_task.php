<?php

require("../bdd.php");

$req_task = $bdd->query('SELECT count(*) AS total FROM task WHERE list_id=' .$_GET['index_list'])->fetch();
if($req_task['total'] == 0){
  $delete_list = $bdd->query('DELETE FROM list WHERE id=' . $_GET['index_list']);
  header('Location: '. $_SERVER['HTTP_REFERER']);
  echo "test";
} else {
  $delete_task = $bdd->query('DELETE FROM task WHERE id=' . $_GET['index']);
  header('Location: '. $_SERVER['HTTP_REFERER']);
}

