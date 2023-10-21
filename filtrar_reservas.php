<?php session_start(); ?>
<?php 
    if(!isset($_POST["filtro_cancha"])){
        header("Location:index.php");
    }

    // function generarCancha($cancha)
    // {
    //     switch ($cancha)
    //     {
    //         case "1":
    //             return "Fútbol 5 (A)";
    //         case "2":
    //             return "Fútbol 5 (B)";
    //         case "3":
    //             return "Fútbol 7 (A)";
    //         case "4":
    //             return "Fútbol 7 (B)";
    //         case "5":
    //             return "Fútbol 8 (A)";
    //         case "6":
    //             return "Fútbol 8 (B)";
    //     }
    // }

    include("./generar_cancha.php");
    include("./conexion.php");

    $email = $_SESSION["Email"];
    $cancha = $_POST["filtro_cancha"];
    
    if($cancha != "")
        $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha, Asistio FROM Reservas WHERE Email = '$email' AND Cancha = $cancha ORDER BY Dia DESC");
    else
        $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha, Asistio FROM Reservas WHERE Email = '$email' ORDER BY Dia DESC");

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $subarray = [];
        $subarray["Dia"] = date("d/m/Y", strtotime($fila["Dia"]));
        $subarray["Hora"] = $fila["Hora"];
        $subarray["Cancha"] = generarCancha($fila["Cancha"]);
        $subarray["Asistio"] = $fila["Asistio"];
        array_push($arr, $subarray);
    }

    $array = json_encode($arr);

    echo $array;

?>