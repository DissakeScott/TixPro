

<img width="1715" height="645" alt="Capture d’écran du 2026-04-20 09-42-24" src="https://github.com/user-attachments/assets/fd1baa15-bfb7-4e4a-9853-87a067cd50a9" />





# Documentation fonctionnelle - TixPro

TixPro est un outil de gestion de tickets et de suivi du temps conçu pour les agences web. Son but principal est de simplifier le suivi des heures vendues aux clients et de gérer proprement la validation des demandes qui sortent du forfait.

## Le cycle de vie d'une demande

Voici comment l'application est utilisée au quotidien, de la demande du client jusqu'à la facturation :

1. **Le contrat initial :** L'agence crée un projet pour son client et lui attribue un contrat avec un volume d'heures (par exemple, 50 heures de maintenance).
2. **La création du ticket :** Le client fait une demande et un collaborateur crée le ticket. 
   - Si la demande rentre dans le contrat, le ticket est "Inclus".
   - Si le contrat est vide ou que c'est une grosse évolution, le ticket est obligatoirement marqué "Facturable".
3. **La validation (Le blocage métier) :** Sur un ticket facturable, le collaborateur ne peut pas commencer à travailler (le système bloque la saisie du temps). Le client doit d'abord se connecter sur son espace pour accepter ou refuser cette prestation.
4. **Le suivi du temps :** Une fois le ticket validé (ou s'il était inclus de base), le développeur saisit ses heures. Le "compte en banque" des heures du projet diminue automatiquement.

## Les deux interfaces de l'application

L'outil sépare complètement les clients de l'agence.

### 1. L'espace Agence (En interne)
C'est l'interface de travail de l'équipe (Administrateurs et Collaborateurs).
- **Le Dashboard :** Permet de voir les tickets urgents et ceux qui attendent une réponse du client.
- **Les Projets :** Affiche la liste des clients et les jauges de consommation de leurs forfaits d'heures.
- **Les Tickets :** Permet de changer les statuts et de déclarer du temps de travail.

### 2. Le Portail Client (Extranet)
C'est un espace simplifié pour les clients. Ils n'ont accès qu'à leurs propres données.
- Ils voient un encart d'alerte s'ils ont des devis "Facturables" en attente de validation.
- Ils ont un tableau de bord pour suivre l'état d'avancement de leurs tickets (En cours, Terminé, etc.).

## Les différents profils

- **Administrateur :** Il gère la configuration (création des clients, des projets et des contrats).
- **Collaborateur :** Il est dans l'opérationnel. Il gère les tickets et saisit son temps.
- **Client :** Il a un accès limité pour suivre l'avancement de son projet et valider les dépassements de budget.

(Note : Tous les utilisateurs disposent d'une page Paramètres pour gérer leurs informations personnelles et changer leur mot de passe)
