# Permission Configuration

- `config/roles.php` is the source of truth for permission groups, descriptions, scopes, and role assignments.
- Whenever `config/roles.php` changes, run `php artisan db:seed --class=RolesAndPermissionsSeeder --no-interaction` so the database permissions and role assignments stay synchronized.
- Permission UIs should use the grouped config metadata instead of presenting a flat permission list.