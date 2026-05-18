# RYZE - Laravel 12 E-commerce Sport

RYZE est une plateforme e-commerce sportive construite avec Laravel 12, Blade, Tailwind CSS, Alpine.js, Sanctum et MySQL.

## Modules inclus

- Catalogue produits: categories, sous-categories, marques, SKU, stock, prix, promotions, tailles, couleurs et images multiples.
- Boutique: recherche, filtres, tri, pagination, pages detail produit et produits lies.
- Panier et checkout: taxes, livraison, coupons, commandes, statuts, facture PDF.
- Paiements: structure Stripe, PayPal et Cash on Delivery prete a connecter via `.env`.
- Clients: inscription, connexion, deconnexion, remember me, mot de passe oublie, verification email, dashboard, historique commandes.
- Admin: dashboard, revenus, ventes, utilisateurs, produits, commandes, categories, avis, coupons, analytics, settings et stock faible.
- API REST: auth, products, cart, orders, reviews avec Sanctum et API Resources.
- Bonus: wishlist, reviews, blog sport, fidelite, multilangue FR/EN/AR, SEO, PWA, dark mode et notifications.

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
npm run build
php artisan serve
```

Compte admin de demo:

```text
admin@ryze.test
password
```

## Configuration MySQL

Dans `.env`:

```env
APP_NAME=RYZE
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ryze
DB_USERNAME=root
DB_PASSWORD=
```

## Paiement

```env
STRIPE_KEY=
STRIPE_SECRET=
PAYPAL_CLIENT_ID=
PAYPAL_SECRET=
PAYPAL_MODE=sandbox
```

La couche `App\Services\PaymentService` contient les points d'integration pour finaliser Stripe Checkout et PayPal Orders.

## API

Endpoints principaux:

- `POST /api/auth/register`
- `POST /api/auth/login`
- `GET /api/products`
- `GET /api/products/{slug}`
- `GET /api/cart`
- `POST /api/cart/{product}`
- `POST /api/orders`
- `GET /api/orders`
- `POST /api/products/{product}/reviews`

Utiliser le token Sanctum retourne par login/register:

```http
Authorization: Bearer <token>
Accept: application/json
```

## Structure importante

- `app/Models`: relations Eloquent.
- `app/Repositories/ProductRepository.php`: recherche, filtres, pagination.
- `app/Services`: panier, checkout, paiement.
- `app/Http/Requests`: validation avancee.
- `app/Http/Controllers/Frontend`: pages client.
- `app/Http/Controllers/Admin`: dashboard et gestion admin.
- `app/Http/Controllers/Api`: API REST.
- `resources/views`: Blade + Tailwind.
- `database/migrations`: schema MySQL complet.
- `database/seeders/RyzeSeeder.php`: donnees de demo.

## Production

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:work
```

Points a verifier avant mise en ligne:

- `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` defini.
- HTTPS actif et `APP_URL` correct.
- Worker queue supervise.
- Cron Laravel actif: `php artisan schedule:run`.
- Stockage public lie avec `php artisan storage:link`.
- Secrets Stripe/PayPal et SMTP configures.
