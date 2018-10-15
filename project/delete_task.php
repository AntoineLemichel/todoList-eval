<?php

require("../bdd.php");

$req_task = $bdd->query('SELECT * FROM task');

$delete_task = $bdd->query('DELETE FROM task WHERE id=' . $_GET['index']);
header('Location: '. $_SERVER['HTTP_REFERER']);
