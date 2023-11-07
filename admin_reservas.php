<?php session_start(); ?>
<?php

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
    <link rel="stylesheet" href="estilos/modal.css">
    <script src="./jquery.js"></script>
    <title>TorinoFútbol: Admin - Reservas</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');
        body, html{
            height: 100%;
            margin: 0;
            padding: 5px;
            font-family: 'Inter', 'Helvetica Neue', sans-serif;
        }

        .nav_admin{
            height: 55px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #8650fe;
        }

        main{
            display: flex;
            justify-content: center;
            align-content: center;
            flex-wrap: wrap;
            height: 60vh;
        }

        .logo{
            width: 120px;
            margin-left: 10px;
            cursor: pointer;
        }

        .opcion{
            cursor: pointer;
            color: #8650fe;
            font-size: 20px;
            font-weight: bold;
            padding: 14px;
            margin-right: 15px;
            border-radius: 10px;
        }

        a{
            text-decoration: none;
        }

        #admin_links{
            display: flex;
            align-items: center;
            justify-content: center;
            width: 500px;
        }

        .admin_btn{
            background-color: white;
            width: 130px;
            border-radius: 0;
            border: 2px solid #8650fe;
            cursor: pointer;
            text-align: center;
            transition: 1s;
        }

        .admin_btn:hover{
            background-color: #d0bbff;
        }

        h1{
            color:#8650fe;
            font-size: 2.3rem;
        }

        .item_historial{
            width: 100%;
            height: 60px;
            background-color: lavender;
            color: #8650fe;
            display: flex;
            justify-content: start;
            cursor: pointer;
            padding-left: 10px;
            box-sizing: border-box;
            margin-bottom: 5px;

        }

        .item_historial:hover{
            background-color: #cacaff;
        }

        table{
            width: 100%;
        }

        thead, th{
            top: 0;
        }

        .td_historial{
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content:left;
            font-size: 1rem;
        }

        #th_historial{
            background-color: #333;
            color: white;
            border-radius: 10px 10px 0 0;
            cursor: default;
            border: none;
        }

        #filtros_historial{
            margin-top: 8px;
            color: white;
            height: 60px;
            background: linear-gradient(45deg, #481f9e, #8650fe 80%);
            cursor:default;
        }

        #container_filtro{
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        select, input{
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

        .cancha, .dia, .hora{
            width: 15%;
            justify-content: center;
        }

        .boton{
            width: 15%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }

        .btn_falta{
            height: 70%;
            width: 70px;
            background-color: red;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            font-family: inherit;
            cursor: pointer;
        }

        .item_responsive{
            width: 100%;
            background-color:lavender;
            position:relative;
            top: -10px;
            display: none;
            border-bottom: 2px solid lightgray;
        }

        .item_responsive td{
            height: 48px;
            display: flex;
            width: 155px;
            justify-content: space-around;
            align-items: center;
        }

        #tr_btn_usuario_1{
            text-align: right;
        }

        .icono_eliminar{
            height: 20px;
            filter: invert(1);
        }


        /* Modal Admin */

        #modal_admin{
            display: none;
            z-index: 3;
            width: 500px;
            height: 460px;
            background-color: white;
            border-radius: 20px;
            border: 2px solid black;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -250px;
            margin-top: -230px;
            padding: 40px;
            box-sizing: border-box;
        }

        .campo_admin{
            width: 100%;
            height: 40px;
            padding: 10px;
            box-sizing: border-box;
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: bold;
            color:#481f9e;
        }

        .botones_admin{
            position: absolute;
            bottom: 35px;
            right: 10px;
            width: 100%;
            text-align: right;
        }

        #modal_adm_salir, #modal_adm_guardar{
            color: white;
            border: none;
            padding: 10px;
            width: 70px;
            border-radius: 10px;
            font-weight: bold;
            font-family: inherit;
            margin-right: 10px;
            cursor: pointer;
        }

        #modal_adm_salir{
            background-color: crimson;
        }

        #modal_adm_guardar{
            background-color:#7643e5;
        }

        #modal_adm_salir:hover{
            background-color: red;
        }

        #modal_adm_guardar:hover{
            background-color:#8650fe;
        }

        #input_senia{
            font-size: 1.3rem;
            border-bottom: 2px solid lightgray;
            border-radius: 0;
            width: 115px;
            color: inherit;
            text-align: left;
            height: 25px;
            padding-left: 8px;
        }

        .hoy{
            background-color: moccasin;
            color: navy;
        }

        .hoy:hover{
            background-color: #ff9b4f
        }

        .hoy_pasado{
            background-color: darkgray;
            color: white;
        }

        .hoy_pasado:hover{
            background-color: #727272
        }

        .mensaje{
            font-weight: bold;
            text-align: center;
            color: white;
            position: relative;
            top: -7px;
            display: block;
            margin-bottom: -4px;
            font-size: 0.6rem;
        }

        @media(max-width: 1070px){
            .btn_falta{
                width: 50px;
                height: 50%;
            }
        }

        @media(max-width: 950px){
            .td_historial{
                font-size: 0.8rem;
            }

            h1{
                text-align: center;
            }

            .hora{
                width: 14%;
            }

            .boton{
                width: 16%;
            }

            #container_filtro{
                justify-content: center;
            }
        }

        @media(max-width: 750px){
            .opcion{
                font-size: 15px;
            }

            .boton{
                display: none;
            }

            .item_responsive{
                display: block;
            }

            .email{
                width: 40%;
            }
            
            .nombre, .apellido{
                display: none;
            }

            .cancha, .dia, .hora{
                width: 20%;
            }

            .item_responsive td{
                width: 125px;
            }

            #filtros_historial{
                height: 40px;
                border-radius: 0px;
            }

            select, input{
                width: 120px;
                font-size: 0.65rem;
                border: 2px solid #7643e5;
                border-radius: 0px;
                box-sizing: border-box;
            }

            .icono_eliminar{
                height: 15px;
            }

            #input_senia{
                border-left: none;
                border-top: none;
                border-right:none;
            }

            .mensaje{
                top: -14px;
            }

        }

        @media(max-width: 500px){
            .cancha{
                display: none;
            }

            .email{
                width: 55%;
            }

            select, input{
                width: 115px;
            }

            .item_historial{
                height: 40px;
            }

            .td_historial{
                font-size: 0.55rem;
            }

            #filtro_dia{
                display: none;
            }

            .btn_falta{
                font-size: 0.6rem;
            }

            .icono_eliminar{
                height: 12px;
            }

            .item_responsive td{
                height: 40px;
            }

            h1{
                font-size: 1.6rem;
            }

            #modal_admin{
                width: 100%;
                margin-left: 0px;
                left: 0;
                padding: 20px 10px;
            }

            .campo_admin, #input_senia{
                font-size: 1rem;
            }

            #input_senia{
                width: 65px;
            }
        }
    </style>
