
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF Ordenes Completadas {{ $ordenCompleta->id }} {{ $ordenCompleta->name }} {{ $ordenCompleta->lastname1 }} {{ $ordenCompleta->lastname2 }}</title>
    </head>

    <div class=delimitador>
        

<body >
<h5 class="oc" style="position: absolute; margin-left:97%; font-size:15px; border: 1px solid black; height:20px; width:80px; text-align:center;">ORIGINAL</h5>
    <br>
    <div class="memretado" style="margin-top: 30px;">
    <img  class="membre" src="{{ $base64 }}" alt="">
        <div class="meminfo">
            <h3 class="letrasFlex" style="width: 200px; margin-top:5px;" >Orden de trabajo</h3>
            <div class="noOT" style="color: red; font-weight:bold; font-size:20px; text-transform: capitalize;">
                No. {{ str_pad($ordenCompleta->id_orden, 5, 0, STR_PAD_LEFT) }}
            </div>
        </div> 
    </div>
   
    <header id="tablaAdi"> 
    @php 
    $arregloRequiere = json_decode($ordenCompleta->requiere2 );
    $bitacora = false;
    $agendar = false;
    $cancelar = false;
    $elloshablan = false;
    $nada = false;

    // Use a persistent variable if available, otherwise initialize to false
    $requiere4 = $ordenCompleta->requiere4 ?? false;

    foreach($arregloRequiere as $item){
        if($item == 'Bitacora'){ $bitacora = true; }
        if($item == 'Agendar'){ $agendar = true; }
        if($item == 'Cancelar'){ $cancelar = true; }
        if($item == 'Ellos hablan'){ $elloshablan = true; }
        if($item == 'Nada'){ $nada = true; }
    }

    $pagado = ($ordenCompleta->requiere3 == 'Pagado/Efectivo') ? true : false;
    $pagadobanco = ($ordenCompleta->requiere3 == 'Pagado/Banco') ? true : false;
    $credito = ($ordenCompleta->requiere3 == 'Credito') ? true : false;

    // Ensure creditomamalon becomes true if credito is true and cannot be changed back
    if ($credito) {
        $requiere4 = true;
    }

    // Persist the value of creditomamalon in the ordenCompleta object
    $ordenCompleta->requiere4 = $requiere4;
    @endphp 
        <div>
        @if($pagadobanco)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:110px;">PAGADO BANCO</th>
            </table>
            @elseif($pagado)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:125px;">PAGADO EFECTIVO</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">PAGADO</th>
            </table>
            @endif
            @if($requiere4)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:50px;">CREDITO</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">CREDITO</th>
            </table>
            @endif
            @if($bitacora)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:50px;">BITACORA</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">BITACORA</th>
            </table>
            @endif
            @if($agendar)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:150px;">AGENDAR ({{ $ordenCompleta->otraDosis }})</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">AGENDAR</th>
            </table>
            @endif
            @if($cancelar)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:50px;">CANCELAR</th>
            </table>   
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">CANCELAR</th>
            </table>   
            @endif
            @if($elloshablan)
            <table>
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:100px;">ELLOS HABLAN</th>
            </table> 
            @else
            <table>
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:100px;">ELLOS HABLAN</th>
            </table> 
            @endif
            <table>
                <td style="margin-right: -50px;  width:25px; text-align:center; color:transparent;">( )</th>
                <td style="margin-left: -50px; width:100px; color:red;" >{{ $ordenCompleta->nDosis }}</th>
            </table> 

            
            
        </div>                
    </header>
    <main style="margin-top: 24px"> 
        <img src="{{ $base641 }}" alt="" style="z-index: -1; position: absolute; opacity:0.4; width:auto; height:300px; margin-left:42%; margin-top:-7%;">
        <div class="cont">
        <div class="fondLimitador"></div>
        <table style="margin-top: 0px">
            <th class="clth112" style="width: 105px; text-align:left;">Fecha Orden</th>
            <th class="renDivTh" style="width: 50%;">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $fecha->dayName }}, {{ $fecha->day }}  de {{ $fecha->monthName }} de {{ $fecha->year }}
            </div>
            </th>  
            <th class="clth111" style="width: 160px; ">Fecha Programada</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $fecha2->dayName }}, {{ $fecha2->day }}  de {{ $fecha2->monthName }} de {{ $fecha2->year }}
            </div>
            </th>           
        </table>
            
        <table style="margin-top: 0px">
            <th class="clth11" style="width: 157px; text-align:left;">Nombre Comercial</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->tradename }}
            </div>
            </th> 
            <th>Hora</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->time1}} A {{ $ordenCompleta->time2 }}
            </div>
            </th>
        </table>
        <table style="margin-top: 0px">
            <th class="clth110" style="width: 146px; text-align:left;" >Nombre Personal</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->name }} {{ $ordenCompleta->lastname1 }} {{ $ordenCompleta->lastname2 }}
            </div>
            </th> 
            <th> Telefono</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ substr($ordenCompleta->cell_phone, 0, 3) }} - {{ substr($ordenCompleta->cell_phone, 3, 3) }} - {{ substr($ordenCompleta->cell_phone, 6, 2) }} - {{ substr($ordenCompleta->cell_phone, 8, 2) }} 
            </div>
            </th> 
        </table>
        <table style="margin-top: 0px">
            <th>Domicilio</th>
            <th class="renDivTh" >
            <div class="renDivDom" style="font-size:14px; text-transform: uppercase;">
                {{ $ordenCompleta->street }} {{ $ordenCompleta->home }} #{{ $ordenCompleta->numAddress }}
            </div>
            </th> 
            <th>Colonia</th>
            <<th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->colonia }} #{{ $ordenCompleta->codigoPostal }}
            </div>
            </th> 
        </table>
        <table style="margin-top: 0px">
            <th class="clth1112" style="text-align:left;">Localizacion</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->how_to_get }}
            </div>
            </th>           
        </table>
        <table class="">
            <th class="clth1112" style=" text-align:left;">Lugar</th>
            <th class="renDivTh2">
            <div class="renDivlugar" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->comercio }}
            </div>
            </th>
            <th class="clth1122" >Ciudad</th>
            <th class="renDivThlocal">
            <div class="renDivcity" style="font-size:14px; text-transform: uppercase;">
            {{ $ordenCompleta->ciudad }}
            </div>
            </th>
            
        </table>
        <table>
            <th>Plagas</th>
            <th class="renDivTh3">
            <div class="renDivplaga" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->plague1 }} y {{ $ordenCompleta->plague2 }}
            </div>
            </th> 
        </table>
        <table>
            <th style="text-align:left;">Observaciones</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->description }}
            </div>
            </th> 
        </table>

        @php 
            $arreglo = json_decode($ordenCompleta->hiring );
            $presupuesto=false;
            $fumigar=false;
            $garantia=false;
            $cortesia=false;
            $nada=false;
        
            foreach($arreglo as $item){
                if($item == 'Presupuesto'){ $presupuesto=true; }
                if($item == 'Fumigar'){ $fumigar=true; }
                if($item == 'Garantia'){ $garantia=true; }
                if($item == 'Cortesia'){ $cortesia=true; }
                if($item == 'Nada'){ $nada=true; }
            }
        @endphp

