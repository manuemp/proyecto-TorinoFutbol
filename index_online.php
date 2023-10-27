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
            background-image: url("./imgs/sintetico4.png");
            background-repeat: no-repeat;
            background-size: cover;
        }

        #info_niveles
        {
            background-image: url("./imgs/tarjeta.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        .titulo_info
        {
            font-weight: bold;
            font-size: 6rem;
        }

        .texto_info
        {
            font-weight: bold;
            font-size: 4rem;
        }

        #texto_niveles
        {
            color: white;
            font-weight: normal;
            font-size: 2.7rem;
        }

        #reservas
        {
            height: 100%;
            padding: 30px;
            box-sizing: border-box;
        }

        #container_reservas
        {
            height: 200px;
            width: 100%;
            border: 2px solid white;
            border-radius: 10px;
            padding: 10px;
            box-sizing: border-box;
            background-color: white;
            overflow: scroll;
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
            transition: 1s;
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
            margin-top: 25px;
            margin-bottom: -14px;
            transition: 1s;
            cursor: pointer;
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
            height: 40px;
        }

        .btn_triangulo{
            height: 15px;
            margin-left: 10px;
        }

        @media(max-width: 920px)
        {
            #texto_niveles{
                font-size: 2rem;
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

            #container_reservas{
                height: auto;
            }

            .texto_info{
                font-size: 2.7rem;
            }

            .titulo_info{
                font-size: 3.2rem;
            }

            #texto_niveles{
                font-size: 1.2rem;
            }

            #titulo_reservas{
                font-size: 2.4rem;
                text-align: center;
            }

            .reserva, .reserva_perdida{
                font-size: 1.2rem;
                text-align: center;
            }
        }

        @media(max-width: 425px){
            #texto_niveles{
                font-size: 1rem;
            }

            .titulo_info{
                font-size: 2.5rem;
            }

            .texto_info{
                font-size: 2rem;
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
        
        <div class="info_container" id="info_usuario">
            <h1 class="titulo_info" style="color:#e1ff00; margin-bottom: 0;"><?php echo $_SESSION["Nombre"] . " " . $_SESSION["Apellido"] ?></h1>
            <div class="texto_info" style="color: white; text-shadow: 3px 3px 0px darkviolet">
                                                      <img src="./imgs/bandera.webp" alt="Icono Falta" class="icono_info"> Jugador <?php echo $level ?> 
                                                      <br><img src="./imgs/calendario.png" alt="Icono Falta" class="icono_info"> Reservas: <?php echo $reservas ?>   
                                                      <br><img src="./imgs/check.png" alt="Icono Falta" class="icono_info"> Asistencias: <?php echo $_SESSION["Racha"] ?> 
                                                      <br><img src="./imgs/falta.png" alt="Icono Falta" class="icono_info"> Faltas: <?php echo $_SESSION["Faltas"]?></div>
        </div>

        <section id="reservas">
            <p id="titulo_reservas">Tus próximas reservas</p>
            <div id="container_reservas">
                <?php include("./reservas_pendientes.php") ?>
            </div>
        </section>

        <div id="beneficios" class="beneficios_inactivo">Ver Beneficios <img src="./imgs/btn_triangulo_1.png" class="btn_triangulo"></div>

        <section class="info_container" id="beneficios_container" style="display: none;">
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
                                <td>✅</td><td>10% de descuento en cualquier compra del buffet</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <br>
        <section class="info_container" id="info_niveles">
            <div class="titulo_info" style="color: white;">Evitá la roja</div>
            <div id="texto_niveles">
                Los beneficios que otorgamos exigen un compromiso mutuo. <br>
                Para mantener tu nivel de beneficios no podés tener más de 3 faltas.<br> 
                Por cada vez que canceles fuera del tiempo reglamentario sumás una falta. </div>
        </section>

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
    // var flag = false;
    var flag_beneficios = false;

    div_beneficios.addEventListener('click', ()=>{
        flag_beneficios = !flag_beneficios;
        if(flag_beneficios)
        {
            var img = document.createElement("img");
            img.setAttribute("src", "./imgs/btn_triangulo_2.png");
            img.className = "btn_triangulo";
            beneficios_container.style.display = "flex";
            div_beneficios.className = "beneficios_activo";
            div_beneficios.innerHTML = "Ver Beneficios"
            div_beneficios.appendChild(img);
            
        }
        else
        {
            var img = document.createElement("img");
            img.setAttribute("src", "./imgs/btn_triangulo_1.png");
            img.className = "btn_triangulo";
            beneficios_container.style.display = "none";
            div_beneficios.className = "beneficios_inactivo";
            div_beneficios.innerHTML = "Ver Beneficios"
            div_beneficios.appendChild(img);
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
