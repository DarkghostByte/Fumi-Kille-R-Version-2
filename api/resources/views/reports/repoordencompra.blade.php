<!DOCTYPE html>
<html lang="en">


    <div class="delimitador">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF Ordenes</title>
    </head>
<body >
<table class="tblDia" >
    <h5 class="txtDia" style="width: 55px;">FOLIO</h5>
    <h5 class="txtDia1" style="width: 80px;" >{{ str_pad($data->id, 5, 0, STR_PAD_LEFT) }}   </h5>
</table>
<img class="membre" src="{{ $base64 }}" alt="">
    
    <div class="meminfo">
        
        <div style="margin-top:-5px; width:250px;">
            <h2 class="letrasFlex;" >Orden de Compra</h2>
        </div>
    </div>
    <header>    
        
    </header>
    @php 
    $arreglo = json_decode($data->autorizoOrdenCompra);
    $autorizo = false;

    if (is_array($arreglo) || is_object($arreglo)) {
        foreach($arreglo as $item) {
            if($item == '.') { 
                $autorizo = true; 
            }
        }
    }
    
@endphp
    

    <main style="margin-top: -60px; text-transform: capitalize;"> 
        <img src="{{ $base641 }}" alt="" style="z-index: -1; position: absolute; opacity:0.3; width:auto; height:300px; margin-left:36.5%; margin-top:-7%;">
        <div class="fondLimitador"></div>
        <table style="margin-top: -30px;">
            <th class="clthrs" style="width: 40px; ">FECHA:</th>
            <th class="renDivThDT">
            <div class="renDiv1DT" >
                {{ $fecha->dayName }}, {{ $fecha->day }}  de {{ $fecha->monthName }} de {{ $fecha->year }}
            </div>
            </th>  
        </table>
        <table>
            <th></th>
        </table>
            
        <table>
            <th class="clth">PARA: </th>
            <th class="renDivTh">
            <div class="renDiv1" style="text-align:left;">
                {{ $data->paraOrdenCompra }}
            </div>
            </th>  
        </table>
        <table>
            <th></th>
        </table>
        <table>
        <th class="clth">CONCEPTO: </th>
            <th class="renDivTh">
            <div class="renDiv" style="text-align: left;">
                {{ $data->conceptoOrdenCompra }}            
            </div>
            </th> 
            <th></th>
        </table>
       
        <table>
            <th></th>
        </table>
        <table>
            <th class="clth">DETALLE: </th>
            <th class="renDivTh">
            <div class="renDiv1" style="text-align: left;">
                 {{ $data->detalleOrdenCompra }}
            </div>
            </th>  
        </table>
        <table>
            <th></th>
        </table>
        <table>
            <th>EMPLEADO:</th>
            <th class="renDivTh">
            <div class="renDiv13">
                {{ $data->empleadoOrdenCompra }}
            </div>
            </th>
            <th style="border: 1px solid black; width:80px;">IMPORTE</th>
            <th style="border: 1px solid black; width:70px;">{{ $data->importeOrdenCompra }}</th>   
        </table>
        </div>

        
        <table style="text-align:center; width:30%; margin-left:24%; margin-top:30px;">
            <th>Autorizo: </th>
            <th style="width: 200px; border-bottom:1px solid black;"></th>
        
            
        </table>
        <table style="text-align:center; width:34%; margin-left:31%; margin-top:0px;">
        <div class="" style="color: black; width: 200px;">
                    <h1 style="width: 200px;font-size:15px;">{{ $data->autorizoOrdenCompra }}</h1>
                </div>
                
            
            <th style="width: 200px;"></th>
        </table>
        <h5 class="oc" style="position: absolute; margin-left:88.5%; margin-top:-15px; font-size:15px; border: 1px solid black; height:20px; width:80px; text-align:center;">ORIGINAL</h5>
        
        
    

        <div class="footDiv"></div>
        <div class="footDiv1"></div>
        <table class="footer">
            <th class="footer">Calle del Abeto No.2201</th>
            <th> Col. Alamedas </th>
            <th> C.P. 31704</th>
            <th> Nuevo Casas Grandes, Chih. </th>
            <th> Tel.636-694-65-15</th>
            
            
        </table>
        


        
    </main>
    </div>
    
