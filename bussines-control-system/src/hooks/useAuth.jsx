// hooks/useAuth.js
import { useContext } from 'react';
import { AuthContext } from '../contexts/AuthContext';
import { authService } from '../services/authService';

export const useAuth = () => {
  const context = useContext(AuthContext);

  const handleLogin = async (credentials) => {
    try {
      const data = await authService.login(credentials);
      context.login(data); // actualizo el contexto los datos del usuario
      return { success: true };
    } catch (error) {
      return { success: false, error: error.message };
    }
  };

  /* el ...context es equivalente a retornar todo el contenido del contexto 
  es decir
  user: context.user,
  login: context.login,
  logout: context.logout,
  */
  return {
    ...context,
    handleLogin,
  };
};