<?php session_start(); ?>
<?php 
    if(!isset($_SESSION["Nombre"]))
    {
        header("Location:index.php");
    }

    include("./generar_cancha.php");

    $dia = date("d/m/Y", strtotime($_GET["dia"]));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <title>TorinoFútbol: Reserva Confirmada</title>
    <style>
        body, html{
            min-height: 100%;
            min-width: 100%;
            width: 100%;
            height: auto;
            background: linear-gradient(45deg, #6d2df6, #8650fe);

            /* background-size: cover; */
        }

        #container_reserva{
            position: relative;
            top: 40px;
            width: 330px;
            background-color: white;
            border: 3px solid darkviolet;
            padding: 25px;
            border-radius: 10px;
            margin: auto;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }

        #titulo_reserva{
            color: crimson;
            text-align: center;
        }

        .info_reserva{
            /* margin-bottom: 10px; */
            padding: 20px 10px 10px 10px;
            box-sizing: border-box;
            border-bottom: 3px solid darkviolet;
        }

        .info_reserva:hover{
            /* border-bottom: 3px solid; */
            background-color: lavender;
        }

        #contactate{
            font-size: 1.8rem;
        }
    </style>
</head>
<body>

    <div id="container_reserva">
        <h3 id="titulo_reserva">¡Reserva exitosa!</h3>
        <br>
        <div class="info_reserva"><span style="color:darkviolet">Cancha:</span> <?php echo generarCancha($_GET["cancha"]); ?></div>
        <div class="info_reserva"><span style="color:darkviolet">Dia:</span> <?php echo $dia ?></div>
        <div class="info_reserva"><span style="color:darkviolet">Hora:</span> <?php echo $_GET["hora"] ?></div>
        <div class="info_reserva"><span style="color:darkviolet">Tu ID de reserva es:</span> <?php echo $_GET["id_reserva"] ?></div>
        <div class="info_reserva" id="precio"><span style="color:darkviolet"></span></div>
        <br>
        <div id="contactate">Contactate con el administrador para efectuar la seña:</div><br>
        <div class="info_reserva"><span style="color:darkviolet">Tel:</span> 11-11111111</div><br>
        <button class="boton_aceptar" id="volver">Volver al inicio</button>
    </div>

    
</body>
</html>

<script>
    window.onbeforeunload = history.pushState(null, null, "index.php");
    
    document.getElementById("volver").addEventListener("click", ()=>{
        location.href = "./index.php";
    });

    const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            });
    
    document.getElementById("precio").innerHTML = `<span style="color:darkviolet">Total: </span>${formatter.format(<?php echo $_GET['precio'] ?>)}`;
        
</script>