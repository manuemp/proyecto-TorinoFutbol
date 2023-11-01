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
    <p style="font-size: 5rem">Uups...</p>
    <p>¡Parece que tenés <u>demasiadas reservas!</u></p>
    <p>Sólo podés tener hasta 3 reservas pendientes</p>
    <p>Podrás reservar de nuevo luego del próximo partido</p>
    <button class="boton_aceptar" id="volver">Volver</button>
</body>
</html>
<script>
    document.getElementById("volver").addEventListener('click', ()=>{
        location.href = "./index.php";
    });
</script>