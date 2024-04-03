<?php
    require_once 'config.php';
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
        <div class="title">
            <h1>Nova Atividade</h1>
        </div>
        <div class="content">
            <div class="atividade">
                <div class="circle">
                    <a href="midActivityAtividade.php"><img src="/PAP/app/img/run.png"></a>
                </div>
                <h3>Atividade Fisica</h3>
            </div>
            
            <div class="atividade">
                <div class="circle">
                    <a href="midActivityRepetir.php"><img src="/PAP/app/img/repeat.png"></a>
                </div>
                <h3>Repetir Movimentos</h3>
            </div>
        </div>
        <div class="nav-bar">
            <a href="mainPage.php"><img src="/PAP/app/img/house.png"></a>
            <a href="startActivity.php"><img src="/PAP/app/img/plus.png" ></a>
            <a href="profile.php"><img src="/PAP/app/img/profile.png" style="margin-right: 10px;"></a>
        </div>
    </div>
</body>
</html>