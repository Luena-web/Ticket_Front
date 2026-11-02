import React from 'react'
import  type {CreateTicketInput, Ticket} from '../types/ticket';
import api from '../config/axios'



 export async function  getTicket(): Promise <Ticket[]>{
  const result = await api.get<{data:Ticket[]}> ("/tickets");
  return result.data.data;
  console.log('resultat', result);
  
 }
  
//  export async function createTicket(
//   task: Omit<Ticket, "id">
// ): Promise<Ticket> {
//   const result = await api.post<Ticket>("/tickets", task);

//   return result.data;
// }

export const createTicket = async (ticketData: CreateTicketInput, tokenSecours?: string) => {
  
  const token = tokenSecours || localStorage.getItem('token');

  const response = await api.post('/tickets', ticketData, {
    headers: {
      Authorization: `Bearer ${token}`, 
      Accept: 'application/json',
    },
  });
  
  return response.data;
};


export async function getTicketById(id: number): Promise<Ticket> {
  const result = await api.get< Ticket >(`/ticket/${id}`);
  return result.data;
 
  
}

export async function deleteTicket(id: number): Promise<void> {
  await api.delete("/ticket/" + id   );
}