</body>
<body >
<table class="tblDia5" >
    <h5 class="txtDia" style="width: 55px;">FOLIO</h5>
    <h5 class="txtDia1" style="width: 80px;" >{{ str_pad($data->id, 5, 0, STR_PAD_LEFT) }}   </h5>
</table>
<img class="membre5" src="{{ $base64 }}" alt="">
    
    <div class="meminfo5">
        
        <div style="margin-top:5px; width:250px;">
            <h2 class="letrasFlex;" >Orden de Compra</h2>
        </div>
    </div>
    <header>    
        
    </header>

    <main style="margin-top: -60px; text-transform: capitalize;"> 
        <img src="{{ $base641 }}" alt="" style="z-index: -1; position: absolute; opacity:0.3; width:auto; height:300px; margin-left:36.5%; margin-top:-7%;">
        <div class="fondLimitador"></div>
        <table style="margin-top: -30px;">
            <th class="clthrs" style="width: 40px; ">FECHA:</th>
            <th class="renDivThDT">
            <div class="renDiv1DT" >
                {{ $fecha->dayName }}, {{ $fecha->day }}  de {{ $fecha->monthName }} de {{ $fecha->year }}
            </div>
            </th>  
        </table>
        <table>
            <th></th>
        </table>
            
        <table>
            <th class="clth">PARA: </th>
            <th class="renDivTh">
            <div class="renDiv1" style="text-align:left;">
                {{ $data->paraOrdenCompra }}
            </div>
            </th>  
        </table>
        <table>
            <th></th>
        </table>
        <table>
        <th class="clth">CONCEPTO: </th>
            <th class="renDivTh">
            <div class="renDiv" style="text-align: left;">
                {{ $data->conceptoOrdenCompra }}            
            </div>
            </th> 
            <th></th>
        </table>
        
        <table>
            <th></th>
        </table>
        <table>
            <th class="clth">DETALLE: </th>
            <th class="renDivTh">
            <div class="renDiv1" style="text-align: left;">
                 {{ $data->detalleOrdenCompra }}
            </div>
            </th>  
        </table>
        <table>
            <th></th>
        </table>
        <table>
            <th>EMPLEADO:</th>
            <th class="renDivTh">
            <div class="renDiv13">
                {{ $data->empleadoOrdenCompra }}
            </div>
            </th>
            <th style="border: 1px solid black; width:80px;">IMPORTE</th>
            <th style="border: 1px solid black; width:70px;">{{ $data->importeOrdenCompra }}</th>   
        </table>
        </div>

        
        <table style="text-align:center; width:30%; margin-left:24%; margin-top:30px;">
            <th>Autorizo: </th>
            <th style="width: 200px; border-bottom:1px solid black;"></th>
        
            
        </table>
        <table style="text-align:center; width:34%; margin-left:31%; margin-top:0px;">
        <div class="" style="color: black; width: 200px;">
                    <h1 style="width: 200px;font-size:15px;">{{ $data->autorizoOrdenCompra }}</h1>
                </div>
                
            
            <th style="width: 200px;"></th>
        </table>
        <h5 class="oc" style="position: absolute; margin-left:88.5%; margin-top:-15px; font-size:15px; border: 1px solid black; height:20px; width:80px; text-align:center;">COPIA</h5>
        
        
    

        <div class="footDiv"></div>
        <div class="footDiv1"></div>
        <table class="footer">
            <th class="footer">Calle del Abeto No.2201</th>
            <th> Col. Alamedas </th>
            <th> C.P. 31704</th>
            <th> Nuevo Casas Grandes, Chih. </th>
            <th> Tel.636-694-65-15</th>
            
            
        </table>
        


        
    </main>
    </div>
    
</body>