<table class="btnCir">
            
    <th style="text-align:center;">
        @if($presupuesto)
            <div class="" style="margin-left:25%;  display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; border-radius:50%; font-size:7.5px;">
                <h1 style="margin: 0;">X</h1>
            </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>            
    <th style="text-align:left; "> Presupuesto</th>
    <th>
        @if($fumigar)
        <div class="" style=" margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
            @else
            <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
                <h1 style="margin: 0;"></h1>
            </div>
        @endif
    </th>
    <th style="text-align:left;"> Fumigar</th>
    
    <th >
        @if($garantia)
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>
    <th style="text-align:left; "> Garantia</th>
    <th> 
        @if($cortesia)
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>
    <th style="text-align:left;"> Cortesia</th>
    <th> 
        @if($nada)
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>
    <th style="text-align:left; margin-top:5px;"> Nada</th>
</table>

        <table class="">
            <th class="clth114" style="width: 155px; text-align:left;">Producto: Interno</th>
            <th class="renDivTh" style="width: 50%">
            <div class="renDiv">
                {{ $ordenCompleta->productoInt1 }}
            </div>
            </th>
            <th>Externo</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $ordenCompleta->productoExt1 }}
            </div>
            </th> 
        </table>
        <table class="">
            <th>Fumigador</th>
            <th class="renDivTh"style="font-size:14px;">
            <div class="renDiv" >
                {{ $ordenCompleta->ariasEmpleado1 }}
            </div>
            </th>
            <th>Cotizacion</th>
            <th class="renDivTh" style="font-size:14px;">
            <div class="renDiv">
                $ {{ $ordenCompleta->pago }}
            </div>
            </th> 
        </table>

        @php 
        $arreglo = json_decode($ordenCompleta->requiere1 );
        $factura=false;
        $certificado=false;
        $remision=false;
        $nada=false;
    
        foreach($arreglo as $item){
            if($item == 'Factura'){ $factura=true; }
            if($item == 'Certificado'){ $certificado=true; }
            if($item == 'Remision'){ $remision=true; }
            if($item == 'Nada'){ $nada=true; }
        }
    @endphp

