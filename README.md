
---

# Laravel Activity Logger

An activity logger for Eloquent models.

---

## Installation

Install via Composer:

```bash
composer require kentjerone/laravel-activity-logger
```

Publish the config and migrations:

```bash
php artisan vendor:publish --tag="activity-logger-config"
php artisan vendor:publish --tag="activity-logger-migrations"
```

Run the migrations:

```bash
php artisan migrate
```

This will publish:

* `config/activitylogger.php` → package configuration
* `database/migrations/xxxx_xx_xx_xxxxxx_create_activity_logs_table.php` → migration file

---

## Configuration

Inside `config/activitylogger.php` you can configure:

```php
declare(strict_types=1);

return [

    'table_name' => (string) env('ACTIVITY_LOGGER_TABLE', 'activity_logs'),

    'model_events' => (array) [

        'created' => true,
        'updated' => true,
        'deleted' => true,

        'restored' => false,
        'forceDeleted' => false,

        'creating' => false,
        'updating' => false,
        'deleting' => false,

    ],

    'request_payload' => [
        'except' => [
            'password',
            'password_confirmation',
            'remember_token',
        ],
    ],

];

```

---

## In Model

To enable automatic logging for a model:

```php
use KentJerone\ActivityLogger\Models\Concerns\HasAuthActivityLogger;

class User extends Authenticatable
{
   use HasAuthActivityLogger;
}
```

---

## Usage

> **Note:** If you don’t pass a model (`made_by_model`), the logger will automatically use the currently authenticated user (`auth()->user()`).

```php
// Example 1: Quick log without passing a model (defaults to auth()->user())
createActivityLog(
    human_message: 'Profile updated'
);

// Example 2: Quick log with a model
$user = \App\Models\User::factory()->create()->fresh();

createActivityLog(
    $made_by_model:$user,
    human_message: 'User registered',
    human_extra_message: ['email' => $user->email]
);

// Example 3: Using the CreateActivityLog action directly
$user = \App\Models\User::factory()->create()->fresh();

createActivityLog()->handle(
    $made_by_model:$user,
    human_message: 'User created via factory',
    developer_message: 'POST /register',
    developer_extra_message: ['ip' => request()->ip()],
    application_extra_message: ['debug' => 'custom app info']
);
```

---

## Fluent Activity Builder

You can also use the `activity()` helper for a clean, chainable syntax:

```php
// Minimal log
activity()
    ->humanMessage('User updated profile')
    ->create();

// With model and extra messages
$user = \App\Models\User::factory()->create()->fresh();

activity()
    ->madeByModel($user)
    ->humanMessage('User registered')
    ->humanExtraMessage(['email' => $user->email])
    ->developerMessage('POST /register')
    ->developerExtraMessage(['ip' => request()->ip()])
    ->applicationExtraMessage(['debug' => 'custom app info'])
    ->create();
```

---

## Which Style to Use?

| Style              | Example                                                | When to Use                                        |
| ------------------ | ------------------------------------------------------ | -------------------------------------------------- |
| **Quick helper**   | `activityLog($user, human_message: 'User registered')` | Simple one-liner logs.                             |
| **Action**         | `createActivityLog()->handle($user, ...)`              | When you need full control and explicit arguments. |
| **Builder**        | `Activity::make()->humanMessage(...)->create()`        | When building logs step by step.                   |
| **Helper Builder** | `activity()->humanMessage(...)->create()`              | Cleanest, most expressive way for everyday use.    |

---

## Human vs Developer Messages

* **human_message / human_extra_message** → Intended for business or end-user context (e.g., *"User updated their profile"*)
* **developer_message / developer_extra_message** → Intended for debugging, HTTP request details, or developer insight (e.g., *"PATCH /users/1"*)
* **application_message / application_extra_message** → Automatic or extra system-level context (IP, user agent, URL, old/new changes, etc.)

---

## Getting the Log Activities

```php
activityLog()->all();
```

You can also query directly via the model:

```php
use KentJerone\ActivityLogger\ActivityLog;

$logs = ActivityLog::latest()->take(10)->get();
```

---

## License

The MIT License (MIT).
Please see [License File](LICENSE) for more information.

---
