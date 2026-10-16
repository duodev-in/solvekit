# Tool UI Decisions

Every calculator page (Conversion Tools and Biology & Nature) uses one layout, "Design A (Split Panel)". Build new tools with the same components; do not hand-roll page markup.

## Page frame

- Wrap every tool in `<x-calc.page>` (`resources/views/components/calc/page.blade.php`). It renders breadcrumbs, title and lede, structured data, ads and the related-tools card from `App\Services\CalculatorCatalog`; do not add these by hand.
- Left panel: inputs, then `<x-calc.result>` directly after them, then `<x-calc.options>` (decimals, example chips, reset).
- Right panel (`<x-slot:panel>`): the supporting results only, as `<x-calc.rows>`, `<x-calc.quick-ref>`, `<x-calc.unit-list>` or `<x-calc.grid>`.
- Below both panels: the How it works / Formula / FAQ tabs (from `about`, `how-to`, `faqs` and `<x-slot:formula>`) and the Related tools card, shown at full height. Page scrolling here is fine.
- Desktop splits the panels 7fr / 5fr; phones stack them in the same order.
- Do not add a "How it was worked out" panel to the right side; the How it works and Formula tabs already explain the calculation.

## Components

- Inputs: `x-calc.field` (number, text or date), `x-calc.select`, `x-calc.segmented`, `x-calc.unit-pair`, `x-calc.textarea` (sequences, lists), `x-calc.substance`.
- Results: `x-calc.result`, `x-calc.rows` (fixed labelled values), `x-calc.quick-ref` (lists the script fills), `x-calc.unit-list`, `x-calc.grid` (Punnett squares and other tables).
- Use `data-show-when="field:value1,value2"` to show inputs only for the mode that uses them, rather than separate pages or custom script.
- Long `x-calc.rows` and `x-calc.unit-list` lists collapse to 4 rows below 1024px. Long generated lists use `x-calc.quick-ref :collapse="true"`, which shows 8 rows and a "Show all" button at every width.
- Every select with a default must mark it with `@selected`; config order is not a default.

## Scripts and data

- Pages pass a `calc` config to the shared runtime (`resources/js/calc/core.js`). Pick an engine in `resources/js/calc/engines/` (`units`, `substance`, `number-scale`, `radix`, `geo`, `formula`) instead of writing page scripts.
- Formula tools are pure handlers in `resources/js/calc/tools/*.js` returning `{ value, unit, label, sub, rows, lists, grids }`, or `{ empty }` / `{ error }`. Cover new handlers with unit tests in `resources/js/calc/tests/`.
- Keep reference data in config (`config/units.php`, `config/biology_data.php` and similar), never in views or scripts, and cite its source in a comment.
- Register tools in `config/conversion.php` or `config/biology.php`. Routes, navigation, breadcrumbs, related tools and the section index are derived from there.

## Results and content

- Keep result typography capped and let long values (sequences, dates) wrap rather than shrink or overflow.
- Format money as `$1,234` in the value, not as a trailing unit.
- Every default and example chip must give a real result. When a value is an estimate or a rule of thumb, say so in the result or the About text.
- Do not build veterinary medication-dose or toxicity calculators: their outputs would be clinical recommendations from ranges.
