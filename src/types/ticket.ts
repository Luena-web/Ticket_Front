import type { Utilisateur } from "./utilisateur";

export interface Ticket {
  id: number;
  titre: string;
  description: string;
  statut: 'non resolu' | 'en_cours' | 'resolu'; 
  priorite: 'faible' | 'moyenne' | 'elevee'; 
  created_at: string;
  updated_at: string;
  commentaires :string
}

export interface TicketWithUtilisateur extends Ticket{
  utilisateur_id : number,
}

export type CreateTicketInput = Omit<Ticket, 'id' | 'created_at' | 'updated_at'>;

export type UpdateTicketInput = Partial<CreateTicketInput> & { id: number };
