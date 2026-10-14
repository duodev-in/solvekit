# Project Rules

## UI patterns

- Prefer tabbed detail layouts for show pages when content is long enough to be grouped into separate concerns such as overview, permissions, users, audit activity, or settings.
- Keep the default tab order focused on the primary record summary first, then supporting lists and actions.
- Use compact, side-panel flyouts for account and user actions when the page already provides a full dashboard shell.
- Avoid large border radii in admin UI; use square edges or a minimal `rounded-sm` treatment, and do not use rounded containers for dashboard cards.
- Permission configuration rules are documented in [permissions.md](permissions.md).
- Tool redesign decisions are documented in [tool-ui.md](tool-ui.md).
