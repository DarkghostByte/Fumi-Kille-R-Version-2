import axios from "axios";

const API_URL = process.env.VUE_APP_ROOT_API

class AuthService{
    login(user){
        return axios.post(API_URL+'login')
    }
}