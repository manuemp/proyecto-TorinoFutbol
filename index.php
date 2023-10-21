<?php session_start(); ?>
<?php 
    if(isset($_SESSION["Administrador"]))
    {
        if(intval($_SESSION["Administrador"]) == 1)
            header("Location:admin_reservas.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/modal.css">
    <title>Torino Fútbol: Reservá las mejores canchas</title>
    <style>

    #sintetico
    {
        width: 100%;
        height: 300px;
        background-image: url("./imgs/sinteticoHD.jpeg");
        background-size: cover;
        background-repeat: no-repeat;
    }

    .bienvenido
    {
        font-size: 5rem;
        color: yellow;
        font-weight: bold;
        width: 100%;
        padding: 70px 40px 70px 30px;
        margin: auto;
        background-image: url("./imgs/jugador_pelota4.jpeg");
        background-repeat: no-repeat;
        background-size:cover;
        box-sizing: border-box;
        border-bottom: 6px solid crimson;
        cursor:default;
    }
    </style>
</head>
<body>
    <span id="modal_background"></span>

    <!-- NAV -->
    <?php 
        if(!isset($_SESSION['Nombre']))
        {
            include("./nav_offline.php");
            include("./index_offline.php");
        }
        else
        {
            include("./nav_online.php");
            include("./index_online.php");
        }
    ?>
</body>
</html>

