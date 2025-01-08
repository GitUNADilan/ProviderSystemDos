import React, { useState } from 'react';
import '../assets/css/ProductsTable.css';
import Sidebar from "../components/Sidebar";

const ProductsTable = () => {
  const [products, setProducts] = useState([
    { 
      id: 1, 
      name: 'Producto 1', 
      description: 'Descripción 1',
      sale_price: 100.00,
      stock: 50,
      status: 1
    },
    { 
      id: 2, 
      name: 'Producto 2', 
      description: 'Descripción 2',
      sale_price: 150.00,
      stock: 30,
      status: 1
    },
  ]);

  const [isEditing, setIsEditing] = useState(null);
  const [editForm, setEditForm] = useState({
    name: '',
    description: '',
    sale_price: 0,
    stock: 0,
    status: 1
  });

  const [searchTerm, setSearchTerm] = useState('');

  const handleEdit = (product) => {
    setIsEditing(product.id);
    setEditForm(product);
  };

  const handleDelete = (id) => {
    if (window.confirm('¿Está seguro de eliminar este producto?')) {
      setProducts(products.filter(product => product.id !== id));
    }
  };

  const handleSave = () => {
    setProducts(products.map(product =>
      product.id === isEditing ? editForm : product
    ));
    setIsEditing(null);
  };

  const handleAdd = () => {
    const newProduct = {
      id: products.length + 1,
      ...editForm
    };
    setProducts([...products, newProduct]);
    setEditForm({
      name: '',
      description: '',
      sale_price: 0,
      stock: 0,
      status: 1
    });
    setIsEditing(null);
  };

  const exportToCSV = () => {
    const csvContent = "data:text/csv;charset=utf-8," 
      + "Name,Description,Price,Stock,Status\n"
      + products.map(product => 
          `${product.name},${product.description},${product.sale_price},${product.stock},${product.status}`
        ).join("\n");
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "productos.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  };

  const filteredProducts = products.filter(product =>
    product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    product.description.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="products-container">
        <Sidebar />
      <div className="controls">
        <input
          type="text"
          placeholder="Buscar productos..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
          className="search-input"
        />
        <div className="buttons">
          <button onClick={() => setIsEditing('new')} className="btn btn-add">
            Nuevo Producto
          </button>
          <button onClick={exportToCSV} className="btn btn-export">
            Exportar CSV
          </button>
        </div>
      </div>

      <table className="products-table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {isEditing === 'new' && (
            <tr>
              <td>
                <input
                  type="text"
                  value={editForm.name}
                  onChange={e => setEditForm({...editForm, name: e.target.value})}
                />
              </td>
              <td>
                <input
                  type="text"
                  value={editForm.description}
                  onChange={e => setEditForm({...editForm, description: e.target.value})}
                />
              </td>
              <td>
                <input
                  type="number"
                  value={editForm.sale_price}
                  onChange={e => setEditForm({...editForm, sale_price: parseFloat(e.target.value)})}
                />
              </td>
              <td>
                <input
                  type="number"
                  value={editForm.stock}
                  onChange={e => setEditForm({...editForm, stock: parseInt(e.target.value)})}
                />
              </td>
              <td>
                <select
                  value={editForm.status}
                  onChange={e => setEditForm({...editForm, status: parseInt(e.target.value)})}
                >
                  <option value={1}>Activo</option>
                  <option value={0}>Inactivo</option>
                </select>
              </td>
              <td>
                <button onClick={handleAdd} className="btn btn-save">Guardar</button>
              </td>
            </tr>
          )}
          {filteredProducts.map(product => (
            <tr key={product.id}>
              <td>
                {isEditing === product.id ? (
                  <input
                    type="text"
                    value={editForm.name}
                    onChange={e => setEditForm({...editForm, name: e.target.value})}
                  />
                ) : product.name}
              </td>
              <td>
                {isEditing === product.id ? (
                  <input
                    type="text"
                    value={editForm.description}
                    onChange={e => setEditForm({...editForm, description: e.target.value})}
                  />
                ) : product.description}
              </td>
              <td>
                {isEditing === product.id ? (
                  <input
                    type="number"
                    value={editForm.sale_price}
                    onChange={e => setEditForm({...editForm, sale_price: parseFloat(e.target.value)})}
                  />
                ) : `$${product.sale_price.toFixed(2)}`}
              </td>
              <td>
                {isEditing === product.id ? (
                  <input
                    type="number"
                    value={editForm.stock}
                    onChange={e => setEditForm({...editForm, stock: parseInt(e.target.value)})}
                  />
                ) : product.stock}
              </td>
              <td>
                {isEditing === product.id ? (
                  <select
                    value={editForm.status}
                    onChange={e => setEditForm({...editForm, status: parseInt(e.target.value)})}
                  >
                    <option value={1}>Activo</option>
                    <option value={0}>Inactivo</option>
                  </select>
                ) : (
                  <span className={`status ${product.status === 1 ? 'active' : 'inactive'}`}>
                    {product.status === 1 ? 'Activo' : 'Inactivo'}
                  </span>
                )}
              </td>
              <td>
                {isEditing === product.id ? (
                  <button onClick={handleSave} className="btn btn-save">Guardar</button>
                ) : (
                  <div className="action-buttons">
                    <button onClick={() => handleEdit(product)} className="btn btn-edit">Editar</button>
                    <button onClick={() => handleDelete(product.id)} className="btn btn-delete">Eliminar</button>
                  </div>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ProductsTable;