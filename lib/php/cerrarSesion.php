<?php

header('Content-Type: text/html; charset=UTF-8');
session_start();
unset($_SESSION['idUsuario']);
header('Location: http://' . $_SERVER['SERVER_NAME']. "/rt");
?>
