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
        @media(max-width: 920px)
        {
            #texto_niveles
            {
                font-size: 2rem;
            }
        }

        @media(max-width: 650px)
        {
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
                font-size: 3.4rem;
            }

            #texto_niveles{
                font-size: 1.2rem;
            }

            #titulo_reservas{
                font-size: 2.4rem;
                text-align: center;
            }

            .reserva{
                font-size: 1.2rem;
                text-align: center;
            }

            .info_titulo{
                font-size: 2.2rem;
            }

            .info_texto{
                font-size: 1.5rem;
            }
        }

        @media(max-width: 425px){
            #texto_niveles{
                font-size: 1rem;
            }
        }

        @media(max-width: 360px){

            #titulo_reservas{
                font-size: 2rem;
            }

            .reserva{
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <span id="modal_background"></span>
    <main>
        <!-- MODAL -->
        <div id="modal_inicio_sesion">
            <div class="modal_nav">
                <span class="modal_cerrar">X</span>
            </div>
            <div class="modal_main" style="margin: auto;">
                <p class="modal_titulo">¡Ingresá en Torino Fútbol!</p><br>
                <span style="font-size: 1rem; color: gray; display: block; margin-top: -15px">admin: adminTorino@gmail.com - pass: 12345678</span>
                <form action="./iniciar_sesion.php" method="post">
                    <div class="form_opcion">
                        <label for="email">Correo Electrónico</label>
                        <input class="modal_input" type="email" name="email" required autocomplete="off">
                    </div>
                    <div class="form_opcion">
                        <label for="pass">Contraseña</label>
                        <input class="modal_input" type="password" name="pass" required autocomplete="off">
                    </div>
                    <div class="form_opcion">
                        <input class="modal_enviar modal_input" type="submit" value="Iniciar Sesión">
                    </div>
                </form>
            </div>
        </div>

        <!-- PORTADA -->
        <h1 class="bienvenido">
            Buscá tu Cancha. <br>
            Reservá. <br>
            Jugá.
        </h1>
    
        <div class="info_container">
            <div class="info_titulo">Alquilá con nosotros, <br>disfrutá de los beneficios</div><br>
            <div class="info_texto">
                En Torino Fútbol premiamos la constancia de nuestros clientes. <br>
                Registrate, acumulá tus reservas y disfrutá de beneficios en precios y gestiones.
            </div>
            <br>
    
            <!-- TARJETAS -->
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
        </div>

        <?php include("./faqs.php") ?>

        <div class="info_container">
            <div class="info_titulo" style="text-align: center;">Canchas que hacen la diferencia</div><br>
            <div class="info_texto" style="text-align: center;">Césped sintético profesional<br>Sistemas de alto drenaje anti-inundación</div>
        </div>
        
        <div id="sintetico">
        </div>

    </main>

    <?php include("./footer.php") ?>
</body>
</html>
<?php include("./nav_desplegable.php") ?>
<script>

    var iniciar_sesion_desplegable = document.getElementById("iniciar_sesion_desplegable");
    var iniciar_sesion = document.getElementById("iniciar_sesion");
    var modal = document.getElementById("modal_inicio_sesion");
    var modal_fail = document.getElementById("modal_inicio_sesion_fail");
    var cerrar_modal = document.querySelectorAll(".modal_cerrar");
    var modal_background = document.getElementById("modal_background");
    
    window.onbeforeunload = history.pushState(null, null, "index.php");
    
    iniciar_sesion.addEventListener('click', ()=>
    {
        modal_background.style.display = "block";
        modal.style.display = "block";
    });

    iniciar_sesion_desplegable.addEventListener('click', ()=>
    {
        modal_background.style.display = "block";
        modal.style.display = "block";
    });

    cerrar_modal.forEach(cerrar =>{
        cerrar.addEventListener('click', ()=>
        {
            modal_background.style.display = "none";
            modal.style.display = "none";
            modal_fail.style.display = "none";
        });
    })

</script>
