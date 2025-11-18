# Kandy District Scout Branch Website - Setup Guide

## Phase 1: Foundation - COMPLETED ✓

This document provides setup instructions for the Kandy District Scout Branch website.

### What's Been Completed

#### 1. Laravel 11.x Installation ✓
- Fresh Laravel 11.x installation
- All dependencies installed via Composer
- Environment configuration ready

#### 2. Tailwind CSS Configuration ✓
- Tailwind CSS 3.x configured with custom color scheme:
  - Primary: `#78350f` (amber-900)
  - Secondary: `#064e3b` (emerald-900)
  - Accent: `#991b1b` (red-800)
  - Neutral: `#f1f5f9` (slate-100)

#### 3. Laravel Breeze Authentication ✓
- Blade stack configured
- Authentication scaffolding complete
- Registration, login, password reset ready

#### 4. Spatie Laravel Permission (RBAC) ✓
- Package installed and configured
- Three roles created:
  - **Super Admin**: Full system access
  - **Blogger**: Posts, Events, Gallery, Syllabus, Circulars
  - **Shop Manager**: Products and Product Categories only

#### 5. Database Migrations ✓
All database tables created with complete schema:
- `categories` - Blog categories
- `posts` - Blog/news posts with SEO fields
- `events` - Event management with location types
- `galleries` - Photo gallery management
- `gallery_images` - Gallery images
- `syllabi` - Training resources
- `circulars` - Official circulars
- `product_categories` - Shop categories
- `products` - Shop products with SEO
- `product_images` - Product gallery
- `milestones` - History timeline
- `settings` - Site configuration

#### 6. Database Seeders ✓
- **RolePermissionSeeder**: Creates roles, permissions, and default super admin user
  - Email: admin@kandyscouts.lk
  - Password: password
- **SettingSeeder**: Populates all site settings (contact, branding, social, SEO, etc.)

#### 7. Helper Functions ✓
Located in `app/Helpers/helpers.php`:
- `settings($key, $default)` - Get setting value with caching
- `active_link($route, $class)` - Mark active navigation links
- `format_date($date, $format)` - Format dates using Carbon
- `truncate_text($text, $length)` - Truncate text with ellipsis

#### 8. File Storage Structure ✓
```
storage/app/public/
├── posts/
│   ├── featured/
│   └── thumbnails/
├── events/
│   ├── banners/
│   └── thumbnails/
├── galleries/
│   ├── covers/
│   └── images/
├── products/
│   ├── primary/
│   └── gallery/
├── syllabus/
├── circulars/
├── settings/
│   ├── branding/
│   └── banners/
└── milestones/
```

### Required Packages Installed

```json
{
  "spatie/laravel-permission": "^6.23",
  "intervention/image-laravel": "^1.5",
  "laravel/breeze": "^2.3"
}
```

### Next Steps - Running the Application

#### 1. Configure Database

**Option A: SQLite (Recommended for Development)**
```bash
# Ensure php-sqlite3 extension is installed
touch database/database.sqlite
php artisan migrate:fresh --seed
```

**Option B: MySQL (Recommended for Production)**
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE kandyscouts_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Update .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kandyscouts_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Run migrations
php artisan migrate:fresh --seed
```

#### 2. Build Frontend Assets

```bash
npm install
npm run dev
# Or for production:
npm run build
```

#### 3. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

#### 4. Default Login Credentials

- **Email**: admin@kandyscouts.lk
- **Password**: password

**⚠️ IMPORTANT**: Change this password immediately after first login!

### Phase 2 Tasks (Next Steps)

The following features are ready to be implemented:

1. **Admin Dashboard**
   - Dashboard layout
   - Statistics widgets
   - Quick actions

2. **Blog Management**
   - CRUD for posts
   - Category management
   - Rich text editor integration

3. **Event Management**
   - Event CRUD
   - Registration tracking
   - Calendar integration

4. **Gallery Management**
   - Album CRUD
   - Bulk image upload
   - Image optimization

5. **Resource Management**
   - Syllabus CRUD
   - Circular CRUD
   - File upload handling

6. **Shop Module**
   - Product CRUD
   - Category management
   - Inventory tracking

7. **Site Settings**
   - Settings management interface
   - Milestone management
   - Commissioner message

### Development Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Create storage link
php artisan storage:link

# Run tests
php artisan test
```

### File Permissions

Ensure proper permissions for Laravel:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Environment Variables

Key environment variables in `.env`:
- `APP_NAME`: Application name
- `APP_ENV`: Environment (local/production)
- `APP_DEBUG`: Debug mode (true/false)
- `APP_URL`: Application URL
- `DB_*`: Database configuration

### Security Notes

1. Generate new APP_KEY if not set:
   ```bash
   php artisan key:generate
   ```

2. Set proper permissions in production
3. Disable debug mode in production
4. Use strong passwords
5. Enable HTTPS in production
6. Regular backups

### Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Intervention Image](https://image.intervention.io/v3)

### Troubleshooting

**Database connection issues:**
- Verify database credentials in `.env`
- Check if database server is running
- Ensure database exists

**Permission denied errors:**
- Run `chmod -R 775 storage bootstrap/cache`

**Assets not loading:**
- Run `npm install && npm run build`
- Check if `php artisan storage:link` was run

### Support

For issues or questions, contact the development team or refer to project documentation.

---

**Project Status**: Phase 1 Complete ✓
**Next Phase**: Admin Panel Development
**Last Updated**: November 2025
