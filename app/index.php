<?php
require_once 'config.php';
$conexao = conexao_db();

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $email = $_POST['email'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conexao, $query);
    $conta = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if (password_verify($password, $conta['password'])) {
                session_start();
                $_SESSION['username'] = $conta['username'];
                header('location: mainPage.php');
            } else {
                echo "<script>alert('Senha ou nome de utilizador incorretos')</script>";
            }
        }
    } else {
        echo "Erro na consulta: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>Login</title>
</head>

<body style="background-color: #DFDFDF;">
    <div class="container" style="margin-top: 45%; margin-left: 15px;">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div id="first">
                    <div class="myform form ">
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center">
                                <h1>Login</h1>
                            </div>
                        </div>
                        <form action="" method="post" name="login">
                            <div class="form-group">
                                <label for="exampleInputEmail">Email</label>
                                <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp" placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">Password</label>
                                <input type="password" name="password" id="password" class="form-control" aria-describedby="emailHelp" placeholder="password">
                            </div>
                            <div class="col-md-12 text-center ">
                                <button type="submit" name="submit" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                            </div>
                            <div class="col-md-12 ">
                                <div class="login-or">
                                    <hr class="hr-or">
                                    <span class="span-or">or</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="text-center">Não tens conta? <a href="signUp.php" id="signup">Cria uma aqui</a></p>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>