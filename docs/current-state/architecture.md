# Architecture

## Current shape

```text
Browser
  |
  v
Laravel Blade welcome view + Vue/Vite entry assets
  |
  +--> Laravel API routes -> Passport-oriented authentication controller
  |
  +--> Laravel models, migrations, and framework services
```

The current source includes a Laravel 10 application scaffold, a user model and framework migrations, a registration/login/logout/refresh API controller, and Vue/Vite bootstrapping assets. Docker and Nginx configuration are available for local/container-oriented operation.

## Domain boundary

There are no implemented source modules or data structures for the airspace-control functions described in historical documentation. Those documents remain useful product inspiration, but this folder is the authority for current code scope.
