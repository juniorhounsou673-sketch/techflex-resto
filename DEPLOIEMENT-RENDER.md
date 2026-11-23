# Déploiement gratuit sur Render

Le dépôt est prêt : `render.yaml` décrit le service et le `Dockerfile` construit
l’application Laravel 12 (assets Vite avec Node 20, base SQLite locale).

## 1. Créer le compte Render

1. Va sur https://render.com/ puis **Sign Up**.
2. Choisis **GitHub** et autorise Render à accéder à tes dépôts.
3. Si Render ne voit pas `techflex-resto`, clique sur **Configure account**
   et autorise l’accès à ce dépôt.

## 2. Déployer en une fois (Blueprint)

1. Dans le dashboard Render : **New +** → **Blueprint**.
2. Sélectionne le dépôt `juniorhounsou673-sketch/techflex-resto`, branche `main`.
3. Render lit `render.yaml` et affiche le service `techflex-resto`.
4. Clique sur **Apply**.

Le plan **Free** est utilisé (aucune carte bancaire demandée). La région est
`Frankfurt`, la plus proche du Bénin.

## 3. Attendre la première compilation

La première fois, Render tire les images Docker, installe Composer et npm, puis
compile les assets : compte environ **5 à 10 minutes**. Les déploiements suivants
sont beaucoup plus rapides.

Le suivi se fait dans l’onglet **Logs** du service. La fin attendue est :

```
Migration terminée
Démarrage du serveur sur le port 10000
```

## 4. Ouvrir le site

L’URL est affichée sur la page du service, de la forme :

```
https://techflex-resto.onrender.com
```

Si cette URL est déjà prise, Render en choisira une autre ; elle reste visible
en haut de la page du service. La route `/up` sert de test de santé.

## 5. Comptes de démonstration

Le seeder est exécuté au premier démarrage :

| Rôle | E-mail | Mot de passe |
|---|---|---|
| Admin | `admin@restaurant.com` | `password` |
| Client | `jean@example.com` | `password` |

Le menu est déjà rempli (entrées, plats, desserts, boissons).

## 6. Administration (commandes et utilisateurs seulement)

La zone `/admin` est réservée au rôle `admin`. Elle contient uniquement :

- **Tableau de bord** : nombre de commandes, à confirmer, en livraison,
  livrées, clients et chiffre d’affaires.
- **Commandes** : liste filtrable, fiche détaillée (articles, client, paiement),
  confirmation d’une commande en attente, changement de statut
  (`en attente → confirmée → en préparation → en cours de livraison → livrée`)
  et suivi livraison (nom/téléphone du livreur, heure estimée, note).
- **Utilisateurs** : liste des comptes du site et historique de leurs commandes.

Un compte **admin ne peut pas commander** : le panier, la commande et le
paiement lui sont interdits (boutons masqués et accès refusé côté serveur).
Pour passer une commande, il faut créer ou utiliser un compte **client**
(`jean@example.com` / `password`). Le paiement ne confirme plus automatiquement
la commande : seule l’administration la confirme.

Les gestionnaires du menu (catégories/plats) ont été retirés de l’administration
comme demandé.

## Important à savoir

- **Mise en veille** : sur le plan gratuit, Render éteint le service après
  environ 15 minutes sans visite. La première visite suivante prend
  30 à 60 secondes. C’est normal.
- **Données** : la base SQLite est stockée dans le conteneur. Elle est donc
  réinitialisée à chaque redéploiement ou redémarrage. Pour un vrai site avec
  historique des commandes, il faudra ajouter une base PostgreSQL (gratuite
  limitée dans le temps) et remplacer `DB_CONNECTION=sqlite` par `pgsql`.
- **Clé APP_KEY** : Render génère une chaîne aléatoire qui n’est pas une clé
  Laravel valide. Le `render.yaml` contient donc une clé au format attendu
  (`base64:` + 32 octets). Pour un vrai site, régénère-la (`php artisan
  key:generate`) et stocke-la dans une variable d’environnement secrète.
- **Modifier le code** : pousse sur `main`, Render redéploie automatiquement
  (`autoDeploy: true`).

## Si le déploiement échoue

1. Ouvre **Logs** et cherche la première ligne rouge.
2. Erreur `npm`/`vite` : le Dockerfile utilise bien `node:20-alpine`.
3. Erreur `SQLSTATE` : vérifie que `DB_CONNECTION=sqlite` est bien présent dans
   les variables d’environnement du service.
4. Erreur `APP_KEY` : la valeur doit être au format `base64:` suivi de 32
   octets encodés. Ne clique pas sur **Generate** (Render génère une chaîne
   incompatible avec Laravel). Le `render.yaml` contient déjà une valeur valide.
