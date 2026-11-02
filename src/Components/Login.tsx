import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import api from '../config/axios';

const Login = () => {
   const navigate = useNavigate() 
 
  const [formData, setFormData] = useState({
    
    nom: '',
    prenom: '',
    email: '',
    role: 'utilisateur' 
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

const handleSubmit = async (e: React.FormEvent) => {
  e.preventDefault(); 
  
  try {
    const response = await api.post('/register', formData);
    console.log('Réponse du serveur :', response.data);
      localStorage.setItem('user', JSON.stringify(response.data.user));
    if (response.data.access_token) {
      localStorage.setItem('token', response.data.access_token);
      
    }
if (response.data.access_token) {
  localStorage.setItem('token', response.data.access_token);
  localStorage.setItem('user', JSON.stringify(response.data.user)); 
  console.log("token",response);
  
}

  
    navigate('/dashboard');
  } catch (error) {
    console.error("L'insertion a échoué :", error);
    alert("Impossible d'enregistrer l'utilisateur.");
  }
};


  return (
    <div className="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <h1 className="text-center text-3xl font-extrabold text-gray-900 tracking-tight">
          Formulaire d'inscription
        </h1>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
          <form onSubmit={handleSubmit} className="space-y-6">
            
            <div>
              <label htmlFor="nom" className="block text-sm font-medium text-gray-700 mb-1">
                Nom
              </label>
              <input 
                type="text" 
                id="nom"
                name="nom" 
                value={formData.nom}
                onChange={handleChange}
                placeholder="Votre nom" 
                required 
                className="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
              />
            </div>

            <div>
              <label htmlFor="prenom" className="block text-sm font-medium text-gray-700 mb-1">
                Prénom
              </label>
              <input 
                type="text" 
                id="prenom"
                name="prenom" 
                value={formData.prenom}
                onChange={handleChange}
                placeholder="Votre prénom" 
                required 
                className="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
              />
            </div>

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
                placeholder="Votre email" 
                required 
                className="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
              />
            </div>

            <div>
              <label htmlFor="role" className="block text-sm font-medium text-gray-700 mb-1">
                Rôle
              </label>
              <select 
                id="role"
                name="role" 
                value={formData.role}
                onChange={handleChange}
                className="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
              >
                <option value="agent">Agent</option>
                <option value="utilisateur">Utilisateur</option>
              </select>
            </div>

            <div>
              <button 
                type="submit"
                className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors mb-3"
              >
                S'inscrire
              </button>
              <Link to ='/Auth'><button 
                type="submit"
                className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
              >
                Se Connecter
              </button></Link>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  );
};

export default Login;
