<?php

require("../bdd.php");
echo $_GET['index'];
$delete_project = $bdd->query("DELETE FROM project WHERE id=" .$_GET['index']);
header('Location: ../index.php');