<style>
    .txtDia{
        justify-content: center;
        text-align: center;
        justify-content: center;
        width: 50px;
        margin-top:-20px;
        margin-left:75%;
        border: 1px solid black;
    }
    .txtDia1{
        justify-content: center;
        text-align: center;
        justify-content: center;
        width: 100px;
        position:absolute;
        margin-top:-50px;
        margin-left:82.1%;
        border: 1px solid black;
    }
    .txtBDDia{
        left:80%;
    }.tblDia{
        position:absolute;
        margin-left: 65px;
    }
    .tblDia5{
        position:absolute;
        margin-left: 65px;
        margin-top: 40px;
    }
    .separacion{
        margin-top: 65px;
        border-top:2px solid black;
        padding-bottom:40px;
    }
    .ctr{
        justify-content: center;
    }
    .tipo{
        justify-content: center;
        text-align: center;
        justify-content: center;
        margin-left:75%;
        margin-top: 5px;
        height:27px;
        width: 150px;
        border:1px solid black;
    }
    .clth118{
        width:69%;
    }
    .clthrs{
        width:19.9%;
    }
    .clth{
        padding-right: 5px;
    }
    .btnrd{
        position:absolute;
        margin-left: 10%;
    }
    .clth22{
        width:85%;
    }
    .clth114{
        width: 30%;
        
    }
    .clth113{
        width:5%;
    }
    .clth1{
        width: 21%;
    }
    .letrasflex{
        margin-bottom: 40px;
        left: 20px;
        width: 500px;
    }
    .meminfo{
        text-align: center;
        position: absolute;
        margin-left: -42%;
        margin-top:11%;
        padding-bottom:-50px; 
        
    }
    .meminfo5{
        text-align: center;
        position: absolute;
        margin-left: -42%;
        margin-top:15%;
        padding-bottom:-50px; 
        
    }
    .membre{
        margin-top:0px;
        padding-left: 1px;
        height:19%;
        width: auto;
    }  
    .membre2{
        margin-top:0px;
        padding-left: 140px;
        height:13.8%;
        width: auto;
    } 
    .membre5{
        margin-top:60px;
        padding-left: 1px;
        height:19%;
        width: auto;
    }   
    .nmM{
        padding-left:50px;
    }
    .delimitador{
        width: 100%;
    }
    .renDivTh{
        width: 100%;
    }
    .renDivThDT{
        width: 100%;
    }
    .renDiv{
        border-bottom: 1px solid black;
        height:15px;
        width:100%;
    }
    .renDiv13{
        border-bottom: 1px solid black;
        height:15px;
        width:100%;        

    }
    .renDiv1{
        
        border-bottom: 1px solid black;
        height:15px;
        width:100%;
        margin-left:-5px;
    }
    .renDiv1DT{
        border-bottom: 1px solid transparent;
        height:15px;
        width:100%;
        margin-left:-5px;
    }
    .clth11{
        width: 50%;
    }
    .clthcelu{
        width: 5%;
    }
    .clthtipo{
        width: 47%;
    }
    body{
        width: 100%;
        font-family: Arial, Helvetica, sans-serif;
    }
    h1{
        text-align:center;
    }
    img{
        margin-top:30px;
        height:100px;
        width: 75px;
    }
    table{
        width:100%;
        font-size:15pt;
    }
    .dInAc{
        height: 35px;
        margin:20px;
        background-color:#104e85 ;
        color:white;
        text-align:center;       
    }
    .tblAg{
        position:absolute;
        
    }
    .footDiv{
        border-bottom:4px solid blue;
        margin-top:10px;
        width: 100%;
    }.footDiv1{
        border-bottom:2px solid orangered;
        margin-top:5px;
        width: 100%;
    }
    
    .fondLimitador{
        position: absolute;
        background-color:transparent;
        height:275px;
        width: 60px;;
        left:95%;
    }
    .divLogo {
        position: absolute;
        
    }
    .noOT{
        margin-top:-22px;
        margin-left:150px;
        border:1px solid black;
    }

    
    footer{
        position:absolute;
        left:20%;
        
    }
    th{
        float: left;
        font-size:15px;
        font-weight: normal;
        width: auto;
    }
.button {
        background-color: white;
        border: 1px solid black;
        color: white;
        padding: 7px;
        text-align: center;
        text-decoration: none;
        font-size: 4px;
    }  
.button5 {
    border-radius: 50%;
    margin-left:-40px;    
    background-color:blue;
}
.btnCir{
    font-size:15px;
    font-weight: normal;
    width: 90%;
    
    

}
.pr{
    margin-top:20px;
}



</style>
</html>
