<?php

header('Content-Type: text/html; charset=UTF-8');
session_start();
unset($_SESSION['idUsuario']);
session_destroy();
header('Location: http://' . $_SERVER['SERVER_NAME']. "/rt");
?>
