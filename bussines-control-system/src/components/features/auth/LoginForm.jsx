// components/features/auth/LoginForm.jsx
import { useState } from "react";
import Input from "../../common/Input";
import Button from "../../common/Button";
import { useAuth } from "../../../hooks/useAuth";
import { useNavigate } from "react-router-dom";
const LoginForm = () => {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const { handleLogin } = useAuth(); //controlador de inicio de sesión

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    const result = await handleLogin(formData);
    if (result.success) {
      navigate("/home");
    } else {
      setError(result.error);
    }
    setLoading(false);
  };

  return (
    <form onSubmit={handleSubmit}>
      <Input
        label="Email"
        type="email"
        value={formData.email}
        onChange={(e) => setFormData({ ...formData, email: e.target.value })}
        placeholder="correo electrónico"
      />
      <Input
        label="Contraseña"
        type="password"
        value={formData.password}
        onChange={(e) => setFormData({ ...formData, password: e.target.value })}
        placeholder="Ingresa tu contraseña"
      />
      {error && <div className="alert alert-danger">{error}</div>}
      <Button text="Iniciar Sesión" type="submit" loading={loading} />
    </form>
  );
};

export default LoginForm;
