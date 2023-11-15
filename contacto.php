<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./estilos/modal.css">
    <title>TorinoFútbol: Contacto</title>
    <style>


        main{
            min-height: 95vh;
            overflow: scroll;
        }

        h1{
            font-size: 2.5rem;
            color: white;
        }

        a{
            color: greenyellow;
        }

        main{
            background-image: url("./imgs/fondo_inicio2.jpeg");
            background-repeat: no-repeat;
            background-size:cover;
        }

        #contacto, #whatsapp_contacto{
            width: 500px;
            height: auto;
            margin: 15px auto;
            overflow: hidden;
            border-radius: 15px;
            /* box-shadow: 1px 9px 13px 0px lightgray; */
        }

        #header_contacto{
            padding: 10px 20px;
            background: linear-gradient(45deg, #570cff, #9363fb);
            border-bottom: 2px solid #3e139c;
        }

        #body_contacto{
            background-color: white;
            padding: 20px;
        }

        .input_contacto{
            display: block;
            border: 2px solid rgb(238, 236, 236);
            border-radius: 10px;
            height: 30px;
            margin: 10px 0px 20px 0px;
            width: 200px;
            transition: 0.5s;
            padding-left: 15px;
            font-weight: bold;
        }

        .input_contacto:focus{
            border: 2px solid #8650fe;
        }

        input:focus, textarea:focus{
            outline: none;
        }

        textarea:focus{
            border: 2px solid #8650fe;
        }

        label{
            font-size: 1.5rem;
            font-weight: bold;
            color: #3e139c;
        }

        #enviar_contacto{
            height: 35px;
            width: 100px;
            border: none;
            background-color: palegreen;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            cursor:pointer;
        }

        textarea{
            display: block;
            /* width: 100%; */
            min-width: 100%;
            max-width: 100%;
            height: 120px;
            min-height: 120px;
            max-height: 350px;
            border: 2px solid rgb(238, 236, 236);
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
            /* font-size: 1.5rem; */
            font-family: inherit;
        }

        #whatsapp_contacto{
            color: white;
            font-weight: bold;
            background: linear-gradient(45deg, dodgerblue, #0081ff);
            height: 80px;
            padding: 18px;
            font-size: 1.5rem;
            box-sizing: border-box;
            text-align: center;
            /* display: flex;
            align-items: center;
            justify-content: center; */
        }

        #mail_enviado{
            display: block;
            padding: 20px;
            background: #0aae0a;
            font-size: 1.5rem;
            text-align: center;
            font-weight: bold;
            color: white;
            border-bottom: 3px solid palegreen;
        }

        #error_mail{
            display: block;
            padding: 20px;
            background: red;
            font-size: 1.5rem;
            text-align: center;
            font-weight: bold;
            color: white;
            border-bottom: 3px solid crimson;
        }

        @media(max-width: 650px){
            #contacto{
                width: 95%;
                margin-top: 60px;
            }

            #whatsapp_contacto{
                font-size: 1.2rem;
                width: 95%;
            }
        }
    </style>
</head>
<body>

    <?php 
    
        $respuesta_mail = "";

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $nombre = $_POST["nombre_contacto"];
            $email = $_POST["email_contacto"];
            $mensaje = $_POST["mensaje"];
            $asunto = "TorinoFútbol: Consulta de " . $nombre;
            $destino = "manuel.em.pedro@gmail.com";

            $header = "From: " . $nombre . "<" . $email . ">";

            $enviado = mail($destino, $asunto, $mensaje, $header);

            if($enviado)
            {
                $respuesta_mail = "<span id='mail_enviado'>¡Mail enviado correctamente!</span>";
            }
            else
            {
                $respuesta_mail = "<span id='error_mail'>¡Hubo un problema al enviar el mail! Por favor, intenta nuevamente</span>";
            }
        }
    
    ?>

    <span id="modal_background"></span>
    <!-- <nav class="nav1"></nav> -->
    <?php 
        if(isset($_SESSION["Nombre"]))
            include("./nav_online.php");
        else
            include("./nav_offline.php");
    ?>
    <?php echo $respuesta_mail  ?>
    <main>
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
        <!-- MODAL -->
        <div id="modal_inicio_sesion">
            <div class="modal_nav">
                <span class="modal_cerrar">X</span>
            </div>
            <div class="modal_main" style="margin: auto;">
                <p class="modal_titulo">¡Ingresá en Torino Fútbol!</p><br>
                <span style="font-size: 1rem; color: gray; display: block; margin-top: -15px">admin: admintorino@gmail.com - pass: 12345678</span>
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
        <article id="contacto">
            <div id="header_contacto">
                <h1>Contacto TorinoFútbol</h1>
                <p style="color: white; font-weight: bold">¿Tenés alguna consulta? ¡No dudes en escribirnos!</p>
            </div>
            <div id="body_contacto">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="nombre">Nombre y Apellido</label>
                    <input class="input_contacto" type="text" name="nombre_contacto" id="nombre_contacto" autocomplete="off" required>
                    <label for="email">Email</label>
                    <input class="input_contacto" type="email" name="email_contacto" id="email_contacto" autocomplete="off" required>
                    <label for="consulta">Mensaje</label>
                    <textarea name="mensaje" id="mensaje" cols="30" rows="10"></textarea>
                    <input type="submit" id="enviar_contacto">
                </form>
            </div>
        </article>
        <article id="whatsapp_contacto">
            ¡Recordá que también podés comunicarte con nosotros vía Whatsapp al <a href="https://wa.me/1159807762/?text=Hola!%20Quiero%20hacer%20una%20consulta%20sobre%20TorinoFutbol" target="_blank">1159807762</a>!
        </article>
    </main>
<!-- <footer class="footer"></footer> -->
</body>
</html>

<?php include("./nav_desplegable.php") ?>
<script>
    var iniciar_sesion_desplegable = document.getElementById("iniciar_sesion_desplegable");
    var iniciar_sesion = document.getElementById("iniciar_sesion");
    var modal = document.getElementById("modal_inicio_sesion");
    var cerrar_modal = document.querySelectorAll(".modal_cerrar");
    var modal_background = document.getElementById("modal_background");

    //Codigo para evitar que me reenvíe el formulario y nunca desaparezca el mensaje de 
    //'mail enviado correctamente'
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

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
