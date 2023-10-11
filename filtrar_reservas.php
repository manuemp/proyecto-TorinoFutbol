<?php 
    session_start();
    if(!isset($_POST["filtro_cancha"]))
    {
        header("Location:index.php");
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

    $conexion = mysqli_connect("localhost", "root", "", "TorinoFutbol") or die("No fue posible conectarse a la base de datos...");
    $email = $_SESSION["Email"];
    $cancha = $_POST["filtro_cancha"];
    
    if($cancha != "")
        $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha FROM Reservas WHERE Email = '$email' AND Cancha = $cancha");
    else
        $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha FROM Reservas WHERE Email = '$email'");

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $subarray = [];
        $subarray["Dia"] = date("d/m/Y", strtotime($fila["Dia"]));
        $subarray["Hora"] = $fila["Hora"];
        $subarray["Cancha"] = generarCancha($fila["Cancha"]);
        array_push($arr, $subarray);
    }

    $array = json_encode($arr);

    echo $array;

?>