# Tool UI Redesign Phases

## Shared rules

- Keep the calculator as the single primary focus in the left column.
- Use one predictable input-to-result workflow: inputs first, result immediately beside or below them, and secondary reference content after the task.
- Keep the calculator visible on desktop with sticky positioning when its height fits the viewport; allow normal document scrolling for taller tools and all mobile layouts.
- Use the same compact spacing, typography, border treatment, primary color, button treatment, and result hierarchy across every phase.
- Keep explanatory copy short and tool-specific. Explain what the tool accepts, what it returns, and the calculation relationship without filler.
- Keep visible breadcrumbs out of the tool page, but preserve BreadcrumbList schema markup.
- Show up to three related tools from the same category, with optional per-tool overrides when automatic suggestions are not useful.
- Keep FAQ, HowTo, WebApplication, BreadcrumbList, and related-tool schema valid.

## Delivery phases

- [x] Phase 0: Shared page shell, viewport behavior, generated tool content, related tools, and SEO schema foundation.
- [x] Phase 1: Length & Area Conversions (12 tools).
- [x] Phase 2: Volume & Weight Conversions (20 tools).
- [x] Phase 3: Engineering & Technical Conversions (11 tools).
- [x] Phase 4: Geographic & Mapping Tools (4 tools).
- [x] Phase 5: Number Conversion Tools (8 tools).
- [x] Phase 6: Number System Conversion Tools (6 tools).
- [x] Phase 7: Data & Technical Conversion Tools (7 tools).
- [x] Phase 8: Time & Date Conversion Tools (5 tools).
- [x] Phase 9: Specialized Measurement Conversion Tools (8 tools).
- [x] Phase 10: Speed & Motion Conversion Tools (5 tools).
- [x] Phase 11: Energy & Power Conversion Tools (6 tools).
- [x] Phase 12: Currency & Financial Conversion Tools (4 tools).
- [x] Phase 13: Digital & Technical Conversion Tools (5 tools).
- [x] Phase 14: Utility & General Conversion Tools (5 tools).

## Phase 1 acceptance checks

- All 12 Length & Area tools use the same compact calculator treatment.
- Existing calculation scripts and field IDs continue to work.
- Decorative, duplicated explanatory cards are replaced by the shared concise content panel.
- Desktop and mobile layouts have no horizontal overflow.
- The result is visible without requiring a secondary panel or hidden section to be opened.
- The Phase 1 entries in `todo.md` are marked complete only after these checks pass.

## Phase 2 acceptance checks

- All 20 Volume & Weight tools use the same compact single-column calculator treatment.
- Existing calculation scripts and field IDs continue to work, including tools with multiple result values.
- Numeric outputs remain readable when values become long or use scientific notation.
- Desktop and mobile layouts have no horizontal overflow.
- Legacy explanatory card stacks are replaced by the shared concise content panel.
- The Phase 2 entries in `todo.md` are marked complete only after these checks pass.

## Phase 3 acceptance checks

- All 11 Engineering & Technical tools use the same compact single-column calculator treatment.
- Engineering-specific controls such as unit swaps and precision choices remain usable without crowding the result.
- Existing calculation scripts and field IDs continue to work.
- Legacy explanatory and decorative card stacks are removed from the visible page.
- Desktop and mobile layouts have no horizontal overflow, and long outputs remain readable.
- The Phase 3 entries in `todo.md` are marked complete only after these checks pass.