<table class="btnCir2">
<th>Require de:</th>
<th style="text-align:center;">
    @if($factura)
        <div class="" style="margin-left:25%;  display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
    @else
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;"></h1>
    </div>
    @endif
</th>            
<th style="text-align:left; "> Factura</th>

<th>
    @if($certificado)
    <div class="" style=" margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;">X</h1>
    </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
    @endif
</th>
<th style="text-align:left;"> Certificado</th>

<th >
    @if($remision)
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;">X</h1>
    </div>
    @else
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;"></h1>
    </div>
    @endif
</th>
<th style="text-align:left; ">Remision</th>
<th> 
    @if($nada)
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;">X</h1>
    </div>
    @else
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;"></h1>
    </div>
    @endif
</th>
<th style="text-align:left;"> Nada</th>

</table>


        <!--Antigua tabla
            <table class="btnCir2">
            <th>Require de:</th>
            <th ><button class="button button5"> </button>
            <th > Factura</th>
            <th><button class="button button5"> </button>
            <th> Certificado</th>
            <th><button class="button button5"> </button>
            <th> Remision</th>
            <th><button class="button button5"> </button>
            <th> Nada</th>
        </table>
        <table>
            <th class="clth1">Forma de contacto:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $ordenCompleta->contact_form }}
            </div>
            </th>  
            </th>         
        </table> 
        -->

        <div class="footDiv"></div>
        <div class="footDiv1"></div>
        <table class="footer">
            <th class="footer">Col. Alamedas</th>
            <th>C.P. 31704</th>
            <th>Calle del Abeto #2201</th>
            <th>Nuevo Casas Grandes, Chihu. </th>
            <th>Tel.636-694-65-15</th>
        </table>
        </div>
        


        
    </main>
    </div>

    <br>
    <br>
    <div class="division2"></div>

    
    
    
</body>

