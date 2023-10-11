<?php 
    include("./conexion.php");

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

    $cancha = $_POST["filtro_cancha"];
    $dia = $_POST["filtro_dia"];
    $email = $_POST["filtro_email"];

    $resultado = mysqli_query($conexion, "SELECT ID, Dia, Hora, Cancha, Nombre, Apellido, Email FROM Reservas WHERE Dia >= '$hoy' AND Cancha LIKE '%$cancha%' AND Email LIKE '%$email%' AND Dia LIKE '%$dia%'  ORDER BY Dia");
    $contador = mysqli_num_rows($resultado);
    
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->id = $fila["ID"];
        $obj->dia = date("d/m/Y", strtotime($fila['Dia']));
        $obj->hora = $fila['Hora'];
        $obj->cancha = generarCancha($fila['Cancha']);
        $obj->nombre = $fila['Nombre'];
        $obj->apellido = $fila['Apellido'];
        $obj->email = $fila['Email'];
        array_push($arr, $obj);
    }
    
    echo json_encode($arr);
?>