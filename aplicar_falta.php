<?php 
   $email = $_POST["email"];

   include("./conexion.php");

   $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = Faltas + 1 WHERE Email = '$email'");
   $consulta = mysqli_query($conexion, "SELECT Faltas FROM Usuarios WHERE Email = '$email'");
   $resultado = intval(mysqli_fetch_assoc($consulta)["Faltas"]);
   if($resultado > 3)
   {
      $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = 0, Racha = 0 WHERE Email = '$email'");
   }
?>