<body>
<h5 class="oc" style="position: absolute; margin-left:97%; margin-top:-10px; font-size:15px; border: 1px solid black; height:20px; width:80px; text-align:center;">COPIA</h5>
    <br>
    <div class="memretado">
    <img  id="membre" src="{{ $base64 }}" alt="">
        <div class="meminfo" >
            <h3 class="letrasFlex" style="width: 200px; margin-top:5px;" >Orden de trabajo</h3>
            <div class="noOT" style="color: red; font-weight:bold; font-size:20px; text-transform: capitalize;">
                No. {{ str_pad($ordenCompleta->id_orden, 5, 0, STR_PAD_LEFT) }}
            </div>
        </div> 
    </div>
   
    <header id="tablaAdi"> 
    @php 
    $arregloRequiere = json_decode($ordenCompleta->requiere2 );
    $bitacora = false;
    $agendar = false;
    $cancelar = false;
    $elloshablan = false;
    $nada = false;

    // Use a persistent variable if available, otherwise initialize to false
    $requiere4 = $ordenCompleta->requiere4 ?? false;

    foreach($arregloRequiere as $item){
        if($item == 'Bitacora'){ $bitacora = true; }
        if($item == 'Agendar'){ $agendar = true; }
        if($item == 'Cancelar'){ $cancelar = true; }
        if($item == 'Ellos hablan'){ $elloshablan = true; }
        if($item == 'Nada'){ $nada = true; }
    }

    $pagado = ($ordenCompleta->requiere3 == 'Pagado/Efectivo') ? true : false;
    $pagadobanco = ($ordenCompleta->requiere3 == 'Pagado/Banco') ? true : false;
    $credito = ($ordenCompleta->requiere3 == 'Credito') ? true : false;

    // Ensure creditomamalon becomes true if credito is true and cannot be changed back
    if ($credito) {
        $requiere4 = true;
    }

    // Persist the value of creditomamalon in the ordenCompleta object
    $ordenCompleta->requiere4 = $requiere4;
    @endphp 
        <div>
        @if($pagadobanco)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:110px;">PAGADO BANCO</th>
            </table>
            @elseif($pagado)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:125px;">PAGADO EFECTIVO</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">PAGADO</th>
            </table>
            @endif
            @if($requiere4)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:50px;">CREDITO</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">CREDITO</th>
            </table>
            @endif
            @if($bitacora)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:50px;">BITACORA</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">BITACORA</th>
            </table>
            @endif
            @if($agendar)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:150px;">AGENDAR ({{ $ordenCompleta->otraDosis }})</th>
            </table>
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">AGENDAR</th>
            </table>
            @endif
            @if($cancelar)
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:50px;">CANCELAR</th>
            </table>   
            @else
            <table >
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:50px;">CANCELAR</th>
            </table>   
            @endif
            @if($elloshablan)
            <table>
                <td style="margin-right: -50px;  width:25px; text-align:center;">(X)</th>
                <td style="margin-left: -50px; width:100px;">ELLOS HABLAN</th>
            </table> 
            @else
            <table>
                <td style="margin-right: -50px;  width:25px; text-align:center;">( )</th>
                <td style="margin-left: -50px; width:100px;">ELLOS HABLAN</th>
            </table> 
            @endif
            <table>
                <td style="margin-right: -50px;  width:25px; text-align:center; color:transparent;">( )</th>
                <td style="margin-left: -50px; width:100px; color:red;" >{{ $ordenCompleta->nDosis }}</th>
            </table> 

            
            
        </div>                
    </header>
    <main style="margin-top: 24px"> 
        <img src="{{ $base641 }}" alt="" style="z-index: -1; position: absolute; opacity:0.4; width:auto; height:300px; margin-left:42%; margin-top:-7%;">
        <div class="cont">
        <div class="fondLimitador"></div>
        <table style="margin-top: 0px">
            <th class="clth112" style="width: 105px; text-align:left;">Fecha Orden</th>
            <th class="renDivTh" style="width: 50%;">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $fecha->dayName }}, {{ $fecha->day }}  de {{ $fecha->monthName }} de {{ $fecha->year }}
            </div>
            </th>  
            <th class="clth111" style="width: 160px; ">Fecha Programada</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $fecha2->dayName }}, {{ $fecha2->day }}  de {{ $fecha2->monthName }} de {{ $fecha2->year }}
            </div>
            </th>           
        </table>
            
        <table style="margin-top: 0px">
            <th class="clth11" style="width: 157px; text-align:left;">Nombre Comercial</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->tradename }}
            </div>
            </th> 
            <th>Hora</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->time1}} A {{ $ordenCompleta->time2 }}
            </div>
            </th>
        </table>
        <table style="margin-top: 0px">
            <th class="clth110" style="width: 146px; text-align:left;" >Nombre Personal</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->name }} {{ $ordenCompleta->lastname1 }} {{ $ordenCompleta->lastname2 }}
            </div>
            </th> 
            <th> Telefono</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ substr($ordenCompleta->cell_phone, 0, 3) }} - {{ substr($ordenCompleta->cell_phone, 3, 3) }} - {{ substr($ordenCompleta->cell_phone, 6, 2) }} - {{ substr($ordenCompleta->cell_phone, 8, 2) }} 
            </div>
            </th> 
        </table>
        <table style="margin-top: 0px">
            <th>Domicilio</th>
            <th class="renDivTh" >
            <div class="renDivDom" style="font-size:14px; text-transform: uppercase;">
                {{ $ordenCompleta->street }} {{ $ordenCompleta->home }} #{{ $ordenCompleta->numAddress }}
            </div>
            </th> 
            <th>Colonia</th>
            <<th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->colonia }} #{{ $ordenCompleta->codigoPostal }}
            </div>
            </th> 
        </table>
        <table style="margin-top: 0px">
            <th class="clth1112" style="text-align:left;">Localizacion</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->how_to_get }}
            </div>
            </th>           
        </table>
        <table class="">
            <th class="clth1112" style=" text-align:left;">Lugar</th>
            <th class="renDivTh2">
            <div class="renDivlugar" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->comercio }}
            </div>
            </th>
            <th class="clth1122" >Ciudad</th>
            <th class="renDivThlocal">
            <div class="renDivcity" style="font-size:14px; text-transform: uppercase;">
            {{ $ordenCompleta->ciudad }}
            </div>
            </th>
            
        </table>
        <table>
            <th>Plagas</th>
            <th class="renDivTh3">
            <div class="renDivplaga" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->plague1 }} y {{ $ordenCompleta->plague2 }}
            </div>
            </th> 
        </table>
        <table>
            <th style="text-align:left;">Observaciones</th>
            <th class="renDivTh">
            <div class="renDiv" style="font-size:14px; text-transform: uppercase">
                {{ $ordenCompleta->description }}
            </div>
            </th> 
        </table>

        @php 
            $arreglo = json_decode($ordenCompleta->hiring );
            $presupuesto=false;
            $fumigar=false;
            $garantia=false;
            $cortesia=false;
            $nada=false;
        
            foreach($arreglo as $item){
                if($item == 'Presupuesto'){ $presupuesto=true; }
                if($item == 'Fumigar'){ $fumigar=true; }
                if($item == 'Garantia'){ $garantia=true; }
                if($item == 'Cortesia'){ $cortesia=true; }
                if($item == 'Nada'){ $nada=true; }
            }
        @endphp

