# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

MagicCMS is a multi-language Content Management System built with Laravel 12, PostgreSQL, Tailwind CSS, and Alpine.js.

**Architecture:**
- **Admin Panel**: Inertia.js + React 18 (SPA experience for content management)
- **Public Frontend**: Blade Templates + Tailwind CSS + Alpine.js (Traditional server-side rendering)
- **Multi-language Support**: English, Mongolian, and Chinese via polymorphic translation system

**Tech Stack:**
- Laravel 12 (Backend framework)
- PostgreSQL (Database)
- Tailwind CSS (Styling)
- Alpine.js (Frontend interactivity for public site)
- React 18 + Inertia.js (Admin panel SPA)
- Vite (Asset bundling)

## Development Commands

### Initial Setup
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan db:seed
```

### Running Development Server
```bash
# All-in-one command (recommended for development)
composer dev  # Runs server, queue, logs, and vite concurrently

# OR run services separately in different terminals:
php artisan serve  # Laravel development server
npm run dev        # Vite dev server with HMR
php artisan queue:listen --tries=1  # Queue worker
php artisan pail --timeout=0        # Real-time logs
```

### Testing
```bash
composer test           # Full test suite (clears config then runs tests)
php artisan test        # PHPUnit tests
php artisan test --filter=TestName  # Run specific test
```

### Code Quality
```bash
vendor/bin/pint         # Laravel Pint code formatter (PSR-12)
vendor/bin/pint --test  # Check formatting without changes
```

### Building for Production
```bash
npm run build           # Build optimized frontend assets
php artisan config:cache    # Cache configuration
php artisan route:cache     # Cache routes
php artisan optimize        # Full optimization
```

### Cache Management
```bash
php artisan cache:clear     # Clear application cache
php artisan config:clear    # Clear config cache
php artisan route:clear     # Clear route cache
php artisan view:clear      # Clear compiled views
```

## Architecture

### Translation System

The core architectural feature is the **polymorphic translation system** using the `Translatable` trait (app/Models/Traits/Translatable.php:1). This allows any model to support multi-language content without duplicating database columns.

**How it works:**
- Models use the `Translatable` trait and define a `$translatable` array of fields
- Translations are stored in a separate `translations` table with polymorphic relationships
- Three languages supported: 'en' (English), 'mn' (Mongolian), 'zh' (Chinese)

**Key methods:**
- `translate($field, $locale)` - Get translation for a field in a locale
- `setTranslation($field, $locale, $value)` - Store/update translation
- `getTranslations($field)` - Get all translations for a field
- `getAllTranslations()` - Get all translations for all translatable fields

**Example usage:**
```php
// Post model has $translatable = ['title', 'excerpt', 'content', ...]
$post->setTranslation('title', 'en', 'English Title');
$post->setTranslation('title', 'mn', 'Монгол Гарчиг');
$title = $post->translate('title', 'mn'); // Returns Mongolian title
```

### Dual Frontend Architecture

**Admin Panel (Inertia.js + React):**
- Located at `/admin/*` routes
- Uses Inertia.js for SPA experience
- React components in `resources/js/Pages/Admin/`
- Authenticated users only
- Full CRUD operations for all content

**Public Frontend (Blade + Alpine.js):**
- Located at `/` (root) routes
- Uses Blade templates in `resources/views/frontend/`
- Alpine.js for interactive components (mobile menu, search modal)
- Server-side rendering for SEO
- Public read access, no authentication required

**Key Frontend Routes:**
- `/` - Homepage (latest posts, categories)
- `/posts` - Blog post index
- `/post/{slug}` - Single post view
- `/category/{slug}` - Posts by category
- `/page/{slug}` - Static pages

**Asset Building:**
- `resources/js/app.jsx` - Admin panel (React + Inertia)
- `resources/js/app-frontend.js` - Public site (Alpine.js)
- Both compiled via Vite with Tailwind CSS

### Role-Based Access Control (RBAC)

Multi-table RBAC system with roles and permissions:
- `users` table - Base user data
- `roles` table - Role definitions (admin, editor, etc.)
- `permissions` table - Permission definitions
- `role_user` pivot table - Many-to-many user-role relationships
- `permission_role` pivot table - Many-to-many role-permission relationships

**Key methods on User model (app/Models/User.php:71):**
- `hasRole($role)` - Check if user has a specific role by slug
- `hasPermission($permission)` - Check if user has a permission through their roles

### Frontend Architecture (Inertia.js + React)

**Inertia.js bridge:**
- Server renders initial HTML with data props
- React takes over for SPA-like experience
- No separate API needed - controllers return Inertia responses
- Pages in `resources/js/Pages/` directory

**Key structure:**
- `resources/js/app.jsx` - Inertia initialization
- `resources/js/Layouts/AppLayout.jsx` - Main admin layout wrapper
- `resources/js/Pages/Admin/*` - Admin CRUD pages
- `resources/js/Components/*` - Reusable form components

**LanguageTabs component:**
- Shared component for multi-language form fields
- Renders tabs for each language (en/mn/zh)
- Used in Post, Page, and Category forms

### Model Relationships

**User relationships:**
- `hasMany` posts (as author)
- `hasMany` pages (as author)
- `hasMany` media (as uploader)
- `belongsToMany` roles

**Post relationships:**
- `belongsTo` User (author)
- `belongsTo` Category
- `belongsTo` Media (featured image)
- `morphMany` Translation

**Category relationships:**
- `belongsTo` Category (parent, self-referential)
- `hasMany` Category (children)
- `hasMany` Post

### Query Scopes

**Post model scopes (app/Models/Post.php:53):**
- `published()` - Posts with status='published' and published_at <= now
- `draft()` - Posts with status='draft'

## Database

**Primary database:** PostgreSQL (configured in .env)

**Test database:** SQLite in-memory (phpunit.xml:26)

**Key migrations order:**
1. Users, cache, jobs (Laravel defaults)
2. Roles, permissions, media, pages, categories
3. Posts (depends on categories, media, users)
4. Pivot tables (role_user, permission_role)
5. Translations (polymorphic, depends on all translatable models)

**Seeding:**
Database seeder runs in order:
1. PermissionSeeder
2. RoleSeeder (creates roles and attaches permissions)
3. UserSeeder (creates admin user with roles)

## Routes Structure

All admin routes are prefixed with `/admin` and protected by `auth` middleware (routes/web.php:27).

**Resource routes:**
- `admin.posts.*` - Full CRUD
- `admin.pages.*` - Full CRUD
- `admin.categories.*` - Full CRUD
- `admin.media.*` - Store, index, update, destroy only (no create/show/edit views)
- `admin.users.*` - Full CRUD

**Special routes:**
- `admin.settings.index` - System settings dashboard
- `admin.settings.clear-cache` - Clear all caches
- `admin.settings.optimize` - Optimize application

## Important Notes

- **Soft deletes:** Post model uses SoftDeletes trait - deleted posts remain in database
- **File uploads:** Media stored in `storage/app/public` (symlinked to `public/storage`)
- **Queue:** Development setup includes queue worker for background jobs
- **Validation:** Form requests should be used for complex validation (currently in controllers)
- **No Git:** This repository is not currently a git repository
- **Testing database:** PHPUnit uses SQLite in-memory, not PostgreSQL