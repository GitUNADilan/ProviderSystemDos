// App.jsx
import { BrowserRouter, Routes, Route} from 'react-router-dom';
import { AuthProvider } from './contexts/AuthContext';
import Login from './pages/Login';
import { Home } from './pages/Home';
import ProductsTable from './pages/ProductsTable';
import PrivateRoute from './components/common/PrivateRoute';

function App() {
  return (
    <AuthProvider>
      <BrowserRouter>
        <Routes>
          {/* Rutas pública */}
          <Route path="/" element={<Login />} />
          
          {/* Rutas privadas */}
          <Route 
            path="/home" 
            element={
              <PrivateRoute>
                <Home />
              </PrivateRoute>
            }
          />
          <Route 
            path="/ProductsTable" 
            element={
              <PrivateRoute>
                <ProductsTable />
              </PrivateRoute>
            }
          />
        </Routes>
      </BrowserRouter>
    </AuthProvider>
  );
}

export default App;