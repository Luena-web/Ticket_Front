export interface Comment {
  id: number;
  message: string;
  ticket_id: number;
  utilisateur_id: number;
  auteur?: {
    id: number;
    nom: string;
    prenom: string;
  };
  created_at: string;
}