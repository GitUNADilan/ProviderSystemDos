// services/authService.js
import api from '../services/api';

const login = async (credentials) => {
  try {
    console.log('llego al service');
    // 1. Obtener CSRF cookie - necesario para Sanctum
    await api.get('/sanctum/csrf-cookie');
    
    // 2. Hacer login
    console.log(credentials);
    const response = await api.post('/api/login', credentials);
    
    // 3. Guardar token si tu backend lo devuelve
    if (response.data.token) {
      localStorage.setItem('token', response.data.token);
      api.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
    }

    return response.data;
  } catch (error) {
    console.log(error);
    throw new Error(
      error.response?.data?.message || 'Error en el inicio de sesión'
    );
  }
};

const register = async (userData) => {
  try {
      // 1. Obtener CSRF cookie
      await api.get('/sanctum/csrf-cookie');
      
      // 2. Registrar usuario
      const response = await api.post('/api/users/add', userData);
      
      // 3. Guardar token si el backend lo devuelve
      if (response.data.token) {
          localStorage.setItem('token', response.data.token);
          api.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
      }

      return response.data;
  } catch (error) {
      console.error('Error en registro:', error);
      // Manejar diferentes tipos de errores
      if (error.response?.data?.errors) {
          throw { errors: error.response.data.errors };
      }
      throw new Error(
          error.response?.data?.message || 'Error en el registro'
      );
  }
};


const logout = async () => {
  try {
    await api.post('/api/logout');
    localStorage.removeItem('token');
    delete api.defaults.headers.common['Authorization'];
  } catch (error) {
    console.error('Error en logout:', error);
  }
};

// Función para verificar si el usuario está autenticado
const isAuthenticated = () => {
  return !!localStorage.getItem('token');
};

export const authService = {
  login,
  logout,
  register,
  isAuthenticated
};