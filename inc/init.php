<?php
$host_dbname = 'mysql:host=localhost;dbname=bibliotheque';
$login = 'root';
$password = '';
$options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

$pdo = new PDO($host_dbname, $login, $password, $options);  

// Création d'une variable vide pour afficher des messages utilisateur : 
$msg = '';

// Création ou ouverture de la session ($_SESSION) notamment pour mettre les informations de connexion utilisateur
session_start();

define('URL', 'http://localhost/php/TP3final/');

?>