<?php 
    include("./conexion.php");

    $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha, Nombre, Apellido, Email FROM Reservas");
    $contador = mysqli_num_rows($resultado);
    
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->dia = $fila['Dia'];
        $obj->hora = $fila['Hora'];
        $obj->cancha = $fila['Cancha'];
        $obj->nombre = $fila['Nombre'];
        $obj->apellido = $fila['Apellido'];
        $obj->email = $fila['Email'];
        array_push($arr, $obj);
    }
    
    echo json_encode($arr);
?>