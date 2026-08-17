# Restaurant Control Panel API — CodeIgniter 4

A small but complete **PHP (CodeIgniter 4) REST API** built to serve as a work sample for
the *"Fullstack Developer (PHP & Vue.js)"* role at Workana, whose client builds the
**App + Control Panel** for restaurant-chain brands (McDonald's, Domino's, Pizza Hut, etc.).

It models the core of that domain: **Categories** and **Menu Products**, exposed as a
JSON REST API that a Vue.js control panel (or mobile app) can consume directly.

## Why this shape

- The job description explicitly asks for a *"proyecto completo hecho con PHP y
  CodeIgniter para mostrar como modelo"* — this is that model project.
- Since the frontend stack is **Vue.js**, the backend is built as a **pure REST API**
  (JSON in/out), not server-rendered views — matching how a real Vue SPA / control
  panel would talk to it.
- Uses CodeIgniter's built-in `ResourceController` + validation + migrations, so it
  reflects idiomatic CI4 practice, not just raw PHP.
- Includes an API-key filter (simple header-based auth) since a real control panel
  backend needs request protection — easy to swap for JWT/OAuth later.

## Structure

```
app/
├── Config/
│   └── Routes.php              # API route definitions
├── Controllers/Api/
│   ├── CategoryController.php  # /api/categories CRUD
│   └── ProductController.php   # /api/products CRUD (+ filter by category)
├── Models/
│   ├── CategoryModel.php
│   └── ProductModel.php
├── Filters/
│   └── ApiKeyFilter.php        # simple header-based auth for the API
└── Database/Migrations/
    ├── 2026-08-17-000001_CreateCategories.php
    └── 2026-08-17-000002_CreateProducts.php
```

## Endpoints

| Method | Endpoint                        | Description                          |
|--------|----------------------------------|---------------------------------------|
| GET    | /api/categories                  | List all categories                   |
| GET    | /api/categories/{id}              | Show one category                     |
| POST   | /api/categories                  | Create category                       |
| PUT    | /api/categories/{id}              | Update category                       |
| DELETE | /api/categories/{id}              | Delete category                       |
| GET    | /api/products                    | List products (optional `?category_id=`) |
| GET    | /api/products/{id}                | Show one product                      |
| POST   | /api/products                    | Create product                        |
| PUT    | /api/products/{id}                | Update product                        |
| DELETE | /api/products/{id}                | Delete product (soft delete)          |

All requests require an `X-API-KEY` header (see `ApiKeyFilter.php`).

## Setup

1. `composer create-project codeigniter4/appstarter restaurant-api` then drop these
   folders in, **or** copy these files into an existing CI4 install.
2. Set your DB credentials in `.env`.
3. Run migrations: `php spark migrate`
4. Serve: `php spark serve`
5. Test: `curl -H "X-API-KEY: demo-key-123" http://localhost:8080/api/products`
