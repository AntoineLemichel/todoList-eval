<?php

require("../bdd.php");
$delete_project = $bdd->query("DELETE FROM project WHERE id=" .$_GET['index']);
header('Location: ../index.php');