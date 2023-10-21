<?php session_start(); ?>
<?php 
    include("./conexion.php");
    $email = $_SESSION["Email"];

    $consulta = mysqli_query($conexion, "SELECT COUNT(1) AS 'Contador' FROM Reservas WHERE Email = '$email' AND DATEDIFF(Dia, CURRENT_DATE()) > 0");
    $fila = $consulta->fetch_assoc();

    if(intval($fila["Contador"]) >= 3)
    {
        header("Location:exceso_reservas.php");
    }

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    
    //Indices de i para el bucle del select del día para reservar
    $dia_inicio = 0;
    $dia_limite = 7;

    //Si ya pasaron las 21.30, se empiezan a reservar las canchas del día siguiente
    if(strtotime(date("H:i")) > strtotime("21:30:00"))
    {
        $dia_inicio = 1;
        $dia_limite = 8;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./jquery.js"></script>
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <title>Reservas</title>
    <style>

        #reservas
        {
            margin: auto;
            width: 100%;
            height: 100%;
            background-color: white;
            padding: 40px;
            box-sizing: border-box;
            overflow: scroll;
        }

        .titulo_reserva
        {
            color: crimson;
            font-size: 3.5rem;
            font-weight: bold;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        .select_reserva
        {
            width: 50%;
            display: block;
            margin: 20px auto;
            height: 60px;
            font-size: 2rem;
            font-weight: bold;
            box-sizing: border-box;
            border-radius: 20px;
            text-align: center;
            border: 2px solid rgb(238, 236, 236);
            cursor: pointer;
        }

        body
        {
            width: 100%;
            min-height: 100vh;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
        }

        #reservar
        {
            width: 20%;
            background-color: greenyellow;
            cursor: pointer;
        }

        main{
            height: 62vh;
        }

        form{
            height: 100%;
        }

        #arrow{
            position: absolute;
            height: 50px;
            filter: opacity(0.5);
        }

        @media (max-width: 900px){
            .select_reserva{
                height: 50px;
                font-size: 1.6rem;
            }
            .titulo_reserva{
                font-size: 2.8rem;
            }
        }

        @media(max-width: 650px){
            main{
                height: 75vh;
            }

            .select_reserva{
                width: 90%;
            }

            #reservar{
                width: 40%;
            }

            #arrow{
                height: 30px;
            }
        }

        @media(max-width: 380px){
            .select_reserva{
                width: 100%;
                font-size: 1.2rem;
            }

            #reservar{
                width: 60%;
            }

            .titulo_reserva{
                margin-top: 30px;
                font-size: 2.2rem;
            }
        }

    </style>
</head>
<body>
    <?php include("./nav_online.php") ?>
    <main>
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
        <form action="./generar_reserva.php" method="post">
            <section id="reservas">
                <h1 class="titulo_reserva" style="margin: 0;">Hacé tu reserva</h1><br>
                <select name="select_dia" class="select_reserva" id="select_dia">
                    <?php 
                        for($i = $dia_inicio ; $i < $dia_limite ; $i++)
                        {
                           echo "<option value='" .  date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "'>" . date('d/m/y', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "</option>";
                        }
                    ?>
                </select>
            
                <select name="select_cancha" class="select_reserva" id="select_cancha">
                    <option value="-1">Seleccionar Cancha</option>
                    <option value="1">F5 A</option>
                    <option value="2">F5 B</option>
                    <option value="3">F7 A</option>
                    <option value="4">F7 B</option>
                    <option value="5">F8 A</option>
                    <option value="6">F8 B</option>
                </select>

                <select name="select_hora" class="select_reserva" id="select_hora" disabled>
                    <option value="">Seleccione día y cancha</option>
                </select>

                <input type="submit" class="select_reserva" value="Reservar" id="reservar" disabled>
            </section>
        </form>
    </main>

    <?php include("./footer.php") ?>

</body>
</html>

<?php include("./nav_desplegable.php") ?>

<script>

    let select_hora = document.getElementById("select_hora");
    let select_dia = document.getElementById("select_dia");
    let select_cancha = document.getElementById("select_cancha");

    let dia;
    let cancha;
    const date = new Date();
    hoy = date.toLocaleDateString('en-CA');
    let horarios = ["10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00",
                    "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00"];
    
    select_dia.addEventListener('change', filtrar_horarios);

    select_cancha.addEventListener('change', ()=>{
        select_hora.removeAttribute("disabled");
        document.getElementById("reservar").removeAttribute("disabled");
        filtrar_horarios();
    });

    function filtrar_horarios()
    {
        dia = select_dia.value;
        cancha = select_cancha.value;

        //Busco todas las reservas hechas hasta el momento y las coloco en un array
        $.ajax({
            url: './reservas_disponibles.php',
            type: 'get',
            success: function (data) {
                const respuesta = JSON.parse(data); 
                $(select_hora).empty();
                let arr = [];
                
                //Agrego las horas ocupadas a un array
                respuesta.forEach(rta =>{
                    if(rta['dia'] == dia && rta['cancha'] == cancha && parseInt(rta['asistio']) == 1)
                    {
                        console.log(rta);
                        arr.push(rta['hora']);
                    }
                })
                
                horarios.forEach(horario =>{
                    //Por cada horario posible (10 a 22) averiguo que el horario
                    //que se está iterando sea mayor que la hora actual, ya que no puedo
                    //reservar una hora que ya pasó.
                    //También chequeo que esa hora no esté entre las horas que ya fueron
                    //reservadas para la cancha y el día indicados.
                    if(hoy == dia)
                    {
                        if(parseInt(horario) > parseInt(date.getHours()) && !arr.includes(horario))
                        {
                            let opcion = document.createElement("option");
                            opcion.value = horario;
                            opcion.innerHTML = horario;
                            select_hora.append(opcion);
                        }
                    }
                    else
                    {
                        //Para los días que no sean hoy, no dependo de la hora que sea
                        //para reservar, solamente de los horarios disponibles
                        if(!arr.includes(horario))
                        {
                            let opcion = document.createElement("option");
                            opcion.value = horario;
                            opcion.innerHTML = horario;
                            select_hora.append(opcion);
                        }
                    }
                })
            }
        });
    }
</script>




