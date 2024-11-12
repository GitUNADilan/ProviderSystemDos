// components/common/InputRegister.jsx
const InputRegister = ({ 
    label, 
    name, 
    type = 'text', 
    value, 
    onChange, 
    error,
    placeholder 
  }) => {
    return (
      <div className="form-group mb-3">
        <label htmlFor={name} className="form-label">
          {label}
        </label>
        <input
          type={type}
          className={`form-control ${error ? 'is-invalid' : ''}`}
          id={name}
          name={name}
          value={value}
          onChange={onChange}
          placeholder={placeholder}
        />
        {error && <div className="invalid-feedback">{error}</div>}
      </div>
    );
  };

  export default InputRegister;  