<template>
    <div>
        <div class="flex justify-center items-center h-screen bg-gradient-to-r from-orange-500 from-25% to-blue-800 to-60%">
            <div class="flex" style="width:60%; height: 80%;">
                <div class="contenedor1 flex justify-center items-center">
                    <img v-bind:src="url+'img/logofk.png'" class="imgFk">               
                </div>
                <div class="contenedor2 row justify-center items-center">
                    <div>
                        <h1 class="mt-5 text-center text-2xl font-bold text-yellow-500" style="">SISTEMA DE FUMIGACIONES URBANAS</h1>
                        <h1 class="mt-5 text-center text-6xl font-bold text-blue-950 lbltittleFumi" style="text-shadow: -2px 2px 5px white;">FUMI-KILLE'R</h1>
                    </div>
                    <div class="flex justify-center items-center">
                        <router-link to="/admin/home">
                            <button class="btnInicio">
                                Inicio
                            </button>
                        </router-link>
                    </div>
                    <div>
                        <h1 class="mt-24 text-center text-2xl font-bold text-blue-800" style="">EN CASA FUMIGADA, "NO ENTRAN BICHOS"</h1>
                        <h1 class="mt-5 mr-4 text-end text-md font-bold text-neutral-950" style="">Liadeo Chávez & Luis Peña 2024 v9.2.175 </h1>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--
    
    <div class="flex justify-center items-center h-screen bg-gradient-to-r from-orange-500 from-25% to-blue-800 to-60%">
        <div class="w-1/2">
            <div class="DivAzul">
                <img v-bind:src="url+'img/logofk.png'" class="imgFk">               
                <div class="DivNaranja">
                    <h1 style="margin-top:25%;font-size: 60px; ">FUMI-KILLE'R</h1>
                    
                    <router-link to="/admin/home">
                        <button class="btnInicio">
                            Inicio
                        </button>
                    </router-link>

                    
                    
                </div>
            </div>   
            
            
        </div>
    </div>






    <div class="w-10 h-10" style="background-color: black;">

        <div class="DivAzul">
            <div class="DivNaranja">
                <h1 style="margin-top:15%;font-size: 60px; ">FUMI-KILLE'R</h1>
                <button class="btnInicio">INICIO</button>
            </div>
        </div>   
        
    </div>
-->
</template>

<style>

.btnInicio {
    margin-top:     50%;
    background-color: black;
    border-radius: 50px;
    width: 270px;
    height: 90px;
    color: aliceblue;
    font-size: 40px;
    text-align: center;
    border: none;
    transition: .5s;
}

.btnInicio:hover {
    align-items: center;
    transform: scale(1.2);
    text-align: center;
    border: 1px solid black; 
    /*background: linear-gradient(to right, white, black);*/
    color: white;
    font-weight: bolder; 
    background-color: #1e40af;
}





.contenedor1 {
    background-color: #1e40af;
    width: 35%;
    height: 100%;
    border-radius: 25px 0% 0% 25px;
}

.contenedor2 {
    background-color: #f97316;
    width: 65%;
    height: 100%;
    border-radius: 0% 25px 25px 0%;
    font-family: cursive;
}

.imgFk {
    width: 15%;
    height: auto;
    position: absolute;
}

.lbltittleFumi:hover {
    transform: scale(1.1);
    text-align: center;

  }

</style>

<script>
export default {
    name: 'LoginComponent',
    data: () => ({
        url: process.env.VUE_APP_ROOT_ASSETS,
    }),
}

</script>
