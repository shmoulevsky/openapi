import axios from "axios";

let axiosInstance = axios.create({
    baseURL: "/api",
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
    },
});





export default axiosInstance;