</head>
<div id="modal_background"></div>
<body>
    <?php include("./nav_admin.php") ?>
    <h1>Administrar Reservas</h1>

    <section id="modal_admin">
        <input type="hidden" id="modal_hidden">
        <div class="campo_admin" id="modal_numero_reserva" style="border-bottom: 2px solid red;">Reserva n° 117</div>
        <div class="campo_admin" id="modal_nombre"></div>
        <div class="campo_admin" id="modal_dia"></div>
        <div class="campo_admin" id="modal_cancha"></div>
        <div class="campo_admin" id="modal_mail"></div>
        <div class="campo_admin" id="modal_senia">Seña: $<input type="text" id="input_senia"><span style="color:lightgray" id="debe">Debe: </span></div>
        <div class="campo_admin" id="modal_precio">Total: <span style="color: crimson">$22.000,00</span></div>
        <div class="botones_admin"><button id="modal_adm_salir">Salir</button><button id="modal_adm_guardar">Guardar</button></div>
    </section>

    <!-- <article id="filtros_historial" class="item_historial">
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
    </article> -->

    <table id="tabla">
        <thead>
            <tr>
                <th id="filtros_historial" class="item_historial" style="margin-top: -3px; margin-bottom: 2px;">
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
                </th>
            </tr>
            <tr id="th_historial" class="item_historial">
                <th class="nombre td_historial">Nombre</th>
                <th class="apellido td_historial">Apellido</th>
                <th class="email td_historial">Email</th>
                <th class="cancha td_historial">Cancha</th>
                <th class="dia td_historial">Día</th>
                <th class="hora td_historial">Hora</th>
                <th class="boton td_historial"></th>
            </tr>
        </thead>

        <tbody id="body_tabla">
            <tr class="item_historial">
                <td class='nombre td_historial'>Manuel</td>
                <td class='apellido td_historial'>Pedro</td>
                <td class='email td_historial'>mp@gmail.com</td>
                <td class='cancha td_historial'>Futbol 5 (A)</td>
                <td class='dia td_historial'>11/9/2023</td>
                <td class='hora td_historial'>10:00:00</td>
            </tr>
            <tr>
                <td class="mensaje">Adeuda</td>
            </tr>

            <tr class="item_historial">
                <td class='nombre td_historial'>Manuel</td>
                <td class='apellido td_historial'>Pedro</td>
                <td class='email td_historial'>mp@gmail.com</td>
                <td class='cancha td_historial'>Futbol 5 (A)</td>
                <td class='dia td_historial'>11/9/2023</td>
                <td class='hora td_historial'>10:00:00</td>
            </tr>
            <tr>
                <td class="mensaje" style="background: seagreen">Pagó</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
