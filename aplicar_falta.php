<?php 
   $email = $_POST["email"];
   $id = $_POST["id_reserva"];

   include("./conexion.php");

   $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = Faltas + 1, Racha = Racha - 1 WHERE Email = '$email'");
   $consulta = mysqli_query($conexion, "UPDATE Reservas SET Asistio = 0 WHERE ID = $id");
   $consulta = mysqli_query($conexion, "SELECT Faltas FROM Usuarios WHERE Email = '$email'");
   $resultado = intval(mysqli_fetch_assoc($consulta)["Faltas"]);
   if($resultado > 3)
   {
      $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = 0, Racha = 0 WHERE Email = '$email'");
   }
?>