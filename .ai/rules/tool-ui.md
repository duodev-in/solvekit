# Tool UI Decisions

- Normalize tool phases to a compact single-column calculator flow with the result directly after the inputs.
- Use a dark, high-contrast calculator header across all normalized phases, including simple Phase 1 and Phase 2 tools.
- Keep answer areas simple: use compact result rows, cap result typography at `2rem`, and allow long values to wrap instead of shrinking or overflowing.
- For tools with a primary value plus from/to unit controls, group those controls in one desktop row and stack them on mobile.
- Remove legacy decorative and duplicated explanatory panels when the shared tool-content panel already explains the tool.
- Keep secondary controls only when they directly affect the calculation; do not retain decorative UI or redundant reference cards.