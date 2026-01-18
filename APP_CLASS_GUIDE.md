# App.php - Application Core Class

## Overview

The `App.php` class is the heart of the MVC framework. It handles routing, controller dispatching, and request management.

## Features

### 1. **Route Registration**

Register explicit routes with controller and method:

```php
$app->addRoute('/dashboard', 'DashboardController', 'index');
$app->addRoute('/incomes', 'IncomeController', 'index');
```

### 2. **Automatic Controller Resolution**

If no explicit route matches, the app automatically resolves:

- URL: `/incomes/edit/5`
- Controller: `IncomeController`
- Method: `edit`
- Params: `[5]`

### 3. **URL Parsing**

Handles various URL structures and base paths automatically.

### 4. **404 Handling**

Built-in 404 error page for non-existent routes.

## Usage Options

### Option 1: Using Current Router (Simpler)

Your current `public/index.php` works well and is simpler for small applications.

**Pros:**

- Direct and explicit
- Easy to understand
- No magic

**Keep if:** You prefer explicit control and clarity

### Option 2: Using App.php (More Framework-like)

Use `index_with_app.php` for a more traditional MVC framework approach.

**Pros:**

- Cleaner route registration
- Automatic controller resolution
- More scalable
- Easier to extend

**Use if:** You want a more framework-like structure

## How App.php Works

```
Request → App::run()
    ↓
Parse URL
    ↓
Check Registered Routes
    ↓
Match Found?
    ├─ Yes → Dispatch to Controller::method()
    └─ No  → Automatic Resolution OR 404
        ↓
Controller executes
    ↓
View rendered
    ↓
Response sent
```

## Switching to App.php

If you want to use `App.php`:

1. **Rename files:**

   ```bash
   mv public/index.php public/index_old.php
   mv public/index_with_app.php public/index.php
   ```

2. **That's it!** The App class will handle routing.

## Key Methods

### `addRoute(pattern, controller, method)`

Register a route explicitly.

### `run()`

Start the application and dispatch the request.

### `parseUrl()`

Parse the current URL into components.

### `dispatchRoute(route)`

Dispatch to a registered route.

### `dispatchAutomatic(url)`

Automatically resolve controller from URL.

## Example Routes

```php
// Explicit routes
$app->addRoute('/login', 'AuthController', 'showLogin');
$app->addRoute('/incomes/create', 'IncomeController', 'create');

// Automatic resolution works for:
// /incomes        → IncomeController::index()
// /incomes/show/5 → IncomeController::show(5)
// /dashboard      → DashboardController::index()
```

## Decision Guide

**Keep current `index.php` if:**

- ✅ You want explicit control
- ✅ Small to medium application
- ✅ Clear route definitions
- ✅ Simple is better

**Switch to `App.php` if:**

- ✅ You want automatic routing
- ✅ Growing application
- ✅ More framework-like structure
- ✅ Planning to add many routes

## Both Approaches Work!

Your current implementation is perfectly valid. `App.php` is provided as an architectural option for those who prefer a more traditional MVC framework approach.
