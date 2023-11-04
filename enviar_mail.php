<?php session_start(); ?>
<?php 

    include("./conexion.php");

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $mensaje = $_POST["mensaje"];
    $asunto = "TorinoFútbol: Consulta de " . $nombre;
    $destino = "manuel.em.pedro@gmail.com";

    $header = "From: " . $nombre . "<" . $email . ">";

    $enviado = mail($destino, $asunto, $mensaje, $header);

    

?>