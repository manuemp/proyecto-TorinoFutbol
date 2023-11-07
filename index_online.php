<?php

    include("./actualizar_sesion.php");
    date_default_timezone_set("America/Argentina/Buenos_Aires");

    if($_SESSION["Racha"] >= 60)
    {
        $level = "Socio";
    }
    else if($_SESSION["Racha"] >= 25)
    {
        $level = "Local";
    }
    else 
    {
        $level = "Recreativo";
    }

    include("./conexion.php");
    $email = $_SESSION["Email"];
    $consulta = mysqli_query($conexion, "SELECT COUNT(*) AS Contador FROM Reservas WHERE Email = '$email'");
    $reservas = mysqli_fetch_assoc($consulta)["Contador"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="stylesheet" href="estilos/index.css">
    <link rel="stylesheet" href="estilos/modal.css">
    <title>Torino Fútbol: Reservá las mejores canchas</title>
    <style>
        #info_usuario
        {
            background-image: url("./imgs/fondo_contacto5.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        #info_faltas
        {
            background-image: url("./imgs/tarjeta_roja.jpg");
            background-repeat: no-repeat;
            background-size: contain;
            padding: 80px 45px;
            box-sizing: border-box;
        }

        #roja{
            height: 200px;
            width: auto;
            position: absolute;
            right: 0;
        }

        .titulo_info
        {
            font-weight: bold;
            font-size: 3rem;
            text-shadow: 1px 1px 10px black;
        }

        .texto_info
        {
            font-weight: bold;
            font-size: 4rem;
            text-shadow: 1px 1px 10px black;
        }

        #texto_faltas
        {
            color: white;
            font-weight: normal;
            font-size: 1.5rem;
            text-shadow: 1px 1px 10px black;
        }

        .reserva, .reserva_perdida
        {
            padding: 15px;
            border-radius: 10px;
            font-size: 1.8rem;
            box-sizing: border-box;
            font-weight: bold;
            margin-bottom: 8px;
            cursor: default;
        }

        .reserva{
            color: white;
            background-color: #a177ff;
        }

        .reserva_perdida{
            color: white;
            background-color: red;
        }

        .reserva:hover{
            background-color: #5f18ff;
        }

        .reserva_perdida:hover{
            background-color: crimson;
        }

        #titulo_reservas
        {
            margin: 10px 0px; 
            color: #8650fe;
            font-weight: bold;
            font-size: 3.2rem;
        }

        #beneficios{
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 2rem;
            /* margin-top: 25px; */
            margin-bottom: -14px;
            transition: 1s;
            cursor: pointer;
        }

        #beneficios_container{
            justify-content: space-around;
        }

        .beneficios_inactivo{
            color: #7a7aff;
            background-color: #c9c9ff;
        }

        .beneficios_activo{
            background-color: #5f22e3;
            color: white;
        }

        .icono_info{
            height: 32px;
        }

        .btn_triangulo{
            height: 14px;
            width: 25px;
            margin-left: 10px;
            margin-top: 5px;
            transition: 0.2s;
        }

        #panel_usuario{
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 45px;
            box-sizing: border-box;
            background-image: url("./imgs/fondo_contacto5.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        #usuario{
            width: 380px;
            height: 250px;
            padding: 40px;
            font-size: 2.8rem;
            background-color: white;
            border-radius: 10px;
            font-weight: 400;
        }


        #reservas{
            width: 58%;
            max-width: 750px;
            height: 250px;
            padding: 40px;
            margin-left: 20px;
            font-size: 3rem;
            background-color: white;
            border-radius: 10px;
        }

        #reservas_responsive{
            display: none;
            padding: 20px 30px 0px 30px;
            margin-top: 10px;
        }

        #container_reservas{
            width: 100%;
            margin-top: 20px;
            box-sizing: border-box;
        }

        #container_reservas_responsive{
            padding: 20px 10px;
            box-sizing: border-box;
            background-color: white;
            border-radius: 10px;
        }

        #titulo_usuario{
            margin: 0;
            margin-bottom: -24px;
            font-size: 3rem;
            color: #8650fe;
        }

        @media(min-width: 1390px){
            #beneficios_container{
                padding: 45px 0px;
            }

            .niveles_container{
                justify-content: center;
            }

            .item_nivel{
                width: 370px;
                margin: 20px;
                height: 300px;
            }

            #info_faltas{
                padding: 100px 45px;
            }
        }

        @media(max-width: 1300px)
        {
            .item_texto td{
                font-size: 1.4rem;
            }
        }
        
        @media(max-width: 1250px){
            .item_nivel{
                height: 300px;
            }

            #reservas{
                width: 55%;
                height: 200px;
                padding: 15px 20px;
                font-size: 2rem;
            }

            .reserva{
                padding: 10px;
                font-size: 1.4rem;
            }

            #panel_usuario{
                height: 280px;
            }

            #titulo_usuario{
                font-size: 2rem;
            }

            #usuario{
                padding: 15px 25px;
                width: 35%;
                font-size: 2rem;
                height: 200px;
            }
        }

        @media(max-width: 950px)
        {
            #reservas{
                display: none;
            }

            #reservas_responsive{
                display: block;
                text-align: center;
            }

            #usuario{
                width: 60%;
            }
        }

        @media(max-width: 650px)
        {
            #beneficios{
                height: 70px;
            }

            .bienvenido
            {
                font-size: 2.5rem;
                background-image: url("./imgs/jugador_pelota7.png");
            }

            .item_nivel{
                height: 200px;
            }

            .item_texto{
                font-size: 1.2rem;
            }

            #panel_usuario{
                justify-content: center;
            }

            #usuario{
                width: 85%;
            }

            .texto_info{
                font-size: 2.7rem;
            }

            .titulo_info{
                font-size: 3.2rem;
            }

            #texto_faltas{
                font-size: 1.2rem;
            }

            #titulo_reservas{
                font-size: 2.4rem;
                /* text-align: center; */
            }

            .reserva, .reserva_perdida{
                font-size: 1.2rem;
                /* text-align: center; */
            }

            .item_nivel{
                height: 280px;
            }
        }

        @media(max-width: 425px){
            #panel_usuario{
                justify-content: center;
                padding: 20px 0px;
                height: auto;

            }

            #usuario{
                width: 80%;
                padding: 30px 20px;
            }


            #info_faltas{
                background-image: url("./imgs/roja.png");
            }

            #texto_niveles{
                font-size: 1rem;
            }

            .titulo_info{
                font-size: 2.5rem;
            }

            .texto_info{
                font-size: 2rem;
            }

            .texto_faltas{
                font-size: 1rem;
            }

            .icono_info{
                height: 28px;
            }
        }

        @media(max-width: 360px){
            #titulo_reservas{
                font-size: 2rem;
            }

            .reserva, .reserva_perdida{
                font-size: 1rem;
            }
        }
        
    </style>
