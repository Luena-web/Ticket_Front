<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use App\Models\Ticket;
use App\Models\Commentaire;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $agent = Utilisateur::create([
            'nom'    => 'Dubois',
            'prenom' => 'Pierre',
            'email'  => 'pierre.dubois@entreprise.com',
            'role'   => 'agent'
        ]);

        $utilisateur1 = Utilisateur::create([
            'nom'    => 'Durand',
            'prenom' => 'Sophie',
            'email'  => 'sophie.durand@entreprise.com',
            'role'   => 'utilisateur'
        ]);

        $utilisateur2 = Utilisateur::create([
            'nom'    => 'Leroy',
            'prenom' => 'Thomas',
            'email'  => 'thomas.leroy@entreprise.com',
            'role'   => 'utilisateur'
        ]);

        $ticket1 = Ticket::create([
            'titre'          => "Plus d'accès internet au service comptabilité",
            'description'    => "Impossible de me connecter au réseau de l'entreprise depuis ce matin. Les câbles semblent pourtant branchés.",
            'priorite'       => 'elevee',
            'statut'         => 'non resolu',
            'utilisateur_id' => $utilisateur1->id
        ]);

        $ticket2 = Ticket::create([
            'titre'          => "Demande d'installation du logiciel Docker",
            'description'    => "Bonjour, j'ai besoin de l'outil Docker pour tester localement les conteneurs du projet fil rouge.",
            'priorite'       => 'moyenne',
            'statut'         => 'en cours',
            'utilisateur_id' => $utilisateur2->id
        ]);

        Commentaire::create([
            'ticket_id'      => $ticket2->id,
            'utilisateur_id' => $utilisateur1->id, 
            'message'        => "Tu as vérifié si ton système d'exploitation est compatible avec la version Desktop ?"
        ]);
    }
}