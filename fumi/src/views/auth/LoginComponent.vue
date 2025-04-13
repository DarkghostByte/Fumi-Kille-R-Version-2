<template>
    <div>
      <div
        class="flex justify-center items-center h-screen bg-gradient-to-r from-orange-500 from-25% to-blue-800 to-60%"
      >
        <div class="flex" style="width: 60%; height: 80%">
          <div class="contenedor1 flex justify-center items-center">
            <img v-bind:src="url + 'img/logofk.png'" class="imgFk" />
          </div>
          <div class="contenedor2 row justify-center items-center">
            <div>
              <h1
                class="mt-5 text-center text-2xl font-bold text-yellow-500"
                style=""
              >
                SISTEMA DE FUMIGACIONES URBANAS
              </h1>
              <h1
                class="mt-5 text-center text-6xl font-bold text-blue-950 lbltittleFumi"
                style="text-shadow: -2px 2px 5px white"
              >
                FUMI-KILLE'R
              </h1>
            </div>
            <div class="flex flex-col items-center w-full">
              <input
                v-model="email"
                type="email"
                placeholder="Email"
                class="input-field"
              />
              <input
                v-model="password"
                type="password"
                placeholder="Contraseña"
                class="input-field"
              />
              <button class="btnInicio" @click="loginUser">Iniciar Sesión</button>
            </div>
            <div>
              <h1
                class="mt-24 text-center text-2xl font-bold text-blue-800"
                style=""
              >
                EN CASA FUMIGADA, "NO ENTRAN BICHOS"
              </h1>
              <h1
                class="mt-5 mr-4 text-end text-md font-bold text-neutral-950"
                style=""
              >
                Liadeo Chávez & Luis Peña 2024 v9.2.175
              </h1>
            </div>
          </div>
        </div>
      </div>
      <div>
        <h2>Lista de Usuarios</h2>
        <ul>
          <li v-for="user in users" :key="user.id">
            {{ user.name }} - {{ user.email }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "LoginComponent",
    data: () => ({
      url: process.env.VUE_APP_ROOT_ASSETS,
      email: "",
      password: "",
      users: [],
    }),
    mounted() {
      this.fetchUsers();
    },
    methods: {
      loginUser() {
        axios
          .post("/login", {
            email: this.email,
            password: this.password,
          })
          .then((response) => {
            localStorage.setItem("token", response.data.token);
            localStorage.setItem("user",
                JSON.stringify(response.data.user)
            );
            this.$router.push("/admin/home");
          })
          .catch((error) => {
            console.error("Error al iniciar sesión:", error);
            alert("Credenciales inválidas.");
          });
      },
      fetchUsers() {
        axios
          .get("/users")
          .then((response) => {
            this.users = response.data;
          })
          .catch((error) => {
            console.error("Error al obtener los usuarios:", error);
          });
      },
    },
  };
  </script>
  
  <style>
  .input-field {
    width: 80%;
    padding: 15px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }
  
  .btnInicio {
    margin-top: 20px;
    background-color: black;
    border-radius: 50px;
    width: 270px;
    height: 90px;
    color: aliceblue;
    font-size: 40px;
    text-align: center;
    border: none;
    transition: 0.5s;
  }
  
  .btnInicio:hover {
    align-items: center;
    transform: scale(1.2);
    text-align: center;
    border: 1px solid black;
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