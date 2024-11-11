// pages/Login.jsx
import LoginForm from '../components/features/auth/LoginForm';

const LoginPage = () => {
  return (
    <div className="card shadow col-lg-4 col-sm-4 col-md-4">
        <div className="card-body p-5">
            <h2 className="text-center mb-4">Iniciar Sesión</h2>
            <LoginForm />
        </div>
    </div>
  );
};

export default LoginPage;