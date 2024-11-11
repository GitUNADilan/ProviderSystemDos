/* eslint-disable react/prop-types */
// components/common/Button.jsx
const Button = ({ text, type = "button", loading = false, onClick, className = "btn-primary" }) => {
    return (
      <button
        type={type}
        className={`btn ${className} w-100`}
        onClick={onClick}
        disabled={loading}
      >
        {loading ? (
          <span className="spinner-border spinner-border-sm me-2" />
        ) : null}
        {text}
      </button>
    );
  };
  
  export default Button;