<table class="btnCir">
            
    <th style="text-align:center;">
        @if($presupuesto)
            <div class="" style="margin-left:25%;  display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; border-radius:50%; font-size:7.5px;">
                <h1 style="margin: 0;">X</h1>
            </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>            
    <th style="text-align:left; "> Presupuesto</th>
    <th>
        @if($fumigar)
        <div class="" style=" margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
            @else
            <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
                <h1 style="margin: 0;"></h1>
            </div>
        @endif
    </th>
    <th style="text-align:left;"> Fumigar</th>
    
    <th >
        @if($garantia)
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>
    <th style="text-align:left; "> Garantia</th>
    <th> 
        @if($cortesia)
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>
    <th style="text-align:left;"> Cortesia</th>
    <th> 
        @if($nada)
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
        @endif
    </th>
    <th style="text-align:left; margin-top:5px;"> Nada</th>
</table>

        <table class="">
            <th class="clth114" style="width: 155px; text-align:left;">Producto: Interno</th>
            <th class="renDivTh" style="width: 50%">
            <div class="renDiv">
                {{ $ordenCompleta->productoInt1 }}
            </div>
            </th>
            <th>Externo</th>
            <th class="renDivTh">
            <div class="renDiv">
                {{ $ordenCompleta->productoExt1 }}
            </div>
            </th> 
        </table>
        <table class="">
            <th>Fumigador</th>
            <th class="renDivTh"style="font-size:14px;">
            <div class="renDiv" >
                {{ $ordenCompleta->ariasEmpleado1 }}
            </div>
            </th>
            <th>Cotizacion</th>
            <th class="renDivTh" style="font-size:14px;">
            <div class="renDiv">
                $ {{ $ordenCompleta->pago }}
            </div>
            </th> 
        </table>

        @php 
        $arreglo = json_decode($ordenCompleta->requiere1 );
        $factura=false;
        $certificado=false;
        $remision=false;
        $nada=false;
    
        foreach($arreglo as $item){
            if($item == 'Factura'){ $factura=true; }
            if($item == 'Certificado'){ $certificado=true; }
            if($item == 'Remision'){ $remision=true; }
            if($item == 'Nada'){ $nada=true; }
        }
    @endphp

