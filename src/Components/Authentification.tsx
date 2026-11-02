import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom'; 
import api from '../config/axios';

const Authentification = () => {
  const navigate = useNavigate(); 
 
  const [formData, setFormData] = useState({
    email: '',
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault(); 
    
    try {
      const response = await api.post('/login', formData);
     // console.log('Réponse du serveur :', response.data);

      if (response.data.access_token) {
        localStorage.setItem('token', response.data.access_token);
      }
      
      navigate('/dashboard');
    } catch (error) {
      console.error("La connexion a échoué :", error);
      alert("Email introuvable ou incorrect.");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <h1 className="text-center text-3xl font-extrabold text-gray-900 tracking-tight">
          Connexion
        </h1>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
          <form onSubmit={handleSubmit} className="space-y-6">
 
            <div>
              <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">
                 Email
              </label>
              <input 
                type="email" 
                id="email"
                name="email" 
                value={formData.email}
                onChange={handleChange}
                placeholder="Ex: agent@support.com" 
                required 
                className="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors"
              />
            </div>

            <div>
              <button 
                type="submit"
                className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
              >
                Se connecter
              </button>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  );
};

export default Authentification;
