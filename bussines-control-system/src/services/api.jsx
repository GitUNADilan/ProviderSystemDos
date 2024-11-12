// services/api.js
import axios from 'axios';

const api = axios.create({
    baseURL: '/', 
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true,
});
// Interceptor para agregar el token a todas las peticiones
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);
export default api;