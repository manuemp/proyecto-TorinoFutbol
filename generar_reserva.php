<?php session_start(); ?>
<?php
    if(!(isset($_SESSION["Nombre"]) && isset($_POST["select_dia"]) && isset($_POST["select_cancha"]) && isset($_POST["select_hora"])))
    {
        header("Location:index.php");
    }
    
    $dia = $_POST["select_dia"];
    $cancha = $_POST["select_cancha"];
    $hora = $_POST["select_hora"];
    $nombre = $_SESSION["Nombre"];
    $apellido = $_SESSION["Apellido"];
    $email = $_SESSION["Email"];

    include("./conexion.php");

    $consulta_reservas = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Dia = '$dia' AND Hora = '$hora' AND Cancha = '$cancha'");
    $resultado_reservas = mysqli_num_rows($consulta_reservas);

    $consulta_usuario = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Dia = '$dia' AND Hora = '$hora' AND Email = '$email'");
    $resultado_usuario = mysqli_num_rows($consulta_usuario);

    if($resultado_usuario > 0)
    {
        header("Location:superposicion_reservas.php");
        exit;
    }

    

    if($resultado_reservas == 0)
    {
        $consulta_reservas = mysqli_query($conexion, "INSERT INTO Reservas (Dia, Hora, Cancha, Nombre, Apellido, Email) 
                                            VALUES ('$dia', '$hora', '$cancha', '$nombre', '$apellido', '$email')");
        $consulta_id = mysqli_query($conexion, "SELECT MAX(ID) AS ID FROM Reservas");
        $id = mysqli_fetch_assoc($consulta_id)["ID"];
    
        $consulta_reservas = mysqli_query($conexion, "UPDATE Usuarios SET Racha = Racha + 1 WHERE Email = '$email'");
        header("Location:reserva_confirmada.php?cancha=$cancha&dia=$dia&hora=$hora&id_reserva=$id");
        // header("Location:index.php");
    }
    //Llevar a una página de error en la reserva que después de 3 segundos redireccione al index


?>