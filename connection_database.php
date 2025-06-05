<?php

$connexion = new mysqli('localhost', 'root', '', 'projet_drivenow');

if ($connexion->connect_error) {
    die('Connection failed: ' . $connexion->connect_error);
}
?>
