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
- [x] Biology & Nature section (/biology): 120 calculators in 10 categories on the same frame (`config/biology.php`, `resources/js/calc/tools/`)
- [x] Chemistry section (/chemistry): 112 calculators in 9 categories; reference data in `config/elements.php` and `config/chemistry_data.php` (sources cited in each file)
- [x] Construction section (/construction): 135 calculators in 9 categories; reference data in `config/construction_data.php` (Caterpillar, USDA Wood Handbook, ASME B36.10M, ASTM A615, NEC, ISO and ASTM tables, sources cited); Board Foot moved here from Biology
- [x] Ecology section (/ecology): 42 calculators in 4 categories (footprints, renewable energy, sustainable living, ecology and environment); data in `config/ecology_data.php` (DESNZ 2025, EPA, Ember via Our World in Data, Poore & Nemecek, FDA, EPA AQI, PVGIS for 260 cities) and `public/data/airports.json` (OurAirports); Biology's Ecology tools moved here
- [x] Everyday Life section (/everyday-life): 210 calculators in 9 categories (time and date, books and reading, transportation, clothing and sewing, home economics, personal hygiene, office and school, leisure and fun, other); data in `config/everyday_data.php` (Chinese New Year 1900–2099, IRS mileage rates, EPA fueleconomy.gov Tesla data, GMAC and College Board percentiles, ENERGY STAR EUI medians and dryer data, Open Library page counts, Wikipedia/Wikidata and TVmaze runtimes, US Mint/ECB/Royal Mint coin weights); shared date, astronomy (Meeus) and text engines in `resources/js/calc/everyday/`
- [x] Finance section (/finance): 605 calculators in 16 categories (business planning, investment, equity, bonds, derivatives, tax and salary, mortgage and real estate, personal finance, debt management, retirement, sales, micro- and macroeconomics, UK, India, other); dated data in `config/finance_data.php` (IRS Rev. Proc. 2025-32, Tax Foundation 2026 state income and sales tax tables, IRS/SSA 2026 limits, HUD/VA/FHFA, HMRC and gov.scot 2026/27, ATO 2026–27, India FY 2026-27 and small savings rates, BLS CPI-U 1913–2026, Census CPS ASEC 2025); engines in `resources/js/calc/finance/` (TVM, loans, formatting); 272 one-formula tools generated into `fin-simple.js`
- [ ] Finance: refresh `config/finance_data.php` each year (tax brackets, state tables, limits, small savings rates each quarter, CPI each January)

## Open items

- [ ] Install the PHP sqlite driver (`php8.3-sqlite3`) so the 12 database-backed tests run locally
- [ ] Remove password hashes already stored in `audit_logs` before the Auditable fix
- [ ] Add the missing social preview images (`public/images/og-image.jpg`, `twitter-image.jpg`)
- [ ] Add a privacy policy page (required for AdSense)
