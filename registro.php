<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <style>
        main
        {
            display: flex;
            min-height: 100%;
        }

        .img_container
        {
            min-width: 45%;
            min-height: 100vh;
            background: linear-gradient(45deg, lavender, white);
            background-image: url("./imgs/jugador_pelota5.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        #titulo_registro
        {
            font-size: 3rem;
        }

        .registro_container
        {
            min-height: 100vh;
            height: 100%;
            width: 55%;
            color: white;
            background: radial-gradient(#6b27fc, #270c63);
            padding: 20px;
            box-sizing: border-box;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }

        #table_registro
        {
            width: 100%;
        }

        form
        {
            width: 70%;
            margin: auto;
        }

        #table_registro td
        {
            width: 50%;
        }

        label
        {
            display: block;
            margin-bottom: 10px;
        }

        .form_container
        {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form_opcion
        {
            margin-top: 10px;
            margin-bottom: 15px;
            margin-right: 10px;
        }
        
        .form_input
        {
            width: 200px;
            height: 30px;
            background-color: #00053d;
            border: 2px solid white;
            padding: 5px;
            color: white;
            font-weight: bold;
            display: block;
        }

        #enviar
        {
            background-color: rgb(37, 92, 255);
            height: 45px;
            cursor: pointer;
            width: 214px;
            margin-top: 25px;
        }

        .logo
        {
            margin: 5px 10px;
            position: absolute;
            right: 45%;
        }

        #arrow{
            position: absolute;
            height: 50px;
            left: 10px;
            filter: invert(1);
        }

        
        @media (min-width: 1450px)
        {
            form
            {
                width: 500px;
            }
        }

        @media( max-width: 1236px)
        {
            .form_container
            {
                justify-content: center;
            }

            #titulo_registro
            {
                width: fit-content;
                margin: 30px auto;
            }
        }

        @media(max-width: 950px)
        {
            form
            {
                width: 90%;
            }
            #titulo_registro
            {
                font-size: 2.4rem;
            }
        }

        @media(max-width: 600px)
        {
            .img_container
            {
                display: none;
            }

            .registro_container
            {
                width: 100%;
                background-image: url("./imgs/jugador_pelota11violeta.png");
                background-size: cover;
                background-repeat: no-repeat;
            }

            form
            {
                width: 70%;
            }

            #titulo_registro {
                font-size: 2rem;
                margin-top: 50px;
            }

            .logo{
                right: 6px;
            }
        }

    </style>
    <title>Torino Fútbol: Registro</title>
</head>
<body>

    <?php 
    
    $nombre_err = $apellido_err = $email_err = "";
    $nombre = $apellido = $email = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nombre = $_POST["nombre"];
        if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {  
            $nombre_err = "<br>Usá solo letras y espacios";  
        } 

        $apellido = $_POST["apellido"];
        if (!preg_match("/^[a-zA-Z ]*$/",$apellido)) {  
            $apellido_err = "<br>Usá solo letras y espacios";  
        } 

        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
            $email_err = "<br>Formato de mail inválido";  
        }
        else
        {
            include("./conexion.php");
            $consulta_mail = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE Email = '$email'");
            if(mysqli_num_rows($consulta_mail) > 0)
            {
                $email_err = "<br>Correo electrónico en uso";
            }
        }
    }
    
    ?>


    <main>
        <div style="display: block;">
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
            <img src="./imgs/torinoLogoBlanco_2.png" class="logo" alt="logoTorino">
        </div>
        <div class="registro_container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <p id="titulo_registro">Registrate, jugá en<br>las mejores canchas</p>
                </div>
                <div class="form_container">

                    <div class="form_opcion">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form_input" id="nombre" autocomplete="off" name="nombre" required>
                        <span style="color:red;font-weight:bold;font-style:italic"><?php echo $nombre_err ?></span>
                    </div>
    
                    <div class="form_opcion">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form_input" id="apellido" autocomplete="off" name="apellido" required>
                        <span style="color:red;font-weight:bold;font-style:italic"><?php echo $apellido_err ?></span>
                    </div>
    
                    <div class="form_opcion">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form_input" id="email" autocomplete="off" name="email" required>
                        <span style="color:red;font-weight:bold;font-style:italic;"><?php echo $email_err ?></span>
                    </div>
    
                    <div class="form_opcion">
                        <label for="pass">Contraseña</label>
                        <input type="password" class="form_input" id="pass" autocomplete="off" name="pass" required>
                    </div>
    
                    <input type="submit" name="enviar" id="enviar" value="Registrarme" class="form_input form_opcion">
                </div>
            </form>
        </div>
        <div class="img_container">
    
        </div>
    </main>
</body>

    <?php
        
        if(isset($_POST["enviar"]))
        {
            if($nombre_err == "" && $apellido_err == "" && $email_err == "")
            { 
                include("./registrar_usuario.php");
                //Como los headers ya fueron enviados no puedo usar header(Location);
                //En cambio tengo que hacer la redirección via JS...
                echo "<script>location.href = './index.php'</script>";
            }
        }
    ?>

</html>