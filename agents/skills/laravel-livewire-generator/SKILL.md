---
name: Laravel Livewire Component Creator
description: Guides the creation and integration of Laravel Livewire v3 components, including views, validation, events, and testing.
---

# Laravel Livewire Component Creator

Use this skill whenever you need to create a new Livewire component (page, modal, widget, form, or dynamic interface) for the Agrotrack application.

## Workflow

### 1. Plan the Component
Before writing code, analyze:
- Is it a **full-page** component (loaded via route) or a **nested/widget** component?
- What state (properties) must be managed?
- What actions (methods) are required?
- What validation rules apply?

### 2. Generate the Files
Always use Artisan to generate components to ensure correct boilerplates:
```bash
php artisan make:livewire [ComponentName]
```
This generates:
- Class: `app/Livewire/[ComponentName].php`
- View: `resources/views/livewire/[component-name].blade.php`

If it needs a test (strongly recommended), run:
```bash
php artisan make:livewire [ComponentName] --test
```

### 3. Implement the Backend Logic (`app/Livewire/`)
Ensure the class implements best practices:
- **Properties:** Use public properties for data bound to the view (use wire:model). Use typed properties where possible.
- **Validation:** Define validation rules using PHP 8 attributes (e.g., `#[Rule('required|min:3')]`) or the `rules()` method.
- **Actions:** Define public methods for user interactions. Keep them lean; delegate complex business logic to service classes.
- **Lifecycle Hooks:** Use `mount()`, `updating()`, `updated()` etc. appropriately.
- **Flash Messages:** Use `$this->flash()` or session flash for feedback.

### 4. Implement the Frontend View (`resources/views/livewire/`)
- Ensure the view has a single root HTML element.
- Bind properties using `wire:model` or `wire:model.live` (for real-time updates).
- Execute backend actions using `wire:click`, `wire:submit`, etc.
- Optimize rendering with keying (`wire:key`) for dynamic lists.

### 5. Define Routes (If Full-page)
If it's a full-page component, map it in `routes/web.php`:
```php
use App\Livewire\ComponentName;

Route::get('/route-path', ComponentName::class)->name('route.name');
```

### 6. Write Tests
Verify component behavior in `tests/Feature/Livewire/`:
- Test that the component is rendered on the page.
- Test property binding and validation.
- Test action side effects (e.g., saving data to the database).
- Example:
  ```php
  Livewire::test(ComponentName::class)
      ->set('name', 'New Crop')
      ->call('save')
      ->assertHasNoErrors()
      ->assertRedirect('/crops');
  ```

## Rules & Standards
- **Alpine.js Integration:** Use Alpine.js (`wire:ignore`, `x-data`) for purely client-side UI details (like opening dropdowns or modals) to avoid unnecessary server round-trips.
- **Tailwind CSS:** Keep the styling in line with Agrotrack's design tokens (use standard Tailwind classes).
- **Security:** Always authorize actions inside the Livewire component using standard Laravel gates or policies. Never trust client-provided IDs directly without authorization checks.