<table class="btnCir2">
<th>Require de:</th>
<th style="text-align:center;">
    @if($factura)
        <div class="" style="margin-left:25%;  display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;">X</h1>
        </div>
    @else
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;"></h1>
    </div>
    @endif
</th>            
<th style="text-align:left; "> Factura</th>

<th>
    @if($certificado)
    <div class="" style=" margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;">X</h1>
    </div>
        @else
        <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
            <h1 style="margin: 0;"></h1>
        </div>
    @endif
</th>
<th style="text-align:left;"> Certificado</th>

<th >
    @if($remision)
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;">X</h1>
    </div>
    @else
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;"></h1>
    </div>
    @endif
</th>
<th style="text-align:left; ">Remision</th>
<th> 
    @if($nada)
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;">X</h1>
    </div>
    @else
    <div class="" style="margin-left:25%; display:flex; width: 17px; height:17px; border: 1px solid black; justify-content:center; align-items:center; border-radius:50%; font-size:7.5px;">
        <h1 style="margin: 0;"></h1>
    </div>
    @endif
</th>
<th style="text-align:left;"> Nada</th>

</table>


        <!--Antigua tabla
            <table class="btnCir2">
            <th>Require de:</th>
            <th ><button class="button button5"> </button>
            <th > Factura</th>
            <th><button class="button button5"> </button>
            <th> Certificado</th>
            <th><button class="button button5"> </button>
            <th> Remision</th>
            <th><button class="button button5"> </button>
            <th> Nada</th>
        </table>
        <table>
            <th class="clth1">Forma de contacto:</th>
            <th class="renDivTh">
            <div class="renDiv1">
                {{ $ordenCompleta->contact_form }}
            </div>
            </th>  
            </th>         
        </table> 
        -->

        <div class="footDiv"></div>
        <div class="footDiv1"></div>
        <table class="footer">
            <th class="footer">Col. Alamedas</th>
            <th>C.P. 31704</th>
            <th>Calle del Abeto #2201</th>
            <th>Nuevo Casas Grandes, Chihu. </th>
            <th>Tel.636-694-65-15</th>
        </table>
        </div>
    </main>
    </div>
</body>

