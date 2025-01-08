import React, { useState } from 'react';

const Sidebar = () => {
  const [isOpen, setIsOpen] = useState(false);

  return (
    <>
      <div className={`sidebar ${isOpen ? 'open' : ''}`}>
        <div className="sidebar-header">
          <h2>Admin</h2>
        </div>
        <nav className="sidebar-nav">
          <ul>
            <li><a href="/ProductsTable ">Productos</a></li>
            <li><a href="/">Proveedores</a></li>
            <li><a href="/">Distribuidores</a></li>
            <li><a href="/">Ventas</a></li>
            <li><a href="/">Compras</a></li>
            <li><a href="/">Login</a></li>
            <li><a href="/Empleados">Empleados</a></li>
          </ul>
        </nav>
      </div>

      <button className="menu-button" onClick={() => setIsOpen(!isOpen)}>
        {isOpen ? '✕' : '☰'}
      </button>

      <div className={`content ${isOpen ? 'shifted' : ''}`}>
        {/* Aquí va el contenido de la página */}
      </div>

      {isOpen && (
        <div className="overlay" onClick={() => setIsOpen(false)} />
      )}
    </>
  );
};

export default Sidebar;