</head>
<body>
    <main>
        <section id="panel_usuario">
            <article id="usuario">
                <h1 id="titulo_usuario"><?php echo $_SESSION["Nombre"] . " " . $_SESSION["Apellido"] ?></h1>
                    <br><img src="./imgs/level2.png" alt="Icono Falta" class="icono_info"> Nivel: <?php echo $level ?>
                    <br><img src="./imgs/calendario.png" alt="Icono Falta" class="icono_info"> Reservas: <span style="color:#8650fe"><?php echo $reservas ?></span> 
                    <br><img src="./imgs/check.png" alt="Icono Falta" class="icono_info"> Asistencias: <span style="color:#8650fe"><?php echo $_SESSION["Racha"] ?></span> 
                    <br><img src="./imgs/falta.png" alt="Icono Falta" class="icono_info"> Faltas: <span style="color: red;"><?php echo $_SESSION["Faltas"]?></span>
            </article>
            <article id="reservas">
                <span style="color: #8650fe; font-weight: bold;">Tus próximas reservas</span>
                <div id="container_reservas">
                    <?php include("./reservas_pendientes.php") ?>
                </div>
            </article>
        </section>

        <section id="reservas_responsive">
            <p id="titulo_reservas">Tus próximas reservas</p>
            <div id="container_reservas_responsive">
                <?php include("./reservas_pendientes.php") ?>
            </div>
        </section>

        <section class="info_container" id="beneficios_container">    
            <div class="niveles_container">
                <div class="item_nivel" id="recreativo">
                    <div class="item_titulo">Recreativo</div><br>
                    <div class="item_subtitulo">- menos de 25 reservas</div><br>
                    <div class="item_texto">
                        <table>
                            <tr>
                                <td>✅</td><td>Reservás con el 50%</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>Cancelás hasta 24hs antes</td>
                            </tr>
                        </table>
                    </div>
                </div>
        
                <div class="item_nivel" id="local">
                    <div class="item_titulo">Local</div><br>
                    <div class="item_subtitulo">- de 25 a 60 reservas</div><br>
                    <div class="item_texto">
                        <table>
                            <tr>
                                <td>✅</td><td>10% de descuento en canchas</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>Cancelás hasta 12hs antes</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>Reservás con el 50%</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>10% de descuento en bebidas</td>
                            </tr>
                        </table>
                    </div>
                </div>
        
                <div class="item_nivel" id="socio">
                    <div class="item_titulo" style="color: gold">Socio</div><br>
                    <div class="item_subtitulo" style="color: gold">- más de 60 reservas</div><br>
                    <div class="item_texto">
                        <table>
                            <tr>
                                <td>✅</td><td>15% de descuento en canchas</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>Cancelás hasta 12hs antes</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>Reservás con el 10%</td>
                            </tr>
                            <tr>
                                <td>✅</td><td>25% de descuento en cualquier compra del buffet</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- <?php //include("./faqs.php") ?> -->

        <br>
        <div style="background: black;">
            <section id="info_faltas">
                <div class="titulo_info" style="color: white;">
                    Evitá la roja
                </div>
                <div id="texto_faltas">
                    Los beneficios que otorgamos exigen un compromiso mutuo. <br>
                    Para mantener tu nivel de beneficios no podés tener más de 3 faltas.<br> 
                    Por cada vez que canceles fuera del tiempo reglamentario sumás una falta. 
                </div>
            </section>
        </div>

    </main>
    <?php include("./footer.php") ?>
