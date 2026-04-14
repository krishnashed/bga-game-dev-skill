# BGA Studio: Quality Standards & Launch Procedures

This guide covers mandatory UX rules, technical checklists, and the lifecycle of a production BGA game.

## 1. The BGA Undo Policy
**NEVER allow undo if:**
- **Player change**: An undo must NEVER switch the active player.
- **Hidden info**: NO hidden or private information has been revealed.
- **Random events**: NO random visible effects (dice, shuffling, draws) have occurred.
- **Multi-player**: Several players have acted between the save and restore points.

**When to Propose Undo:**
- **Misclicks**: Small click zones, close elements, or mobile-specific issues.
- **Complex Turn**: Strategic games where a player can "plan" several actions.
- **"Done" Buttons**: If a turn has multiple sub-actions, use a "Done" button to finalize.

---

## 2. Tutorial Readiness
To ensure a valid tutorial can be built for your game:
- **No Programmatic `ajaxcall`**: NEVER trigger `ajaxcall` or `bgaPerformAction` inside a notification handler. This creates race conditions and breaks the tutorial highlight system.
- **Stable IDs**: Every interface element (div) must have a static, unique ID so tutorial authors can attach comments or highlights to it.
- **No Overlapping**: Avoid large invisible divs covering interactive areas.

---

## 3. Pre-Release Checklist (Exhaustive)

### Backend (PHP)
- [ ] **`getGameProgression()`**: Return a % (0-100).
- [ ] **`zombie()`**: Implementation for Level 0, 1, or 2 (see Backend Patterns).
- [ ] **`giveExtraTime()`**: Call before each turn.
- [ ] **Tie-breaker**: Use `player_score_aux` and `tie_breaker_description`.

### Frontend (JS)
- [ ] **Spectator Mode**: Non-players must see ALL public info and NO private info.
- [ ] **Replay Sync**: Verify the replay works from start to finish.
- [ ] **Namespace Trigram**: Prefix ALL CSS classes with a unique trigram (e.g., `abc_selected`).

---

## 4. Post-Release & Production Issues
- **Hotfixes**: If a critical bug appears in production, use the `applyDbUpgrade()` method inside `upgradeTableDb()` for any schema changes.
- **Database Limits**: The total DB size for each game (including logs) is limited to 64MB. Be conservative with argument data in notifications.
- **Production Logs**: Check `/admin/studio` for DB creation errors or PHP crash logs.

---

## 5. Golden Rule: "Digital-First, Board-Fidelity"
"If a player knows the real board game, they should be able to play your adaptation with zero learning."
Fidelity to the original art is mandatory, but UX should be automated (feeding, resource mapping).
- **Left-click only**: No context menus. No drag-and-drop unless there's a click alternative.
- **Tap Targets**: 32px-44px minimum for mobile.
- **No Blocking Popups**: Automatic popups are forbidden (reserve for tutorials).
