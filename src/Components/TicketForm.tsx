import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createTicket } from '../services/TicketService';
import type { CreateTicketInput } from '../types/ticket';

const TicketForm = () => {
  const navigate = useNavigate();

  const [formData, setFormData] = useState<CreateTicketInput>({
    titre: '',
    description: '',
    priorite: 'moyenne',
    statut: 'non resolu',
    commentaires:''
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      // 1. CORRECTION : On appelle la fonction du service qui cible '/tickets' (et pas '/register')
      const response = await createTicket(formData);
      console.log('Ticket créé avec succès !', response);

      // 2. Redirection vers le tableau de bord une fois le ticket enregistré
      navigate('/dashboard');
    } catch (error: any) {
      console.error("L'envoi a échoué :", error);
      alert("Impossible de créer le ticket. Vérifie que tu es bien connecté.");
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <h1 className="text-center text-3xl font-extrabold text-gray-900">Créer un ticket</h1>
      </div>
      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label htmlFor="titre" className="block text-sm font-medium text-gray-700">Titre</label>
              <input type="text" id="titre" name="titre" value={formData.titre} onChange={handleChange} required className="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm" />
            </div>
            <div>
              <label htmlFor="description" className="block text-sm font-medium text-gray-700">Description</label>
              <textarea id="description" name="description" value={formData.description} onChange={handleChange} required className="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm" />
            </div>
            <div>
              <label htmlFor="priorite" className="block text-sm font-medium text-gray-700">Priorité</label>
              <select id="priorite" name="priorite" value={formData.priorite} onChange={handleChange} className="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm">
                <option value="faible">Faible</option>
                <option value="moyenne">Moyenne</option>
                <option value="elevee">Élevée</option>
              </select>
            </div>
            <button type="submit" className="w-full flex justify-center py-2 px-4 border text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">
              Créer le ticket
            </button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default TicketForm;
