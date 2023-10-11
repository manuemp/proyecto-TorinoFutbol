<?php 
    if(!isset($_SESSION["Nombre"]))
    {
        header("Location: index.php");
    }

    function generarCancha($cancha)
    {
        switch ($cancha)
        {
            case "1":
                return "Fútbol 5 (A)";
            case "2":
                return "Fútbol 5 (B)";
            case "3":
                return "Fútbol 7 (A)";
            case "4":
                return "Fútbol 7 (B)";
            case "5":
                return "Fútbol 8 (A)";
            case "6":
                return "Fútbol 8 (B)";
        }
    }

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $hoy = date('Y-m-d');


    include("./conexion.php");
    $email = $_SESSION["Email"];

    $consulta = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Email = '$email' AND Dia >= '$hoy' ORDER BY Dia");

    if(mysqli_num_rows($consulta) == 0)
    {
        echo "<div class='reserva'>No tenés reservas pendientes...</div>";
    }
    else
    {
        while($fila = $consulta->fetch_assoc())
        {
            if($fila["Dia"] == date("Y-m-d"))
            {
                //Evitar que la reserva de un mismo día aparezca cuando ya pasó la hora
                if(strtotime($fila["Hora"]) > strtotime(date("H:i")))
                    echo "<div class='reserva'>[id: " .  $fila["ID"] ."] - " . generarCancha($fila["Cancha"]) . " - " . date("d/m/y", strtotime($fila["Dia"])) . " - " . $fila["Hora"] . " hs</div>";
            }
            else
            {
                echo "<div class='reserva'>[id: " .  $fila["ID"] ."] - " . generarCancha($fila["Cancha"]) . " - " . date("d/m/y", strtotime($fila["Dia"])) . " - " . $fila["Hora"] . " hs</div>";
            }
        }
    }


?>