<script>    

    let filtro_cancha = document.getElementById("filtro_cancha");
    let filtro_dia = document.getElementById("filtro_dia");
    let filtro_email = document.getElementById("filtro_email");
    var modal_admin = document.getElementById("modal_admin");
    var modal_background = document.getElementById("modal_background");
    var flag_btn = false;
    
    //Formatter para el total en el modal (signo, coma y punto para el monto)
    const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            });
    
    //Traer datos automáticamente antes de cargar la página
    traer_datos();

    document.getElementById("modal_adm_salir").addEventListener('click', ()=>{
        modal_admin.style.display = "none";
        modal_background.style.display = "none";
    })

    document.getElementById("modal_adm_guardar").addEventListener('click', ()=>{
        modal_admin.style.display = "none";
        console.log(document.getElementById("modal_hidden").value);
        $.ajax({
            url: './actualizar_senia.php',
            method: 'post',
            data: {
                id: $("#modal_hidden").val(),
                senia: $("#input_senia").val()
            },
            success: function(res)
            {
                traer_datos();
            }
        })
        modal_background.style.display = "none";
    })


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
        let fila;
        let cont = 0;
        data.forEach((registro) =>{  
            let tr_filtro = document.createElement("tr");
            let tr_filtro_responsive = document.createElement("tr");
            let td_boton = document.createElement("td");
            let td_boton_responsive = document.createElement("td");
            let boton = document.createElement("button");
            let boton_falta = document.createElement("button");
            let boton_responsive = document.createElement("button");
            let boton_falta_responsive = document.createElement("button");
            

            tr_filtro.className = "item_historial";
            tr_filtro_responsive.className = "item_responsive";
            td_boton.className = "boton";
            boton.className = "btn_falta";
            boton.innerHTML = "<img src='./imgs/eliminar.png' class='icono_eliminar'>";
            boton_falta.className = "btn_falta";
            boton_falta.innerHTML = "FALTA";
            boton_responsive.className = "btn_falta";
            boton_responsive.innerHTML = "<img src='./imgs/eliminar.png' class='icono_eliminar'>";
            boton_falta_responsive.innerHTML = "FALTA";
            boton_falta_responsive.className = "btn_falta";

            tr_filtro.innerHTML = `
                <td class='nombre td_historial'>${registro["nombre"]}</td>
                <td class='apellido td_historial'>${registro["apellido"]}</td>
                <td class='email td_historial'>${registro["email"]}</td>
                <td class='cancha td_historial'>${registro["cancha"]}</td>
                <td class='dia td_historial'>${registro["dia"]}</td>
                <td class='hora td_historial'>${registro["hora"]}</td>`;

            td_boton.appendChild(boton_falta);
            td_boton.appendChild(boton);

            tr_filtro.appendChild(td_boton);

            td_boton_responsive.appendChild(boton_responsive);
            td_boton_responsive.appendChild(boton_falta_responsive);

            tr_filtro_responsive.appendChild(td_boton_responsive);

            boton.addEventListener('click', ()=>{
                baja_reserva(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
                flag_btn = true;
            })

            boton_falta.addEventListener('click', ()=>{
                aplicar_falta(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
                flag_btn = true;
            })

            boton_responsive.addEventListener('click', ()=>{
                baja_reserva(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
            })

            boton_falta_responsive.addEventListener('click', ()=>{
                aplicar_falta(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
            })

            //Lleno el modal cuando se haga click en el registro creado
            tr_filtro.addEventListener('click', ()=>{
                if(!flag_btn)
                {
                    modal_admin.style.display = "block";
                    modal_background.style.display = "block";
                    document.getElementById("modal_hidden").value = registro["id"];
                    document.getElementById("modal_numero_reserva").innerHTML = `Reserva n° ${registro["id"]}`;
                    document.getElementById("modal_nombre").innerHTML = `${registro["nombre"]} ${registro["apellido"]}`;
                    document.getElementById("modal_dia").innerHTML = registro["dia"];
                    document.getElementById("modal_cancha").innerHTML = `${registro["cancha"]} -  ${registro["hora"]}hs`;
                    document.getElementById("modal_mail").innerHTML = registro["email"];
                    document.getElementById("debe").innerHTML = `Debe: ${formatter.format(parseInt(registro["precio"]) - parseInt(registro["adelanto"]))}`
                    document.getElementById("modal_precio").innerHTML = `Total: <span style="color:crimson">${formatter.format(registro["precio"])}</span>`;
                    document.getElementById("input_senia").value = registro["adelanto"];
                }
                flag_btn = false;
            });
            
            //Por ultimo, veo si la reserva es de hoy y todavía no se jugó,
            //si es de hoy y ya pasó el horario, o si no es de hoy.
            
            //Agrego ceros a las horas, minutos y segundos del objeto Date para que sea compatible
            //con lo obtenido en la base de datos.
            function addZero(i) {
                if (i < 10) {i = "0" + i}
                return i;
            }

            const d = new Date();
            let hora = `${addZero(d.getHours())}:${addZero(d.getMinutes())}:${addZero(d.getSeconds())}`;
            let hoy = `${addZero(d.getDate())}/${addZero(d.getMonth() + 1)}/${addZero(d.getFullYear())}`

            if(hoy == registro["dia"])
            {
                if(Date.parse(`1/1/2023 ${hora}`) < Date.parse(`1/1/2023 ${registro["hora"]}`))
                {
                    tr_filtro.className = "item_historial hoy";
                    tr_filtro_responsive.className = "item_responsive hoy";
                }
                else
                {
                    tr_filtro.className = "item_historial hoy_pasado";
                    tr_filtro_responsive.className = "item_responsive hoy_pasado";
                }
            }

            if(registro["adelanto"] == registro["precio"]){
                tr_filtro.style.borderLeft = "12px solid #3aea00";
            }
            else if(registro["adelanto"] != "0"){
                tr_filtro.style.borderLeft = "12px solid orange";
            }
            else{
                // tr_mensaje.innerHTML = "<td class='mensaje' style='background-color: red;'>Adeuda</td>";
                tr_filtro.style.borderLeft = "12px solid red";
            }

            body_tabla.appendChild(tr_filtro);
            body_tabla.appendChild(tr_filtro_responsive);
            
            //ver si las reservas que no se hicieron hoy (o sea, que se hicieron hace más de un día)
            //siguen sin seña. En ese caso le aviso al administrador para que notifique al usuario
            //y vea si dar de baja la reserva o no.
            if(registro["dia_pedido"] != hoy && registro["adelanto"] == "0")
            {
                let tr_mensaje = document.createElement("tr");
                tr_mensaje.innerHTML = "<td class='mensaje' style='background-color: red;'>Adeuda</td>";
                body_tabla.appendChild(tr_mensaje);
            }
        });
    }

    function baja_reserva(id, email_user, nombre, apellido, hora, cancha, dia){
        let confirmar = confirm(`¿Desea dar de baja la reserva?\n
                    Nombre: ${nombre} ${apellido}\n
                    Email: ${email_user}\n
                    Dia: ${dia}, ${hora}hs\n
                    Cancha: ${cancha}`);
        if(confirmar){
            $.ajax({
                url: './baja_reserva.php',
                method: 'post',
                data: { 
                        id_reserva : id,
                        email: email_user 
                    },
                success: function(){
                    alert("La reserva fue dada de baja");
                    traer_datos();
                }
            });
        }
    }

    function aplicar_falta(id, email_user, nombre, apellido, hora, cancha, dia){
        let confirmar = confirm(`¿Desea aplicar una falta al usuario?\n
                    Nombre: ${nombre} ${apellido}\n
                    Email: ${email_user}\n
                    Dia: ${dia}, ${hora}hs\n
                    Cancha: ${cancha}`);
        if(confirmar){
            $.ajax({
                url: './aplicar_falta.php',
                method: 'post',
                data: { 
                        id_reserva : id,
                        email: email_user 
                    },
                success: function(){
                    alert(`Se aplicó la falta a ${nombre} ${apellido}`);
                    traer_datos();
                }
            });
        }
    }

</script>