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
    <h5 class="txtDia">DIA</h5>
    <h5 class="txtDia1">{{ $data->RemisionDate }}</h5>
    <h5 style="color: red; margin-left:80%; border: 1px solid black; height:20px; width: 90px; text-align:center; ">No. {{ str_pad($data->id, 5, 0, STR_PAD_LEFT) }}</h5>
</table>
<img class="membre" src="{{ $base64 }}" alt="">
    
    <div class="meminfo">
        
        <div style="margin-top: -30%; margin-left:70%; padding-bottom:-20px;">
            <h2 class="letrasFlex%;" >REMISION</h2>
        </div>
    </div>
    <header>    
        
    </header>

    <main style="margin-top: -60px;"> 
        <img src="{{ $base641 }}" alt="" style="z-index: -1; position: absolute; opacity:0.4; width:auto; height:300px; margin-left:36.5%; margin-top:-7%;">
        <div class="fondLimitador"></div>
        <table>
            <th class="clthrs">RAZON SOCIAL:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->tradename }}
            </div>
            </th>  
        </table>
            
        <table>
            <th class="clth">NOMBRE:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->name }} {{ $data->lastname1 }} {{ $data->lastname2 }}
            </div>
            </th>  
        </table>
        <table>
            <th>DOMICILIO:</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $data->home }} #{{ $data->numAddress }}
            </div>
            </th> 
            <th> CIUDAD:</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $data->ciudad }}
            </div>
            </th> 
        </table>
        <table>
            <th class="clthcelu"  >COLONIA:</th>
            <th class="renDivTh" >
            <div class="renDiv1" style="height: 20px;" >
                {{ $data->colonia }} #{{ $data->codigoPostal }}
            </div>
            </th> 
            <th class="clthcelu">TELEFONO:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->number_fixed_number }}
            </div>
            </th> 
            
        </table>
        <table>
            <th class="clthcelu">CELULAR:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->cell_phone }}
            </div>
            </th> 
            <th class="clthtipo">TIPO DE LUGAR:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->comercio }}
            </div>
            </th>  
        </table>
        <div >
        <table class="btnCir">
            
            <th class="clth118">REQUIERE DE:</th>
            <div class="btntxt"></div>
            <th class="clth22" > Certificado</th>
            <th class="btnrd"><button class="button button5"> </button>
            
            </th> 
            <th class="clth113">IMPORTE:</th>
            <th class="renDivTh">
            <div class="renDiv13">
                $ {{ $data->RemisionMonto }}
            </div>
            </th>
            
        </table>

        </div>
        
        <table class="">
            <th>OBSERVACIONES:</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $data->RemisionObservaciones }}
            </div>
            </th>            
        </table>

        <div class="ctr">
            <h5 class="tipo">ORIGINAL CLIENTE</h5>
        </div>

        <div class="footDiv"></div>
        <div class="footDiv1"></div>
        <table class="footer">
            <th class="footer">Calle del Abeto No.2201</th>
            <th> Col. Alamedas </th>
            <th> C.P. 31704</th>
            <th> Nuevo Casas Grandes, Chihu. </th>
            <th> Tel.636-694-65-15</th>
            
            
        </table>
        


        
    </main>
    </div>
    <div class="separacion"></div>
    