</body>
</html>
<?php include("./nav_desplegable.php") ?>
<script>
    // var navbar_desplegable = document.querySelector(".navbar_desplegable");

    var container_reservas = document.getElementById("container_reservas");
    var div_beneficios = document.getElementById("beneficios");
    var beneficios_container = document.getElementById("beneficios_container");
    var img = document.getElementById("btn_beneficios");
    // var flag = false;
    var flag_beneficios = false;

    div_beneficios.addEventListener('click', ()=>{
        flag_beneficios = !flag_beneficios;
        if(flag_beneficios)
        {
            img.style.transform = "rotate(180deg)";
            beneficios_container.style.display = "flex";
            div_beneficios.className = "beneficios_activo";        
        }
        else
        {
            img.style.transform = "rotate(360deg)";
            beneficios_container.style.display = "none";
            div_beneficios.className = "beneficios_inactivo";
        }
    })

    //Cuando mediante PHP no se pueda detectar que no hay reservas pendientes,
    //que es en el caso en que habían reservas pendientes para ese día pero ya pasó la hora,
    //se detecta mediante JavaScript con este código
    if(container_reservas.childElementCount == 0){
        var div = document.createElement("div");
        div.className = "reserva";
        div.innerHTML = "No tenés reservas pendientes...";
        container_reservas.appendChild(div);
    }
</script>
