<?php 

    session_start();

    if(intval($_SESSION["Administrador"]) != 1)
    {
        header("Location:index.php");
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
    <title>TorinoFútbol: Admin - Reservas</title>
    <style>
        body, html
        {
            height: 100%;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .nav_admin
        {
            height: 55px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #8650fe;
        }

        main
        {
            display: flex;
            justify-content: center;
            align-content: center;
            flex-wrap: wrap;
            height: 60vh;
        }

        .logo
        {
            width: 120px;
            margin-left: 10px;
            cursor: pointer;
        }

        .opcion
        {
            cursor: pointer;
            color: #8650fe;
            font-size: 20px;
            font-weight: bold;
            padding: 14px;
            margin-right: 15px;
            border-radius: 10px;
        }

        a
        {
            text-decoration: none;
        }

        #admin_links
        {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 500px;
        }

        .admin_btn
        {
            background-color: white;
            width: 130px;
            border-radius: 0;
            border: 2px solid #8650fe;
            cursor: pointer;
            text-align: center;
            transition: 1s;
        }

        .admin_btn:hover
        {
            background-color: #d0bbff;
        }

        h1
        {
            color:#8650fe;
            font-size: 2.5rem;
        }

        .item_historial
        {
            width: 100%;
            height: 60px;
            background-color: whitesmoke;
            color: #8650fe;
            display: flex;
            justify-content: space-around;
            border-radius: 10px;
            margin-bottom: 5px;
            /* transition: 1s; */
            cursor: pointer;
        }

        .item_historial:hover
        {
            background-color: #702eff;
            color: white;
        }

        table
        {
            width: 100%;
            /* height: 100%; */
        }

        thead, th
        {
            position: sticky;
            top: 0;
            /* font-size: 1.5rem; */
        }

        .td_historial
        {
            /* width: 10%; */
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content:left;
            font-size: 1rem;
        }

        #th_historial
        {
            background-color: #333;
            color: white;
            border-radius: 20px 20px 0 0;
        }

        #filtros_historial
        {
            margin-top: 8px;
            color: white;
            height: 70px;
            background: linear-gradient(45deg, #481f9e, #8650fe 80%);
        }

        #container_filtro
        {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        select, input
        {
            width: 180px;
            height: 35px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: inherit;
            text-align: center;
            font-weight: bold;
            margin-right: 15px;
        }

        .nombre, .apellido{
            width: 12%;
        }

        .email{
            width: 20%
        }

        .cancha, .dia, .hora, .boton{
            width: 10%;
            justify-content: center;
        }

        .boton{
            text-align: right;
        }

        .btn_aplicar_falta{
            position: relative;
            top: -6px;
            width: 300px;
            height: 42px;
            background-color: red;
            border-radius: 0px 0px 10px 10px;
            font-family: inherit;
            color: white;
            transition: 1s;
            border: none;
            cursor: pointer;
        }

        .btn_baja{
            width: 60px;
            height: 60px;
            margin: -1px -12% 0px 0px;
            border-radius: 0px 10px 10px 0px;
            background-color: red;
            font-family: inherit;
            color: white;
            transition: 1s;
            border: none;
            cursor: pointer;
        }

        .btn_baja:hover
        {
            width: 100px;
        }

        #tr_btn_usuario_1{
            text-align: right;
        }

        .icono_eliminar{
            height: 20px;
            filter: invert(1);
        }
    </style>
</head>
<body>
    <?php include("./nav_admin.php") ?>
    <h1>Reservas</h1>
    <article id="filtros_historial" class="item_historial">
                    <form id="container_filtro" method="post" enctype="multipart/form-data">
                        <select name="filtro_cancha" id="filtro_cancha">
                            <option value="" selected>Todas las Canchas</option>
                            <option value="1">F5 (A)</option>
                            <option value="2">F5 (B)</option>
                            <option value="3">F7 (A)</option>
                            <option value="4">F7 (B)</option>
                            <option value="5">F8 (A)</option>
                            <option value="6">F8 (B)</option>
                        </select>
                        <select name="filtro_dia" id="filtro_dia">
                            <option value="" selected>Cualquier Día</option>
                            <?php 
                                for($i = $dia_inicio ; $i < $dia_limite ; $i++)
                                {
                                    echo "<option value='" .  date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "'>" . date('d/m/y', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "</option>";
                                }
                            ?>
                        </select>
                        <input type="text" placeholder="Filtrar por email" id="filtro_email">
                    </form>
                    
                </article>
                <table id="tabla">
                    <thead>
                        <tr id="th_historial" class="item_historial">
                            <th class="nombre td_historial">Nombre</th>
                            <th class="apellido td_historial">Apellido</th>
                            <th class="email td_historial">Email</th>
                            <th class="dia td_historial">Día</th>
                            <th class="cancha td_historial">Cancha</th>
                            <th class="hora td_historial">Hora</th>
                            <th class="hora td_historial"></th>
                        </tr>
                    </thead>
                    <tbody id="body_tabla">
                    </tbody>
                </table>
            </article>
</body>
</html>
<script>    

    let filtro_cancha = document.getElementById("filtro_cancha");
    let filtro_dia = document.getElementById("filtro_dia");
    let filtro_email = document.getElementById("filtro_email");

    traer_datos();

    filtro_cancha.addEventListener('change', ()=> {
        traer_datos();
    });

    filtro_dia.addEventListener('change', ()=>{
        traer_datos();
    })

    filtro_email.addEventListener('keyup', ()=>{
        traer_datos();
    })



    function traer_datos(){
        
        $.ajax({
            url: './reservas_disponibles_admin.php',
            method: 'post',
            data: {
                filtro_cancha: $("#filtro_cancha").val(),
                filtro_dia: $("#filtro_dia").val(),
                filtro_email: $("#filtro_email").val()
            },
            success: function(res)
            {
                $("#body_tabla").empty();
                let datos = JSON.parse(res);
                generar_tabla(datos);
            }
        })
    }

    function generar_tabla(data)
    {
        data.forEach((elemento) =>{            
            let tr_filtro = document.createElement("tr");
            let td_nombre = document.createElement("td");
            let td_apellido = document.createElement("td");
            let td_email = document.createElement("td");
            let td_dia = document.createElement("td");
            let td_cancha = document.createElement("td");
            let td_hora = document.createElement("td");
            let td_boton = document.createElement("td");
            let boton = document.createElement("button");
            let tacho = document.createElement("img");

            //Creo el tr con los datos de la reserva del usuario
            tr_filtro.className = "item_historial";

            td_nombre.innerHTML = elemento["nombre"];
            td_nombre.className = "nombre td_historial";
            td_apellido.innerHTML = elemento["apellido"];
            td_apellido.className = "apellido td_historial";
            td_email.innerHTML = elemento["email"];
            td_email.className = "email td_historial";
            td_dia.innerHTML = elemento["dia"];
            td_dia.className = "dia td_historial";
            td_cancha.innerHTML = elemento["cancha"];
            td_cancha.className = "cancha td_historial";
            td_hora.innerHTML = elemento["hora"];
            td_hora.className = "hora td_historial";
            // td_boton.className = "boton td_historial";
            td_boton.className = "boton";
            tacho.setAttribute("src", "./imgs/eliminar.png");
            tacho.className = "icono_eliminar";

            boton.setAttribute("id", `${elemento["id"]}`);
            boton.className = "btn_baja";
            // boton.innerHTML = "Baja"

            boton.addEventListener('click', ()=>{
                baja_reserva(elemento["id"], elemento["email"]);
            })

            boton.appendChild(tacho);

            td_boton.appendChild(boton);

            tr_filtro.appendChild(td_nombre);
            tr_filtro.appendChild(td_apellido);
            tr_filtro.appendChild(td_email);
            tr_filtro.appendChild(td_cancha);
            tr_filtro.appendChild(td_dia);
            tr_filtro.appendChild(td_hora);
            tr_filtro.appendChild(td_boton);

            body_tabla.appendChild(tr_filtro);

        });
    }

    function baja_reserva(id, email_user){
        let confirmar = confirm(`¿Desea dar de baja a la reserva?`);
        if(confirmar){
            $.ajax({
                url: './baja_reserva.php',
                method: 'post',
                data: { id_reserva : id,
                        email: email_user 
                    },
                success: function(){
                    alert("La reserva fue dada de baja");
                    traer_datos();
                }
            });
        }
    }



</script>