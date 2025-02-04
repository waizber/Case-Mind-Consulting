<?php
    session_start();
    include_once('config.php');

    $logado = $_SESSION['email_cpf'];
    $sql = "SELECT * FROM usuarios ORDER BY id DESC";
    $result = $conexao->query($sql);

    $sql_adm = "SELECT * FROM usuarios WHERE email='$logado' or cpf='$logado'";
    $result_adm = $conexao->query($sql_adm);
    $adm_data = mysqli_fetch_assoc($result_adm);

    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true) or ($adm_data['nivel'] == 1))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>SISTEMA EMPRESA</title>
    <style>
        html{
            height: 100%;
        }
        body{
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(#141e30, #243b55);
            color: white;
            text-align: center;
        }
        .table-bg{
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px 15px 0 0;
        }
        h1{
            font-weight: 600;
            text-shadow: 4px 4px #0C496A;
        }
        img{
            width: 50%;
            border-radius: 15px;
            border: 2px white solid;
        }
        .user{
            width: 10%;
        }
        td{
            vertical-align: middle;
        }
        a{
            margin: 3px;
        }
        </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Usuário Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="d-flex">
            <a href="sair.php" class="btn btn-danger me-5">Sair</a>
        </div>
    </nav>
    <br>
    <br>
    <h1> Painel do administrador</h1> 
    <h4>
    <?php 
        echo $adm_data['nome'].'<br><br>';
        $nome_img = $adm_data['imagem'];
        echo '<img class="user" src="img/' .$nome_img. '" />';
    ?>
    </h4>
    <div class="m-5">
        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nível</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td width='10%'>".'<img src="img/' .$user_data['imagem']. '" />'."</td>";
                        echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['cpf']."</td>";
                        echo "<td>".$user_data['email']."</td>";
                        echo "<td>".$user_data['nivel']."</td>";
                        echo "<td>
                        <a class='btn btn-sm btn-primary' href='edit.php?id=$user_data[id]&nivel=999' title='Editar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                        </a>";
                        if ($user_data['nivel'] == 1):
                            echo "<a class='btn btn-sm btn-danger' href='desativar_ativar.php?id=$user_data[id]&nivel=$user_data[nivel]' title='Desativar/Ativar'>
                                Desativar  
                            </a>";
                        elseif ($user_data['nivel'] == 0): 
                            echo "<a class='btn btn-sm btn-danger' href='desativar_ativar.php?id=$user_data[id]&nivel=$user_data[nivel]' title='Desativar/Ativar'>
                                Ativar  
                            </a>";
                        else:   
                            echo "";
                        endif; 
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Guilherme Waizbart 2021</small></div>
    </div>
</body>
</html>