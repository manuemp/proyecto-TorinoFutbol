<?php session_start(); ?>
<?php
if(!isset($_SESSION["Nombre"]))
    {
        header("Location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <title>¡Exceso de reservas!</title>
    <style>
        body
        {
            background: linear-gradient(45deg, #4c02e9, #9f78f6);
            min-height: 100vh;
        }

        a{
            text-decoration: none;
        }

        p
        {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 0px deeppink;
            text-align:center;
        }

        .boton_aceptar{
            display:block;
            margin: auto;
            width: 100px;
        }
    </style>
</head>
<body>
    <?php include("./nav_online.php") ?>
    <br><br><br><br><br>
    <p style="font-size: 5rem">Uups...</p>
    <p>La reserva ya no está disponible</p>
    <button class="boton_aceptar" id="volver">Volver</button>
</body>
</html>
<script>
    document.getElementById("volver").addEventListener('click', ()=>{
        location.href = "./reservar.php";
    });
</script>