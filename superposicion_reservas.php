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
            background: linear-gradient(45deg, #6d2df6, #8650fe);
            min-height: 100vh;
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
    <br><br><br><br><br>
    <p style="font-size: 5rem">Cuidado...</p>
    <p>¡Ya tenés otra reserva en el mismo día y hora!</p>
    <p>¡Intentá con otro horario!</p>
    <button class="boton_aceptar" id="volver">Volver</button>
</body>
</html>
<script>
    document.getElementById("volver").addEventListener('click', ()=>{
        location.href = "./reservar.php";
    });
</script>