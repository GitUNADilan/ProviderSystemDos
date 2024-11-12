// pages/Login.jsx
import React, { useState } from 'react';
import LoginForm from '../components/features/auth/LoginForm';
import RegisterForm from '../components/features/auth/RegisterForm';
import RegisterButton from '../components/common/RegisterButton';

const Login= () => {
  const [isRegistering, setIsRegistering] = useState(false);

  const toggleForm = () => {
    setIsRegistering(!isRegistering);
  };

  return (
    <div className="container mt-5 d-flex justify-content-center">
      <div className={`card shadow col-lg-4 col-sm-4 col-md-4 position-relative overflow-hidden`}>
        <div className={`card-body p-5 transition-transform duration-500 transform ${
          isRegistering ? '-translate-x-full' : 'translate-x-0'
        }`}>
          <div className="d-flex justify-content-between align-items-center mb-4">
            <h2 className="text-center mb-0">
              {isRegistering ? 'Registro' : 'Iniciar Sesión'}
            </h2>
            <RegisterButton 
              onClick={toggleForm}
              isRegistering={isRegistering}
            />
          </div>
          
          <div className={`transition-opacity duration-300 ${
            isRegistering ? 'opacity-0' : 'opacity-100'
          }`}>
            {!isRegistering && <LoginForm />}
          </div>
          
          <div className={`absolute top-0 left-full w-full h-full transition-transform duration-500 transform ${
            isRegistering ? '-translate-x-full' : 'translate-x-0'
          }`}>
            {isRegistering && <RegisterForm onToggle={toggleForm} />}
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;