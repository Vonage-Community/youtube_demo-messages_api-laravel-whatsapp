# Send & Receive WhatsApp Messages With Laravel & Monitor With Nightwatch
How to use Messages API with Laravel and monitor with Laravel Nightwatch

## Prerequisites

- PHP 8+
- Composer
- Vonage account
- ngrok (optional)
- Laravel Nigthwatch (optional)

## Terminal Commands

```bash
# Install Vonage Laravel SDK
composer require vonage/vonage-laravel
````

```bash
# Publish Vonage config
php artisan vendor:publish --provider="Vonage\Laravel\VonageServiceProvider"
```

```bash
# Start the Laravel development server
php artisan serve
```

```bash
# Expose local server for webhooks (run in a separate terminal)
ngrok http 8000
```

## API Endpoints

```
POST /api/message
POST /api/inbound
POST /api/status
```

## (Optional) Laravel Nightwatch

```bash
# Make sure dependencies are up to date
composer update
composer install
````

```bash
# Install Nightwatch
composer require laravel/nightwatch
```

```bash
# Start the Nightwatch agent
php artisan nightwatch:agent
```

