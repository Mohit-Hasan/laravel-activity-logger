# Laravel Activity Logger

A Laravel package that automatically logs Eloquent model events (create/update/delete) and supports manual logging with metadata, polymorphic relationships, and auto-capture of user/IP/user agent.

> **Live Demo:** [https://activity-logger.mohithasan.com](https://activity-logger.mohithasan.com)

---

## Run Demo Locally

```bash
git clone https://github.com/mohit-hasan/laravel-activity-logger.git
cd laravel-activity-logger/demo
cp .env.example .env
composer install
php artisan key:generate
php artisan serve
```

Visit `http://localhost:8000`. Use the buttons to test: **Manual Log**, **Create Post**, **Update Post**, **Delete Post**. All entries appear in the table with action, description, model link, user, IP, metadata, and timestamp.

---

## Install in Your App

```bash
composer require mohit-hasan/laravel-activity-logger dev-main
php artisan vendor:publish --provider="MohitHasan\ActivityLogger\ActivityLoggerServiceProvider"
php artisan migrate
```

Auto-discovers service provider and facade — no manual registration needed.

---

## Usage

### Trait — Auto-log model events

```php
use MohitHasan\ActivityLogger\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity;
}
```

Every `created`, `updated`, `deleted` on `Post` is logged automatically.

### Facade — Manual logging

```php
use MohitHasan\ActivityLogger\Facades\ActivityLogger;

ActivityLogger::action('user_login')
    ->description('User logged in.')
    ->log();
```

### With metadata

```php
ActivityLogger::action('order_placed')
    ->description('Order placed.')
    ->with(['order_id' => 12345, 'total' => 99.99])
    ->log();
```

### Link to a model (polymorphic)

```php
ActivityLogger::action('post_published')
    ->on($post)
    ->log();
```

### Retrieve logs

```php
$logs = ActivityLogger::getAll();                   // all
$logs = ActivityLogger::getAll(action: 'created');  // filtered
$logs = ActivityLogger::getAll(for: $post);         // for a model
```

All methods chain: `action()` → `description()` → `on()` → `with()` → `by()` → `log()`. Returns `null` silently on failure — never throws.

### Fluent API (full chain)

```php
$log = ActivityLogger::action('export')
    ->description('User exported report')
    ->on($report)
    ->with(['format' => 'PDF', 'rows' => 500])
    ->by($userId)
    ->log();
```

All methods chain. Returns `null` silently on failure — never throws.

---

## Config (`config/activity-logger.php`)

| Key | Default | Description |
|-----|---------|-------------|
| `table_name` | `activity_logs` | DB table name |
| `user_model` | `App\Models\User` | User model class |
| `capture_fields` | `['ip_address' => true, 'user_agent' => true]` | Auto-capture toggles |
| `ignore_events` | `['retrieved']` | Events to skip |
| `log_events` | `['created', 'updated', 'deleted', 'restored']` | Events to track |

