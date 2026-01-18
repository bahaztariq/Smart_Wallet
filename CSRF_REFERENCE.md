# CSRF Protection - Quick Reference

## ✅ Using CSRF Class

### Structure

```
App/
├── Core/
│   ├── CSRF.php          ✅ Static CSRF class
│   └── Controller.php    ✅ Uses CSRF class
```

## Usage

### In Forms (Views)

```php
<?php
session_start();
require __DIR__ . '/../../../vendor/autoload.php';

use App\Core\CSRF;  // ← Import CSRF class
?>

<form action="/incomes/add" method="POST">
    <?php echo CSRF::field(); ?>  // ← Generate token field
    <!-- Other form fields -->
</form>
```

### In Controllers

```php
public function store(): void
{
    $this->requireAuth();     // Check authentication
    $this->requireCSRF();     // Validate CSRF token

    // Process form...
}
```

## CSRF Class Methods

**`CSRF::field()`**

- Generates: `<input type="hidden" name="csrf_token" value="...">`
- Use in: All forms

**`CSRF::getToken()`**

- Returns: Current CSRF token string
- Use in: JavaScript/AJAX requests

**`CSRF::validateToken($token)`**

- Returns: `true` if token is valid
- Use in: Custom validation logic

**`CSRF::regenerateToken()`**

- Generates: New token, invalidates old one
- Use in: After sensitive operations

## Controller Methods

**`$this->requireCSRF()`**

- Validates CSRF token
- Dies with 403 if invalid
- Use in: All POST/PUT/DELETE methods

**`$this->validateCSRF()`**

- Returns: `true/false`
- Use in: Custom validation flows

**`$this->sanitize($input)`**

- Sanitizes string input (XSS protection)
- Use in: All user inputs

## Protected Forms

✅ Login - `auth/login.php`
✅ Register - `auth/Register.php`
✅ Add Income - `incomes/incomes.php`
✅ Edit Income - `incomes/incomes.php`
✅ Add Expense - `expences/expences.php`
✅ Edit Expense - `expences/expences.php`

## Security Flow

```
1. Form renders with CSRF::field()
   ↓
2. Hidden input added with token
   ↓
3. User submits form
   ↓
4. Controller calls $this->requireCSRF()
   ↓
5. Token validated with hash_equals()
   ↓
6. ✅ Valid → Process request
   ❌ Invalid → 403 Forbidden
```

## Example: Complete Form Protection

```php
// View
<form action="/incomes/add" method="POST">
    <?php echo CSRF::field(); ?>
    <input type="text" name="description" required>
    <button type="submit">Submit</button>
</form>

// Controller
public function store(): void
{
    $this->requireAuth();
    $this->requireCSRF();  // ← Validates token

    $description = $this->sanitize($_POST['description']);
    // ... save to database
}
```

## Benefits of CSRF Class

✅ **Centralized** - All logic in one class
✅ **Static Methods** - Easy to call anywhere
✅ **Type-Safe** - Class-based approach
✅ **Testable** - Can mock for unit tests
✅ **Standard** - Followsclear OOP patterns

## Current Status

🔒 **All forms are protected with CSRF tokens**
🔒 **All inputs are sanitized against XSS**
🔒 **Session regeneration on auth events**
✅ **Production ready!**
