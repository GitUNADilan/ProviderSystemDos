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

export default api;