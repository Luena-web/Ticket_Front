
import React, { useState, useEffect } from "react";
import type { Ticket } from "../types/ticket";
import { Link } from "react-router-dom";
import { getTicket } from "../services/TicketService";
import {
  getComments,
  createComment,
} from "../services/CommentService";
import type { Comment } from "../types/comment";
import axios from "axios";

const Dashboard = () => {
  // Liste des tickets
  const [tickets, setTickets] = useState<Ticket[]>([]);

  // Ticket actuellement sélectionné
  const [selectedTicket, setSelectedTicket] =
    useState<Ticket | null>(null);

  // Liste des commentaires du ticket sélectionné
  const [comments, setComments] = useState<Comment[]>([]);

  // Contenu du nouveau commentaire
  const [newComment, setNewComment] = useState("");

  // Utilisateur connecté
  const [currentUser, setCurrentUser] = useState<{
    id: number;
    nom: string;
    prenom: string;
  } | null>(null);

  // État de chargement des commentaires
  const [loadingComments, setLoadingComments] = useState(false);

  // Récupération de l'utilisateur et des tickets
  useEffect(() => {
    const storedUser = localStorage.getItem("user");

    if (storedUser) {
      try {
        setCurrentUser(JSON.parse(storedUser));
      } catch (error) {
        console.error(
          "Erreur lors de la lecture de l'utilisateur :",
          error
        );
      }
    }

    const fetchTickets = async () => {
      try {
        const data = await getTicket();

        setTickets(data);

        if (data.length > 0) {
          setSelectedTicket(data[0]);
        }
      } catch (error) {
        console.error(
          "Erreur lors de la récupération des tickets :",
          error
        );
      }
    };

    fetchTickets();
  }, []);

  // Récupération des commentaires du ticket sélectionné
  useEffect(() => {
    if (!selectedTicket) {
      setComments([]);
      return;
    }

    let cancelled = false;

    const fetchComments = async () => {
      setLoadingComments(true);
      setComments([]);

      try {
        const data = await getComments(selectedTicket.id);

        if (!cancelled) {
          setComments(data);
        }
      } catch (error) {
        if (!cancelled) {
          console.error(
            "Erreur lors de la récupération des commentaires :",
            error
          );
          setComments([]);
        }
      } finally {
        if (!cancelled) {
          setLoadingComments(false);
        }
      }
    };

    fetchComments();

    return () => {
      cancelled = true;
    };
  }, [selectedTicket?.id]);

  // Ajouter un commentaire
  const handleAddComment = async (
    e: React.FormEvent<HTMLFormElement>
  ) => {
    e.preventDefault();

    if (!newComment.trim() || !selectedTicket) {
      return;
    }

    if (!currentUser) {
      alert("Impossible d'identifier l'utilisateur connecté.");
      return;
    }

    try {
      const response = await createComment(
        newComment.trim(),
        selectedTicket.id,
        currentUser.id
      );

      console.log("Réponse de Laravel :", response);

      if (response.success) {
        // Recharger les commentaires depuis l'API
        const data = await getComments(selectedTicket.id);

        setComments(data);
        setNewComment("");
      }
    } catch (error) {
      if (axios.isAxiosError(error)) {
        console.error("Statut HTTP :", error.response?.status);
        console.error(
          "Erreur Laravel :",
          error.response?.data
        );

        alert(
          error.response?.data?.message ??
            "Impossible d'envoyer le commentaire."
        );
      } else {
        console.error("Erreur inattendue :", error);
        alert("Une erreur inattendue est survenue.");
      }
    }
  };

  // Badge de priorité
  const getPriorityBadge = (prio?: string) => {
    if (!prio) return null;

    const classes =
      prio === "haute"
        ? "bg-red-100 text-red-800"
        : "bg-yellow-100 text-yellow-800";

    return (
      <span
        className={`px-2.5 py-0.5 rounded-full text-xs font-medium ${classes}`}
      >
        {prio}
      </span>
    );
  };

  return (
    <div className="min-h-screen bg-gray-100 flex flex-col">
      {/* En-tête */}
      <header className="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h1 className="text-xl font-bold text-gray-900">
          Support Assistance
        </h1>

        <div className="flex items-center space-x-4">
          <span className="text-sm text-gray-600">
            Bienvenue{" "}
            <strong className="text-gray-900">
              {currentUser
                ? currentUser.prenom
                : "Collaborateur"}
            </strong>
          </span>

          <Link
            to="/ticket"
            className="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700 transition-colors"
          >
            Nouveau Ticket
          </Link>
        </div>
      </header>

      <div className="flex-1 flex overflow-hidden">
        {/* Liste des tickets */}
        <aside className="w-1/3 bg-white border-r border-gray-200 overflow-y-auto">
          <div className="p-4 border-b border-gray-200">
            <h2 className="font-semibold text-gray-700">
              Mes Tickets ({tickets.length})
            </h2>
          </div>

          <div className="divide-y divide-gray-100">
            {tickets.map((ticket) => (
              <button
                key={ticket.id}
                onClick={() => setSelectedTicket(ticket)}
                className={`w-full text-left p-4 hover:bg-gray-50 flex flex-col space-y-2 transition-colors ${
                  selectedTicket?.id === ticket.id
                    ? "bg-indigo-50/50 border-l-4 border-indigo-600 pl-3"
                    : ""
                }`}
              >
                <div className="flex justify-between items-start">
                  <span className="font-medium text-gray-900 truncate pr-2">
                    {ticket.titre}
                  </span>

                  {getPriorityBadge(ticket.priorite)}
                </div>

                <p className="text-sm text-gray-500 line-clamp-2">
                  {ticket.description}
                </p>

                <span className="text-xs text-gray-400">
                  {ticket.created_at}
                </span>
              </button>
            ))}
          </div>
        </aside>

        {/* Détails du ticket et discussion */}
        <main className="flex-1 bg-gray-50 p-6 overflow-y-auto flex flex-col space-y-6">
          {selectedTicket ? (
            <>
              {/* Détails du ticket */}
              <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-4">
                <div className="flex justify-between items-center border-b border-gray-100 pb-4">
                  <div>
                    <span className="text-xs font-semibold text-indigo-600 tracking-wider uppercase">
                      Ticket #{selectedTicket.id}
                    </span>

                    <h2 className="text-2xl font-bold text-gray-900 mt-1">
                      {selectedTicket.titre}
                    </h2>
                  </div>

                  <div className="flex space-x-2">
                    {getPriorityBadge(selectedTicket.priorite)}

                    <span className="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                      {selectedTicket.statut?.replace("_", " ")}
                    </span>
                  </div>
                </div>

                <p className="text-gray-700 leading-relaxed whitespace-pre-wrap">
                  {selectedTicket.description}
                </p>
              </div>

              {/* Discussion */}
              <div className="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
                <h3 className="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">
                  Discussion ({comments.length})
                </h3>

                {/* Liste des commentaires */}
                <div className="space-y-4">
                  {loadingComments ? (
                    <p className="text-sm text-gray-500">
                      Chargement des commentaires...
                    </p>
                  ) : comments.length > 0 ? (
                    comments.map((com) => (
                      <div
                        key={com.id}
                        className="bg-gray-50 rounded-lg p-4 border border-gray-100"
                      >
                        <div className="flex justify-between items-center mb-1">
                          <span className="font-semibold text-sm text-gray-900">
                            {com.auteur
                              ? `${com.auteur.prenom} ${com.auteur.nom}`
                              : "Utilisateur"}
                          </span>

                          <span className="text-xs text-gray-400">
                            {com.created_at
                              ? new Date(
                                  com.created_at
                                ).toLocaleString("fr-FR")
                              : ""}
                          </span>
                        </div>

                        <p className="text-sm text-gray-700 whitespace-pre-wrap">
                          {com.message}
                        </p>
                      </div>
                    ))
                  ) : (
                    <p className="text-sm text-gray-500">
                      Aucun commentaire pour ce ticket.
                    </p>
                  )}
                </div>

                {/* Formulaire d'ajout */}
                <form
                  onSubmit={handleAddComment}
                  className="mt-4 pt-4 border-t border-gray-100"
                >
                  <textarea
                    rows={3}
                    value={newComment}
                    onChange={(e) =>
                      setNewComment(e.target.value)
                    }
                    placeholder="Écrire une réponse..."
                    className="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required
                  />

                  <div className="flex justify-end mt-2">
                    <button
                      type="submit"
                      disabled={
                        !newComment.trim() || loadingComments
                      }
                      className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    >
                      Envoyer le message
                    </button>
                  </div>
                </form>
              </div>
            </>
          ) : (
            <div className="flex-1 flex items-center justify-center text-gray-400 bg-white rounded-lg border border-dashed border-gray-300">
              Aucun ticket sélectionné ou disponible
            </div>
          )}
        </main>
      </div>
    </div>
  );
};

export default Dashboard;
