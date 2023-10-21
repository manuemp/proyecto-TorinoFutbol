<?php session_start(); ?>
<?php 
    if(!isset($_SESSION["Nombre"]))
    {
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="./jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <title>TorinoFútbol: Tu Historial de Reservas</title>
    <style>
        main
        {
            height: 100vh;
        }

        .historial
        {
            border-top: 20px solid white;
            position: relative;
            top: 40px;
            height: 85%;
            width: 80%;
            background-color: white;
            margin-bottom: 20px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 4px 4px 5px 0px lightgray;
            padding: 0px 40px 40px 40px;
            box-sizing: border-box;
            overflow: scroll;
        }

        .item_historial, .item_historial_falta
        {
            width: 100%;
            height: 60px;
            display: flex;
            justify-content: center;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: 1s;
        }

        .item_historial{
            background-color: whitesmoke;
            color: #8650fe;
        }

        .item_historial_falta{
            background-color: crimson;
            color: white;
        }

        .item_historial_falta:hover{
            background-color: red;
        }

        .item_historial:hover
        {
            background-color: #702eff;
            color: white;
        }

        table
        {
            width: 100%;
            height: 100%;
        }

        thead, th
        {
            position: sticky;
            top: 0;
        }

        .td_historial
        {
            width: 30%;
            margin-left: 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        #th_historial
        {
            background-color: #333;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        #filtros_historial
        {
            color: white;
            height: 70px;
            /* border-radius: 0px 0px 20px 20px; */
            /* background: linear-gradient(45deg, #4300d3,#702eff); */
            background: linear-gradient(45deg, #481f9e, #8650fe 80%);
        }

        #container_filtro
        {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        select, button
        {
            width: 180px;
            height: 35px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: inherit;
            text-align: center;
            font-weight: bold;
            font-size: 1.3rem;
        }

        #arrow{
            position: absolute;
            height: 50px;
            filter: opacity(0.5);
        }

        @media(max-width: 960px){
            .td_historial{
                font-size: 1.3rem;
            }
        }

        @media(max-width: 650px){
            .item_historial{
                margin-bottom: 10px;
            }

            .historial{
                padding: 0px 25px 25px 25px;
                height: 100%;
            }

            #arrow{
                height: 35px;
            }
        }

        @media (max-width: 480px){

            .historial{
                width: 100%;
            }

            .td_historial{
                font-size: 1rem;
            }

            select{
                width: 100%;
                height: 30px;
                font-size: 1rem;
            }

            .item_historial{
                margin-bottom: 5px;
            }

            #filtros_historial{
                height: 52px;
            }
        }

    </style>
</head>
<body>
    
        <?php include("./nav_online.php") ?>

        <main>
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
            <article class="historial">
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
                        <!-- <button>Buscar</button> -->
                    </form>
                </article>
                <table id="tabla">
                    <thead>
                        <tr id="th_historial" class="item_historial">
                            <th class="td_historial">Día</th>
                            <th class="td_historial">Cancha</th>
                            <th class="td_historial">Hora</th>
                        </tr>
                    </thead>
                    <tbody id="body_tabla">
                    </tbody>
                </table>
            </article>
    </main>
</body>
</html>

<?php include("./nav_desplegable.php") ?>

<script>

    let filtro = document.getElementById("filtro_cancha");
    let body_tabla = document.getElementById("body_tabla");

    filtrar_reservas();

    filtro.addEventListener('change', ()=>{
        filtrar_reservas();
    });

    function filtrar_reservas()
    {
        let formulario = new FormData(document.getElementById("container_filtro"));
        $("#body_tabla").empty();

        $.ajax({
            url: './filtrar_reservas.php',
            type: 'post',
            method: 'post',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data: formulario,
            success: function (datos)
            {
                let respuesta = JSON.parse(datos);
                generar_tabla(respuesta);
                if(body_tabla.childNodes.length == 0)
                {
                    let tr_filtro = document.createElement("tr");
                    let td_vacio = document.createElement("td");

                    tr_filtro.className = "item_historial";
                    td_vacio.innerHTML = "No hay reservas...";
                    td_vacio.className = "td_historial";
                    tr_filtro.appendChild(td_vacio);
                    body_tabla.appendChild(tr_filtro);
                }
            }
        });
    }

    function generar_tabla(data)
    {
        data.forEach((elemento) =>{   
                
                let tr_filtro = document.createElement("tr");
                let td_dia = document.createElement("td");
                let td_cancha = document.createElement("td");
                let td_hora = document.createElement("td");

                if(parseInt(elemento["Asistio"]) == 0){
                    tr_filtro.className = "item_historial_falta";
                }
                else
                {
                    tr_filtro.className = "item_historial";
                }
    
                td_dia.innerHTML = elemento["Dia"];
                td_dia.className = "td_historial";
                td_cancha.innerHTML = elemento["Cancha"];
                td_cancha.className = "td_historial";
                td_hora.innerHTML = elemento["Hora"];
                td_hora.className = "td_historial";
    
                tr_filtro.appendChild(td_dia);
                tr_filtro.appendChild(td_cancha);
                tr_filtro.appendChild(td_hora);
    

                body_tabla.appendChild(tr_filtro);
            });
    }

</script>
