
import api from "../config/axios";
import  type { Comment} from '../types/comment'


export const getComments = async (
  ticketId: number
): Promise<Comment[]> => {
  const response = await api.get<{
    success: boolean;
    data: Comment[];
  }>(`/tickets/${ticketId}/commentaires`);

  return response.data.data;
};

export const createComment = async (
  contenu: string,
  ticketId: number,
  utilisateurId: number
) => {
  const response = await api.post(
    `/tickets/${ticketId}/commentaires`,
    {
      message: contenu,
      utilisateur_id: utilisateurId,
    }
  );

  return response.data;
};
