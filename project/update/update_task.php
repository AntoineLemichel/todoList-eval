<?php

require('../../bdd.php');

$update_task = $bdd->query('UPDATE task SET done = 1 WHERE id=' . $_GET['index']);
header('Location: '. $_SERVER['HTTP_REFERER']);
