import React, { useState } from 'react';
import { authService } from '../../../services/authService';
import InputRegister from '../../common/InputRegister';

const RegisterForm = ({ onToggle }) => {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        is_active: true
    });
    const [errors, setErrors] = useState({});
    const [isLoading, setIsLoading] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
        // Limpiar errores al escribir
        if (errors[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: ''
            }));
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setIsLoading(true);
        try {
            const response = await authService.register(formData);
            console.log('Registro exitoso:', response);
            
            // Redirigir o mostrar mensaje de éxito
            if (response.token) {
                window.location.href = '/dashboard';
            }
        } catch (error) {
            console.error('Error en registro:', error);
            if (error.errors) {
                setErrors(error.errors);
            } else {
                setErrors({ 
                    general: error.message || 'Error en el registro' 
                });
            }
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="p-4">
            {errors.general && (
                <div className="alert alert-danger" role="alert">
                    {errors.general}
                </div>
            )}

            <InputRegister
                label="Nombre"
                name="name"
                value={formData.name}
                onChange={handleChange}
                error={errors.name}
                placeholder="Ingrese su nombre"
            />

            <InputRegister
                label="Correo electrónico"
                name="email"
                type="email"
                value={formData.email}
                onChange={handleChange}
                error={errors.email}
                placeholder="Ingrese su correo"
            />

            <InputRegister
                label="Contraseña"
                name="password"
                type="password"
                value={formData.password}
                onChange={handleChange}
                error={errors.password}
                placeholder="Ingrese su contraseña"
            />

            <InputRegister
                label="Confirmar Contraseña"
                name="password_confirmation"
                type="password"
                value={formData.password_confirmation}
                onChange={handleChange}
                error={errors.password_confirmation}
                placeholder="Confirme su contraseña"
            />

            <div className="d-flex justify-content-between mt-4">
                <button 
                    type="submit" 
                    className="btn btn-primary"
                    disabled={isLoading}
                >
                    {isLoading ? 'Registrando...' : 'Registrarse'}
                </button>
                <button 
                    type="button" 
                    onClick={onToggle} 
                    className="btn btn-outline-secondary"
                    disabled={isLoading}
                >
                    Volver
                </button>
            </div>
        </form>
    );
};

export default RegisterForm;