<?php 
//index.php
session_start();

require_once("bootstrap.php");

echo $twig->render('index.twig');

?>