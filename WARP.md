# WARP.md

This file provides guidance to WARP (warp.dev) when working with code in this repository.

## Application Overview

This is a Laravel-based forum application built with:
- **Backend**: Laravel 12 with PHP 8.2+
- **Frontend**: Vue.js 3 with Inertia.js for SPA functionality
- **Styling**: Tailwind CSS with Tailwind Forms and Typography plugins
- **Authentication**: Laravel Jetstream with Sanctum for API authentication
- **Database**: SQLite (default), with support for other databases
- **Testing**: Pest PHP for testing framework
- **Build Tool**: Vite for asset compilation

## Architecture

### Core Domain Models
- **User**: Managed by Jetstream with two-factor authentication support
- **Post**: Forum posts with title and body, belonging to users
- **Comment**: Comments on posts, belonging to both users and posts

### Key Relationships
- User hasMany Posts
- User hasMany Comments  
- Post hasMany Comments
- Post belongsTo User
- Comment belongsTo User and Post

### Frontend Architecture
The application uses Inertia.js to create a SPA experience:
- **Pages**: Located in `resources/js/Pages/`
  - `Posts/Index.vue` - Lists all posts with pagination
  - `Posts/Show.vue` - Shows individual post with comments
  - Authentication pages handled by Jetstream
- **Components**: Reusable Vue components in `resources/js/Components/`
- **Layouts**: `AppLayout.vue` provides consistent navigation and styling

### API Resources
- `PostResource` - Formats post data for frontend consumption
- `CommentResource` - Formats comment data with user information
- `UserResource` - Formats user data for API responses

## Development Commands

### Environment Setup
```bash
# Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# Create SQLite database file (if using SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### Development Server
```bash
# Start all development services (server, queue, logs, vite)
composer dev

# Or run services individually:
php artisan serve                    # Laravel development server
npm run dev                         # Vite development server  
php artisan queue:listen --tries=1  # Queue worker
php artisan pail --timeout=0       # Real-time logs
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create model with migration and factory
php artisan make:model ModelName -mf
```

### Testing
```bash
# Run all tests
composer test
# Or: php artisan test

# Run specific test file
php artisan test tests/Unit/ExampleTest.php

# Run tests with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Run Laravel Pint for code formatting
./vendor/bin/pint

# Check code style without fixing
./vendor/bin/pint --test
```

### Frontend Development
```bash
# Install dependencies
npm install

# Build assets for development
npm run dev

# Build assets for production
npm run build

# Watch for changes during development
npm run dev
```

### Artisan Commands
```bash
# Generate controllers
php artisan make:controller PostController --resource
php artisan make:controller CommentController

# Generate requests for validation
php artisan make:request StorePostRequest

# Generate API resources
php artisan make:resource PostResource

# Clear various caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## Database Schema

### Posts Table
- `id` - Primary key
- `user_id` - Foreign key to users (restrict on delete)
- `title` - String
- `body` - Long text
- `created_at`, `updated_at` - Timestamps

### Comments Table  
- `id` - Primary key
- `post_id` - Foreign key to posts (cascade on delete)
- `user_id` - Foreign key to users (restrict on delete)
- `body` - Long text (max 255 chars in validation)
- `created_at`, `updated_at` - Timestamps

## Routes Structure

### Web Routes (`routes/web.php`)
- `GET /` - Welcome page with login/register options
- `GET /dashboard` - Authenticated user dashboard
- `GET /posts` - List all posts (`posts.index`)
- `GET /posts/{post}` - Show individual post (`posts.show`) 
- `POST /posts/{post}/comments` - Create comment (`posts.comments.store`)

Authentication routes are handled automatically by Jetstream.

## Configuration Notes

- **Database**: Configured for SQLite by default, easily switchable to MySQL/PostgreSQL
- **Queue**: Uses database driver by default
- **Cache**: Uses database driver by default  
- **Session**: Stored in database
- **Testing**: Uses separate `forumdb-testing` database
- **Mail**: Uses log driver for development

## Key Files to Understand

- `app/Http/Controllers/PostController.php` - Handles post listing and viewing
- `app/Http/Controllers/CommentController.php` - Handles comment creation
- `app/Models/Post.php` - Post model with user and comments relationships
- `app/Models/Comment.php` - Comment model with post and user relationships
- `routes/web.php` - Application routing
- `resources/js/Pages/Posts/` - Main frontend pages for post functionality
- `database/migrations/` - Database schema definitions