</body>
<body >
    <table class="tblDia" >
        <h5 class="txtDia">DIA</h5>
        <h5 class="txtDia1">{{ $data->RemisionDate }}</h5>
        <h5 style="color: red; margin-left:80%; border: 1px solid black; height:20px; width: 90px; text-align:center; ">No. {{ str_pad($data->id, 5, 0, STR_PAD_LEFT) }}</h5>

    </table>
    <img class="membre2"  src="{{ $base64 }}" alt="">
        
        <div class="meminfo">
            
            <div style="margin-top: -30%; margin-left:70%; padding-bottom:-20px;">
                <h2 class="letrasFlex%;" >REMISION</h2>
            </div>
        </div>
    
    
    <header>    
        
    </header>

    <main> 
        <img src="{{ $base641 }}" alt="" style="z-index: -1; position: absolute; opacity:0.4; width:auto; height:300px; margin-left:36.5%; margin-top:-7%;">
        <div class="fondLimitador"></div>
        <table>
            <th class="clth1">RAZON SOCIAL:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->tradename }}
            </div>
            </th>  
        </table>
            
        <table>
            <th class="clth">NOMBRE:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->name }} {{ $data->lastname1 }} {{ $data->lastname2 }}
            </div>
            </th>  
        </table>
        <table>
            <th>DOMICILIO:</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $data->home }} #{{ $data->numAddress }}
            </div>
            </th> 
            <th> CIUDAD:</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $data->ciudad }}
            </div>
            </th> 
        </table>
        <table>
            <th class="clthcelu"  >COLONIA:</th>
            <th class="renDivTh" >
            <div class="renDiv1" style="height: 20px;" >
                {{ $data->colonia }} #{{ $data->codigoPostal }}
            </div>
            </th> 
            <th class="clthcelu">TELEFONO:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->number_fixed_number }}
            </div>
            </th> 
            
        </table>
        <table>
            <th class="clthcelu">CELULAR:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->cell_phone }}
            </div>
            </th> 
            <th class="clthtipo">TIPO DE LUGAR:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $data->comercio }}
            </div>
            </th>  
        </table>
        <div >
        <table class="btnCir">
            
            <th class="clth118">REQUIERE DE:</th>
            <div class="btntxt"></div>
            <th class="clth22" > Certificado</th>
            <th class="btnrd"><button class="button button5"> </button>
            
            </th> 
            <th class="clth113">IMPORTE:</th>
            <th class="renDivTh">
            <div class="renDiv13">
                $ {{ $data->RemisionMonto }}
            </div>
            </th>
            
        </table>

        </div>
        
        <table class="">
            <th>OBSERVACIONES:</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $data->RemisionObservaciones }}
            </div>
            </th>            
        </table>

        <div class="ctr">
            <h5 class="tipo">COPIA FUMI-KILLE'R</h5>
        </div>

        <div class="footDiv"></div>
        <div class="footDiv1"></div>
        <table class="footer">
            <th class="footer">Calle del Abeto No.2201</th>
            <th> Col. Alamedas </th>
            <th> C.P. 31704</th>
            <th> Nuevo Casas Grandes, Chihu. </th>
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
        width: 38px;;
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
        margin-left:80%;
        border: 1px solid black;
    }
    .txtBDDia{
        left:80%;
    }.tblDia{
        position:absolute;
        margin-left: 65px;
    }
    .separacion{
        margin-top:40px;
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
        width:45.7%;
    }
    .clthrs{
        width:19.9%;
    }
    .btnrd{
        position:absolute;
        margin-left: -50px;

    }
    .clth22{
        width:85%;
        margin-left: 50px;
        margin-right: -50px;
    }
    .clth114{
        width: 30%;
        
    }
    .clth113{
        width:30%;
    }
    .clth1{
        width: 21%;
    }
    .letrasflex{
        margin-bottom: 40px;
        left: 20px;
    }
    .meminfo{
        text-align: center;
        position: absolute;
        margin-left: -42%;
        margin-top:11%;
        padding-bottom:-50px; 
        
    }
    .membre{
        margin-top:0px;
        padding-left: 160px;
        height:15%;
        width: auto;
    }  
    .membre2{
        margin-top:0px;
        padding-left: 160px;
        height:13.8%;
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
    .renDiv{
        border-bottom: 1px solid black;
        height:15px;
        width:100%;
    }
    .renDiv13{
        border-bottom: 1px solid black;
        height:15px;
        width:128%;        

    }
    .renDiv1{
        
        border-bottom: 1px solid black;
        height:15px;
        width:100%;
        margin-left:-5px;
    }.clth11{
        width: 50%;
    }
    .clthcelu{
        width: 5%;
    }
    .clthtipo{
        width: 42.7%;
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
        margin-top:45px;
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
    margin-left:-80px;    
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
