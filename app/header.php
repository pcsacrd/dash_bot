<?php
require_once 'config.php';
$conexao = conexao_db();
session_start();
if (!isset($_SESSION['username'])) {
        header('location: index.php'); // Redireciona para a página de login
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/css">
    <title>Recent Activity</title>
</head>
<body>
    <div class="row">