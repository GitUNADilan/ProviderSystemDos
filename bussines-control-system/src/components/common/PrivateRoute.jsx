import { useAuth } from '../../hooks/useAuth';
import { Navigate, useLocation } from 'react-router-dom';
// Componente para proteger rutas
// eslint-disable-next-line react/prop-types
const PrivateRoute = ({ children }) => {
  const { user } = useAuth();
  const location = useLocation();
  return user ? children : <Navigate to="/" state={{ from: location }} replace />;
};

export default PrivateRoute;