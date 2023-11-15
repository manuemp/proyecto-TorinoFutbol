<?php session_start(); ?>
<?php 

    //Prohibir acceso si no se enviaron las variables del formulario
    if(!(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["pass"]) && isset($_POST["email"])))
    {
        header("Location:index.php");
    }

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $pass = sha1($_POST['pass']);
    $email = $_POST['email'];

    include("./conexion.php");

    $consulta = mysqli_query($conexion, "INSERT INTO Usuarios (Nombre, Apellido, Email, Pass, Faltas, Racha, Administrador) VALUES ('$nombre', '$apellido', '$email', '$pass', 0, 0, 0)");
    $consulta = mysqli_query($conexion, "SELECT Nombre, Apellido, Email, Faltas, Racha, Administrador FROM Usuarios WHERE Email='$email'");
    $data = mysqli_fetch_assoc($consulta);
    
    //Asigno los valores a la sesion
    $_SESSION['Nombre'] = $data['Nombre'];
    $_SESSION['Apellido'] = $data['Apellido'];
    $_SESSION['Email'] = $data['Email'];
    $_SESSION['Faltas'] = $data['Faltas'];
    $_SESSION['Racha'] = $data['Racha'];
    $_SESSION['Administrador'] = $data['Administrador'];

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>