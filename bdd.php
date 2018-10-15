<?php

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=todo_eval;charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
  die('Erreur : ' . $e->getMessage());
}