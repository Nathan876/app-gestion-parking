# 🧠 Documentation technique – TrouveTaPlace

---

## 📀 Architecture du projet

```
trouvetaplace/
├── api/                    → Back-end PHP (HTTPS sur port 81)
│   ├── controllers/
│   ├── models/
│   ├── repositories/
│   └── index.php
├── front/                  → Interface utilisateur (HTTPS sur port 80)
│   ├── assets/
│   ├── components/
│   └── index.html
├── .env.example
├── composer.json
└── README.md
```

---

## 🖥️ Back-end – `api/` (HTTPS sur port 81)

- **Langage** : PHP 8+
- **Architecture** : MVC simplifié
  - `controllers/` → Gère les requêtes, appelle les repositories
  - `models/` → Entités (Utilisateur, Réservation, etc.)
  - `repositories/` → Accès MySQL via PDO
- **Sécurité** :
  - Hash Bcrypt
  - Requêtes préparées via PDO
  - JWT pour l'authentification

---

## 🌐 Front-end – `front/` (HTTPS sur port 80)

- **Langage** : HTML, CSS, JavaScript (sans framework)
- **Paradigme** : POO JS (chaque composant = classe)
- **Fonctionnalités** :
  - Appels `fetch` vers l’API sécurisée
  - Affichage conditionnel (connexion, erreurs, réservations)
  - Paiement PayPal
  - Notifications Pusher

---

## 🔌 Configuration réseau locale

### `/etc/hosts`

```bash
127.0.0.1   trouvetaplace.local
127.0.0.1   api.trouvetaplace.local
```

---

## 🔒 Configuration Nginx en HTTPS

> ⚠️ Nécessite des certificats SSL locaux générés (ex: mkcert ou openssl)

### 🔹 Front – `trouvetaplace.local` (HTTPS sur port 443)

```nginx
server {
    listen 443 ssl;
    server_name trouvetaplace.local;

    ssl_certificate     /etc/ssl/certs/trouvetaplace.local.pem;
    ssl_certificate_key /etc/ssl/private/trouvetaplace.local-key.pem;

    root /chemin/vers/front;
    index index.html;

    location / {
        try_files $uri $uri/ =404;
    }
}
```

### 🔹 API – `api.trouvetaplace.local` (HTTPS sur port 444)

```nginx
server {
    listen 444 ssl;
    server_name api.trouvetaplace.local;

    ssl_certificate     /etc/ssl/certs/api.trouvetaplace.local.pem;
    ssl_certificate_key /etc/ssl/private/api.trouvetaplace.local-key.pem;

    root /chemin/vers/api;
    index index.php;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000; # PHP-FPM
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

> 💡 Si besoin, redirige HTTP vers HTTPS avec un bloc `listen 80` et `return 301 https://$host$request_uri;`

---

## ⚙️ Variables d’environnement (`api/.env`)

```env
BDD_URL=localhost
BDD_PORT=8889
BDD_NAME=trouvetaplace
BDD_USERNAME=root
BDD_PASSWORD=root

PUSHER_NOTIF_INSTANCE_ID=
PUSHER_NOTIF_PRIMARY_KEY=

CLIENT_ID=         # PayPal
CLIENT_SECRET=

INSTANCE_ID=
```

> À copier depuis `.env.example` :

```bash
cp .env.example api/.env
```

---

## 🛆 Dépendances PHP (Composer)

### `composer.json` – exemples de dépendances :

```json
{
  "require": {
    "paypal/paypal-checkout-sdk": "^1.0",
    "guzzlehttp/guzzle": "^7.0",
    "firebase/php-jwt": "^6.0",
    "vlucas/phpdotenv": "^5.5"
  }
}
```

### Installation :

```bash
cd api
composer install
```

---

## 🗓 Base de données

- MAMP (MySQL local)
- Par défaut :
  - hôte : `localhost`
  - port : `8889`
  - utilisateur : `root`
  - mot de passe : `root`
- Exemple d’import :

```bash
mysql -u root -p trouvetaplace < db/trouvetaplace.sql
```

---

## 🚀 Démarrage local

1. Lancer **MAMP** pour la BDD
2. Lancer les serveurs **Nginx** avec les bons ports et certificats SSL
3. Accéder aux URLs sécurisées :
   - [https://trouvetaplace.local](https://trouvetaplace.local)
   - [https://api.trouvetaplace.local:444](https://api.trouvetaplace.local:444)

