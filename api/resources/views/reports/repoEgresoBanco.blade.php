<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte Egresos Banco</title>
</head>
<body>
    <img  class="membre" src="{{ $base64 }}" alt="">
    <div id="main-container">
    <h2 style="position: absolute; margin-top: -50px; margin-left:275px;">Reporte de Egresos Banco</h2>
        <h2 style="font-size: 18px; position:absolute; margin-top:-15px; margin-left:240px;">De fecha {{ $f1 }} a fecha {{ $f2 }}</h2>
        <table id="table" style="margin-top:20px;">

            <thead id="thead2">
                <tr id="cabezera">
                    <th id="td1">Egresos</th>
                    <td id="td1"></td> 
                    <td id="td1"></td>
                    <td id="td1"></td>
                    
                </tr>
                <tr>
                    <th>Fecha</th>
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
                        <td>{{ $itemEg->descriptionEgresos }}</td>
                        <td>{{ $itemEg->comercio }}</td>
                        <td class="pagosLbl">{{ number_format($itemEg->montoEgresos, 2) }}</td>
                    </tr>
                @endforeach
            <!-- @ endforeach -->
                <tr id="fondoTotal2"> 
                        <td></td>
                        <td id="txt">Total</td>
                        <td></td>
                        <td id="totalPagos"> {{ number_format($totalEgresos, 2) }}</td>
                    </tr>
            </tbody>
        </table>
        
<br>
    </div>
    
</body>
</html>



<style>
    body{
        font-family: Arial;
        margin-left: -35px;
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

