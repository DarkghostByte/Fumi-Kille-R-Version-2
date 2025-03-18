<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte Egresos Caja</title>
</head>
<body>

    <div id="main-container">
    <h2 style="position: absolute; margin-top: -70px; margin-left:250px;">Reporte de Egresos Caja</h2>
        <h2 style="font-size: 18px; position:absolute; margin-top:-30px; margin-left:150px;">De fecha {{ $f1 }} a fecha {{ $f2 }}</h2>
        <table id="table" style="margin-top:20px;">


            <thead id="thead2">
            <tr id="cabezera">
                <th style="width: 70px; text-align:left; font-size:bold;"   id="td1" colspan="4">EGRESOS</th> 
                </tr>
                <tr>
                    <th style="width: 55px;">Fecha</th>
                    <th>Concepto</th>
                    <th>Departamento</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody >
                <!-- @ foreach($data as $item)*/ -->
                @foreach($dataEg as $itemEg)
                    <tr>
                        <td>{{ $itemEg->dateEgresos }}</td>
                        <td style="text-align: left;">{{ $itemEg->descriptionEgresos }}</td>
                        <td>{{ $itemEg->comercio }}</td>
                        <td class="pagosLbl">{{ number_format($itemEg->montoEgresos, 2) }}</td>
                    </tr>
                @endforeach
            <!-- @ endforeach -->
                <tr id="fondoTotal2"> 
                        <td ></td>
                        <td style="width: 250px;" >Total</td>
                        <td style="width: 80px;"></td>
                        <td style="width: 80px;" id="totalPagos"> {{ number_format($totalEgresos, 2) }}</td>
                    </tr>
            </tbody>
        </table>
        
<br>
    </div>
    
</body>
</html>



<style>
    body {
            margin-top: -40px;
            font-family: Arial;
            margin-left: -35px;
            background-image: url("{{ $base64 }}");
            background-repeat: no-repeat;
            background-size: contain; /* Ajuste para mantener la imagen proporcional */
            background-position: top -500px center; /* Ajuste para mover la imagen más arriba */
            background-attachment: fixed; /* Fija la imagen mientras se hace scroll */
            padding-top: 220px; /* Mantengo un poco de espacio para evitar que el contenido se superponga a la imagen */
        }
    #main-container{
        
        margin:10px auto;
        width: 100%;
    }
    #table{
        background-color:#cfcfcf;
        border-collapse: collapse;
        text-align: left;
        width: 105%;
    }
    #table2{
        background-color:#cfcfcf;
        border-collapse: collapse;
        text-align: left;
        width: 105%;

    }
    #table3{
        background-color:#51ed78;
        border-collapse: collapse;
        text-align: left;
        width: 105%;

    }
    
    th, td{
        border: 1px solid black;
        padding: 3px;
    }
    thead{
        background-color: #526fd9;
        border-bottom: 5px solid #071a5e;
        color:black;
    }
    #thead2{
        background-color: #d9bc52;
        border-bottom: 5px solid #071a5e;
        color:black;
    }
    tbody{
        text-align: center;
        color:black;
    }
    
    tr:nth-child(even){
        background-color: rgb(255, 255, 255);
    }
    tr:hover td{
        background-color: #526fd9;
        color: white;
    }
    h3{
        text-align:right;
        /*background-color: #071a5e;*/
    }h1{
        text-align:center;
        /*background-color: #071a5e;*/
    }

    #fondoTotal{
        background-color: #526fd9;
        text-align: end;
    }
    #fondoTotal2{
        background-color: #d9bc52;
        text-align: end;
    }
    #fondoTotalNeto{
        background-color: #59d952;
        text-align: end;
    }
    #totalPagos{
        text-align: right;
        margin-top: 20px;
        width: 160px;
    }
    #txt{
        text-align: left;
        width: 160px;
    }
    .membre{
        margin-left: 12.5%;
        margin-top:-20px;
        height:17%;
        width: auto;
    }
    .pagosLbl{
        text-align: right;
    }
    .cabezera{
        background-color: transparent;
    }
    #thvacio{
        width: 115px;
    }
    #td1{
        width: 160px;
    }
    #td2{
        width: 100px;
    }
</style>

