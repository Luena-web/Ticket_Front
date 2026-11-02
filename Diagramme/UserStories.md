
## 1. Présentation du projet

L’application permet aux collaborateurs d’une organisation de signaler un problème informatique ou de demander une assistance, puis de suivre le traitement de leur demande.

Les demandes sont enregistrées sous forme de **tickets**. Chaque ticket contient notamment un titre, une description, une priorité, un statut, son créateur ainsi que ses dates de création et de mise à jour. Les échanges entre le collaborateur et le support sont conservés dans des commentaires associés au ticket.

## 2. Acteurs de l’application
 Acteur et Rôle 

 **Collaborateur** :  Crée des tickets, consulte ses demandes et ajoute des commentaires. 
 **Technicien support**  Dés que le tchnicien clique sur un ticket , le staut du ticket passe automatique à resolu . Il consulte les tickets à traiter, met à jour leur statut et leur priorité, et échange avec les collaborateurs. 
 
**Hypothèse de périmètre :** les collaborateurs  voient  leurs propres tickets et tous les tickets crées par les autres collaborateurs.
## 3. User stories

### Épic 1 — Accès à l’application

**US-01 — Se connecter**

En tant qu’utilisateur, je veux me connecter à l’application afin d’accéder aux fonctionnalités correspondant à mon rôle.

Critères d’acceptation :
- L’utilisateur peut saisir son adresse e-mail ou son identifiant et son mot de passe.
- Si les informations sont correctes, il accède à l’application.
- Si les informations sont incorrectes, un message d’erreur explicite s’affiche.
- Un utilisateur non connecté ne peut pas accéder aux pages protégées.

**US-02 — Se déconnecter**

En tant qu’utilisateur connecté, je veux me déconnecter afin de sécuriser mon compte lorsque je quitte l’application.

Critères d’acceptation :
- Une action de déconnexion est accessible depuis l’interface.
- Après la déconnexion, l’utilisateur est redirigé vers la page de connexion.
- Une session déconnectée ne permet plus d’accéder aux pages protégées.

**US-03 — Consulter mon profil**

En tant qu’utilisateur connecté, je veux consulter mes informations de profil afin de vérifier les informations associées à mon compte.

Critères d’acceptation :
- L’utilisateur peut consulter au minimum son nom, son adresse e-mail.
- Les informations affichées correspondent à son compte.

### Épic 2 — Création et gestion des tickets

**US-04 — Créer un ticket**

En tant que collaborateur, je veux créer un ticket en décrivant mon problème informatique ou mon besoin d’assistance afin de solliciter le support.

Critères d’acceptation :
- Le formulaire contient un titre et une description.
- Le titre et la description sont obligatoires.
- Le ticket est associé automatiquement à l’utilisateur connecté.
- La priorité reçoit une valeur par défaut si le collaborateur ne la choisit pas.
- Le statut initial est défini automatiquement à « non resolu ».
- La date de création est enregistrée automatiquement.
- Après l’enregistrement, un message confirme la création du ticket et celui-ci possède un identifiant unique.

**US-05 — Consulter mes tickets**

En tant que collaborateur, je veux consulter la liste de mes tickets afin de retrouver facilement mes demandes d’assistance.

Critères d’acceptation :
- La liste affiche uniquement les tickets créés par les utilisateurs connectés.
- Chaque ticket présente au minimum  son titre, sa priorité, son statut et sa date de création.
- Les tickets sont affichés du plus récent au plus ancien.

**US-06 — Consulter le détail d’un ticket**

En tant que collaborateur, je veux consulter le détail d’un de mes tickets afin de comprendre son état et de retrouver les informations de ma demande.

Critères d’acceptation :
- Le détail présente le titre, la description, la priorité, le statut, le créateur et les dates de suivi.
- Les commentaires associés au ticket sont visibles.

**US-07 — Modifier un ticket**

En tant que collaborateur, je veux modifier les informations de mon ticket tant qu’il n’a pas commencé à être traité afin de corriger une erreur ou de préciser ma demande.

Critères d’acceptation :
- Le collaborateur peut modifier le titre et la description de son ticket.
- La modification est autorisée uniquement lorsque le ticket est encore au statut « non resolu ».
- Les champs obligatoires sont de nouveau validés.
- La date de mise à jour est actualisée après l’enregistrement.

**US-08 — Annuler un ticket**

En tant que collaborateur, je veux pouvoir annuler une demande qui n’est plus nécessaire afin d’éviter son traitement inutile.

Critères d’acceptation :
- Le collaborateur peut annuler uniquement un ticket qui n’a pas encore été pris en charge.
- Une confirmation est demandée avant l’annulation.
- Un ticket déjà en cours de traitement ou résolu ne peut pas être annulé par cette action.

### Épic 3 — Recherche et suivi des tickets

**US-09 — Rechercher un ticket**

En tant qu’utilisateur, je veux rechercher un ticket à partir de son numéro ou de son titre afin de le retrouver rapidement.

Critères d’acceptation :
- Un champ de recherche est disponible.
- La recherche peut être effectuée à partir du numéro ou d'une partie du titre.
- Les résultats respectent les droits d’accès de l’utilisateur.
- Un message est affiché lorsqu’aucun résultat ne correspond à la recherche.

**US-10 — Filtrer les tickets**

En tant qu’utilisateur, je veux filtrer les tickets selon leur statut ou leur priorité afin de consulter plus facilement les demandes qui m’intéressent.

Critères d’acceptation :
- L’utilisateur peut filtrer les tickets par statut.
- L’utilisateur peut filtrer les tickets par priorité.

**US-11 — Suivre l’avancement d’un ticket**

