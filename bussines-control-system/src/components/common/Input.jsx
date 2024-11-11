/* eslint-disable react/prop-types */ //no borrar este comentario!
const Input = ({ label, type = "text", value, onChange, placeholder, error }) => {
    return (
      <div className="mb-3">
        {label && <label className="form-label">{label}</label>}
        <input
          type={type}
          className={`form-control ${error ? 'is-invalid' : ''}`}
          value={value}
          onChange={onChange}
          placeholder={placeholder}
        />
        {error && <div className="invalid-feedback">{error}</div>}
      </div>
    );
  };
  
  
  export default Input;