<style>
.clth1112 {
    width: 5%;
}
.clth1122 {
    width: -50%;
    padding: -100px;
}
.renDiv115 {
    width: 100%;
    border-bottom: 1px solid black;
}
.clth20 {
    margin-left: -50%;
}
.division2 {
    position: absolute;
    width: 130%;
    margin-left: -60px;
    margin-top: -23px;
    border: 1px solid grey;
}
.division {
    width: 130%;
    margin-left: -60px;
    margin-top: 30px;
    padding-bottom: 0px;
}
.cont {
    margin-top: -5%;
}
.clth114 {
    width: 32%;
}
.clth113 {
    width: 19%;
}
.clth112 {
    width: 31%;
}
.clth111 {
    width: 43%;
}
.clth110 {
    width: 33%;
}
.renDiv1 {
    border-bottom: 1px solid black;
    height: 15px;
    width: 100%;
    margin-left: -5px;
    margin-top: 4px;
}
.letrasflex {
    margin-top: 15px;
    padding-right: 40px;
}
.meminfo {
    text-align: center;
    position: absolute;
    margin-left: -61%;
    margin-top: 12%;
    width: 300px;
}
.membre {
    margin-top:0px;
    padding-left: -10%;
    height: 14.7%;
    width: auto;
    padding-right: 40px;
}
.delimitador {
    margin-top: -5%;
}
.renDivTh {
    width: 100%;
}
.renDivTh2 {
    width: 33%;
}
.renDivTh3 {
    width: 150%;
}
.renDivDom {
    border-bottom: 1px solid black;
    height: 15px;
    width: 100%;
}
.renDiv {
    border-bottom: 1px solid black;
    height: 15px;
    width: 100%;
}
.clth1 {
    width: 44%;
}
.clth11 {
    width: 37%;
}
.renDivloca {
    border-bottom: 1px solid black;
    height: 15px;
    width: 100%;
}
.renDivThlocal {
    width: 70%;
}
.renDivlugar {
    border-bottom: 1px solid black;
    width: 100%;
    font-size: 9px;
}
.renDivplaga {
    border-bottom: 1px solid black;
    width: 100%;
    font-size: 9px;
}
.renDivcity {
    border-bottom: 1px solid black;
    width: 100%;
}
body {
    width: 110%;
    margin: -5%;
    margin-top: -2%;
    font-weight: bold;
    text-transform: uppercase;
}
h1 {
    text-align: center;
}
img {
    margin-top: 30px;
    height: 100px;
    width: 75px;
}
table {
    width: 100%;
    font-size: 15pt;
}
.dInAc {
    height: 35px;
    margin: 20px;
    background-color: #104e85;
    color: white;
    text-align: center;
}
.tblAg {
    position: absolute;
}
.footDiv {
    border-bottom: 4px solid blue;
    margin-top: 15px;
    width: 100%;
}
.footDiv1 {
    border-bottom: 2px solid orangered;
    margin-top: 5px;
    width: 100%;
}
.fondLimitador {
    position: absolute;
    background-color: transparent;
    height: 275px;
    width: 60px;
    left: 95%;
}
.divLogo {
    position: absolute;
}
.noOT {
    position: absolute;
    margin-top: -43px;
    margin-left: 205px;
    border: 1px solid black;
    width: 100px;
}
footer {
    position: absolute;
    left: 20%;
}
th {
    float: left;
    font-size: 15px;
    font-weight: normal;
    width: auto;
}
.button {
    height: 4px;
    height: 4px;
    background-color: white;
    border: 1px solid black;
    color: white;
    padding: 7px;
    text-decoration: none;
    font-size: 14px;
    text-align: start;
}
.button5 {
    text-align: start;
    height: 4px;
    height: 4px;
    border-radius: 50%;
    margin-right: -30px;
    background-color: blue;
}
.btnCan {
    border-radius: 50%;
    margin-right: -30px;
    background-color: rgba(0, 0, 255, 0);
}
.btnCir {
    font-size: 15px;
    font-weight: normal;
    width: 90%;
}
.btnCir2 {
    font-size: 15px;
    font-weight: normal;
    width: 90%;
}
.pr {
    margin-top: 20px;
}
.memretado {
    margin-left: 0px;
}
td {
    font-size: 12.5px;
}
#tablaAdi{
    position: absolute;
    margin-top: -170px;
    margin-left: 72%;
    font-size: 15px;
    width: 7%;
}
#tablaAdi2 {
    position: absolute;
    margin-top: 0%;
    margin-left: 60px;
    font-size: 15px;
    width: 7%;
}
.letrasflex {
    margin-left: 20px;
    margin-top: 15px;
    padding-right: 70px;
    padding-left: 70px;
}
.meminfo {
    text-align: center;
    position: absolute;
    margin-left: -55%;
    margin-top: 12%;
}
#membre{
    margin-top:0px;
    padding-left: -10%;
    height: 30%;
    width: auto;
    padding-right: 40px;
}
</style>
</html>