En tant que collaborateur, je veux connaître le statut actuel de mon ticket afin de savoir où en est le traitement de ma demande.

Critères d’acceptation :
- Le statut est clairement visible dans la liste et dans le détail du ticket.
- Les statuts possibles sont : « non resolu », « En cours », « Résolu ».
- Le collaborateur peut consulter la date de dernière mise à jour.
- Le collaborateur ne peut pas modifier directement le statut de traitement.

### Épic 4 — Traitement des tickets par le support

**US-12 — Consulter tous les tickets**

En tant que technicien support, je veux consulter les tickets de tous les collaborateurs afin d’identifier les demandes à traiter.

Critères d’acceptation :
- Le technicien peut consulter les tickets de tous les collaborateurs.
- Chaque ligne présente le numéro, le titre, le créateur, la priorité, le statut et la date de création.
- Les tickets les plus récents sont affichés en premier.
- Le technicien peut accéder au détail de chaque ticket.

**US-13 — Prendre en charge un ticket**

En tant que technicien support, je veux prendre en charge un ticket afin d’indiquer que son traitement a commencé.

Critères d’acceptation :
- Le technicien peut faire passer un ticket de « en cours » à « resolu ».
- La date de mise à jour est actualisée.
- Le nouveau statut est visible par le collaborateur.

**US-14 — Modifier la priorité d’un ticket**

En tant que technicien support, je veux modifier la priorité d’un ticket afin de tenir compte de son urgence et de son impact.

Critères d’acceptation :
- Les niveaux de priorité disponibles sont « Faible », « Moyenne », « Elevee ».
- Le technicien peut modifier la priorité d’un ticket.
- La date de mise à jour est actualisée après la modification.



**US-16 — Résoudre un ticket**

En tant que technicien support, je veux marquer un ticket comme résolu lorsque le problème est réglé afin d’informer le collaborateur de la fin du traitement.

Critères d’acceptation :
- Le technicien peut passer un ticket au statut « Résolu ».
- Il peut ajouter un commentaire décrivant la solution apportée.
- La date de résolution est enregistrée.
- Le collaborateur peut consulter la résolution dans le détail du ticket.

**US-17 — Consulter les tickets par statut**

En tant que technicien support, je veux filtrer les tickets par statut afin de prioriser mon travail et de repérer les demandes non traitées.

Critères d’acceptation :
- Il peut combiner le filtre de statut avec une recherche ou un filtre de priorité.
- Les résultats correspondent aux critères sélectionnés.

### Épic 5 — Commentaires et échanges

**US-18 — Ajouter un commentaire**

En tant qu’utilisateur autorisé à consulter un ticket, je veux ajouter un commentaire afin de communiquer une précision ou une information utile au traitement de la demande.

Critères d’acceptation :
- Un champ permet de saisir un commentaire.
- Le commentaire ne peut pas être vide.
- Le commentaire est associé au ticket et à son auteur.
- La date et l’heure de publication sont enregistrées automatiquement.
- Le commentaire apparaît dans l’historique du ticket.

**US-19 — Consulter les commentaires**

En tant qu’utilisateur autorisé à consulter un ticket, je veux lire les commentaires associés afin de suivre les échanges entre collaborateurs ou entre collaborateur et le support.

Critères d’acceptation :
- Les commentaires sont affichés dans l’ordre chronologique.
- Chaque commentaire indique son auteur, son contenu et sa date de publication.
- Seuls les utilisateurs autorisés à consulter le ticket peuvent lire ses commentaires.

### Épic 6 — Administration (Technicien support) des utilisateurs

**US-20 — Consulter les utilisateurs**

En tant qu’administrateur, je veux consulter la liste des utilisateurs afin de connaître les personnes ayant accès à l’application.

Critères d’acceptation :
- L’administrateur peut consulter la liste des utilisateurs.
- Chaque utilisateur présente son nom, son adresse e-mail et son rôle.
- Un utilisateur non administrateur ne peut pas accéder à cette fonctionnalité.

**US-21 — Gérer les rôles des utilisateurs**

En tant qu’administrateur, je veux attribuer ou modifier le rôle d’un utilisateur afin de contrôler les fonctionnalités auxquelles il peut accéder.

Critères d’acceptation :
- L’administrateur peut attribuer le rôle « Collaborateur », « Technicien support ».
- Les autorisations de l’utilisateur correspondent à son rôle.
- Seul un administrateur peut effectuer cette opération.

## 4. Règles de gestion

 Identifiant  Chaque ticket possède un identifiant unique généré automatiquement. 
 Créateur : Le créateur est automatiquement l’utilisateur connecté. 
Titre  : Obligatoire, avec une longueur maximale définie par l’application. 
Description : Obligatoire à la création. 
 Priorité  Faible, Moyenne, Elevee. 
 Statut initial  Non resolu.
| Dates  Les dates de création et de mise à jour sont gérées automatiquement. 
 Commentaires : Un commentaire appartient à un ticket et possède un auteur et une date de publication. 
 Accès support : Un technicien peut consulter et traiter les tickets de tous les collaborateurs. 
 Accès administration :  Les fonctions d’administration sont réservées aux administrateurs. 

## 5. Périmètre conseillé pour une première version (MVP)

Pour livrer une première version fonctionnelle sans multiplier les fonctionnalités, il est conseillé de commencer par :

1. L’authentification et la gestion des rôles.
2. La création d’un ticket par un collaborateur.
3. La consultation de ses propres tickets , ceux des autres et du détail d’un ticket.
4. La consultation de tous les tickets par le technicien support.
5. La modification du statut et de la priorité par le support.
6. L’ajout et la consultation des commentaires.
7. La recherche et les filtres simples.



"""####"""