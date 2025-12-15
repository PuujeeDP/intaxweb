# MagicCMS

A powerful, multi-language Content Management System built with Laravel, React, Inertia.js, and PostgreSQL.

## Features

### Multi-Language Support
- **English**, **Mongolian (Монгол)**, and **Chinese (中文)** support
- Polymorphic translation system for flexible content management
- Easily extendable for additional languages

### Content Management
- **Posts**: Create and manage blog posts with rich content
- **Pages**: Static page management for About, Contact, etc.
- **Categories**: Hierarchical category system with parent-child relationships
- **Media Library**: File upload and management with preview support

### User Management
- User CRUD operations with role-based access control
- Multiple roles per user
- Password security with validation
- Prevent accidental deletion of users with content

### System Management
- **Settings Dashboard**: View system configuration and database statistics
- **Cache Management**: Clear application, config, routes, and views cache
- **Application Optimization**: Cache config and routes for production
- **Database Statistics**: Monitor users, posts, pages, categories, and media counts

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: React 18 with Inertia.js
- **Styling**: Tailwind CSS v4
- **Database**: PostgreSQL
- **Build Tool**: Vite

## Installation

### Prerequisites
- PHP 8.2+
- PostgreSQL
- Composer
- Node.js & npm

### Setup Steps

1. Clone the repository
```bash
cd backend
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JavaScript dependencies
```bash
npm install
```

4. Configure environment
```bash
cp .env.example .env
```

Edit `.env` and configure your PostgreSQL database:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=magiccms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key
```bash
php artisan key:generate
```

6. Run migrations
```bash
php artisan migrate
```

7. Create storage symlink
```bash
php artisan storage:link
```

8. Seed database with roles and admin user
```bash
php artisan db:seed
```

9. Build frontend assets
```bash
npm run build
```

10. Start development server
```bash
php artisan serve
```

Visit `http://localhost:8000` and login with the seeded admin credentials.

## Development

### Running in development mode
```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev
```

### Building for production
```bash
npm run build
```

## Project Structure

### Models
- `User`: System users with role relationships
- `Role`: User roles for access control
- `Post`: Blog posts with translations and soft deletes
- `Page`: Static pages with translations
- `Category`: Hierarchical categories with translations
- `Media`: Uploaded files and images
- `Translation`: Polymorphic translation storage

### Key Features

#### Translation System
The polymorphic translation system uses the `Translatable` trait:

```php
// Any model can use translations
use App\Models\Traits\Translatable;

class Post extends Model {
    use Translatable;

    public $translatable = ['title', 'content', 'excerpt'];
}

// Store translation
$post->setTranslation('title', 'en', 'English Title');
$post->setTranslation('title', 'mn', 'Монгол Гарчиг');

// Retrieve translation
$title = $post->translate('title', 'mn');
```

#### Role-Based Access Control
```php
// Attach roles to user
$user->roles()->attach([1, 2]);

// Check role
if ($user->hasRole('admin')) {
    // Admin actions
}
```

#### Media Upload
```php
// Store file
$path = $file->storeAs('uploads', $fileName, 'public');

// Create media record
Media::create([
    'name' => 'My Image',
    'path' => $path,
    'uploaded_by' => auth()->id(),
]);
```

## Admin Routes

- `/admin/dashboard` - Dashboard overview
- `/admin/posts` - Posts management
- `/admin/pages` - Pages management
- `/admin/categories` - Categories management
- `/admin/media` - Media library
- `/admin/users` - User management
- `/admin/settings` - System settings

## License

Open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
