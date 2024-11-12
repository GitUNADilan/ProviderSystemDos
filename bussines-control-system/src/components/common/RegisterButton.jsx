// components/common/RegisterButton.jsx
import React from 'react';

const RegisterButton = ({ onClick, isRegistering }) => {
  return (
    <button
      onClick={onClick}
      className="btn btn-outline-primary mx-2"
      type="button"
    >
      {isRegistering ? 'Volver' : 'Registrarse'}
    </button>
  );
};

export default RegisterButton;