<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte Creditos Con Factura</title>
</head>
<body>
    <div class="divImg">
        <img  class="membre" src="{{ $base64 }}" alt="">
        <h1 style="position: absolute; color: #1a5084; margin-top:30px;">Fumigaciones FUMI-KILLE'R</h1>
        <h1 style="position: absolute; color: #1a5084; margin-top:-10px; margin-left:38%; font-size:25px;">Período: 
            {{ strtoupper(strftime("%d", strtotime($f1)) . '-' .substr(strftime("%B", strtotime($f1)), 0, 3). '-' .strftime("%Y", strtotime($f1))) }} 
            a 
            {{ strtoupper(strftime("%d", strtotime($f2)) . '-' .substr(strftime("%B", strtotime($f2)), 0, 3). '-' .strftime("%Y", strtotime($f2))) }}
        </h1>
    </div>
    <h1 style="margin-top: -50px;">Creditos Con Factura</h1>
    <div id="main-container">

        <table id="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Negocio</th>
                    <th># Factura</th>
            
                    <th>F. de orden</th>
                    <th>F. de fumigacion</th>                   
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->name }} {{ $item->lastname1 }} {{ $item->lastname2 }}</td>
                        <td>{{ $item->tradename }}</td> 
                        <td>{{ $item->facturaOrden }}</td> 
                        
                        <td style="text-transform: capitalize;">{{ strtoupper(strftime("%d", strtotime($item->date1)) . '-' . substr(strftime("%B", strtotime($item->date1)), 0, 3)). '-' .strftime("%y", strtotime($item->date1)) }}</td>
                        <td style="text-transform: capitalize;">{{ strtoupper(strftime("%d", strtotime($item->date2)) . '-' . substr(strftime("%B", strtotime($item->date2)), 0, 3)). '-' .strftime("%y", strtotime($item->date2)) }}</td>
                        <td class="pagosLbl">{{ number_format($item->pago, 2) }}</td>
                    </tr>
                @endforeach
                <tr id="fondoTotal">
                        <td></td>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td id="txt">Total</td>
                        <td id="totalPagos"> {{ number_format($totalPago, 2) }}</td>
                    </tr>
            </tbody>
        </table>
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
    table{
        background-color:#cfcfcf;
        border-collapse: collapse;
        text-align: left;
        width: 100%;
    }
    th, td{
        border: 1px solid black;
        padding: 3px;
    }
    thead{
        background-color: #526fd9;
        border-bottom: 5px solid #071a5e;
        color:white;
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
    }
    #totalPagos{
        text-align: right;
        margin-top: 20px;
    }
    #txt{
        text-align: left;
    }
    .membre{
        height:20%;
        margin-left: 20px;
    }
    .pagosLbl{
        text-align: right;
    }
    .divImg{
        display: flex;
        background-color:transparent;
    }
</style>

