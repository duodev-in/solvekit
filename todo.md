# Design A Calculator Migration

All 106 registered calculators use the shared Design A frame (`resources/views/components/calc/`),
with conversion factors in `config/units.php` and calculation code in `resources/js/calc/`.
Tests: `php artisan test` (factors, pages, labels) and `npm run test:js` (calculation logic).

- [x] Shared frame, components, runtime and unit engine
- [x] Length & Area (12)
- [x] Volume & Weight (20)
- [x] Engineering & Technical (11), Speed & Motion (5), Energy & Power (6)
- [x] Number (8), Number System (6), Data & Technical (7)
- [x] Time & Date (5), Specialized Measurement (8), Currency & Financial (4), Digital & Technical (5), Utility & General (5)
- [x] Geographic & Mapping (4)
- [x] Old tool layout removed; tools index rendered from config with category anchors

## Open items

- [ ] Install the PHP sqlite driver (`php8.3-sqlite3`) so the 12 database-backed tests run locally
- [ ] Remove password hashes already stored in `audit_logs` before the Auditable fix
- [ ] Add the missing social preview images (`public/images/og-image.jpg`, `twitter-image.jpg`)
- [ ] Add a privacy policy page (required for AdSense)
