# BGA Studio: Advanced UI Components (JS)

This reference covers specialized and extended UI components provided by the BGA framework.

## 1. Extended Stock Components
- **`ebg/complexstock`**: Extends `ebg/stock` to support mixed types and custom item templates.
- **`ebg/sortablestock`**: Extends `ebg/stock` with built-in sorting logic based on attributes.

**Setup:**
```javascript
const [complexstock, sortablestock] = await importDojoLibs(['ebg/complexstock', 'ebg/sortablestock']);
```

---

## 2. Scrollmap & Scrollmap Plus
For infinite boards (e.g., Carcassonne).

- **`ebg/scrollmap`**: Basic infinite board with panning and scrolling.
- **`Scrollmap Plus` (Shared Code)**: Improved implementation from the `patchwork` game. Supports single-direction carousels and improved touch panning.

**Setup:**
```javascript
const [scrollmap] = await importDojoLibs(['ebg/scrollmap']);
this.scrollmap = new ebg.scrollmap();
this.scrollmap.create($('container'), $('scrollable'), $('surface'), $('oversurface'));
```

---

## 3. BGA Action Buttons
Use `this.bga.statusBar` for modern framework buttons.

**Advanced Parameters:**
```javascript
this.bga.statusBar.addActionButton(_('Confirm'), () => this.onAction(), {
    color: 'primary',
    confirm: _('Are you sure?'), // Integrated confirmation
    autoclick: { pausable: true }, // Built-in timer for auto-pass
    tooltip: _('Explain the action'),
    disabled: this.isDisabled()
});
```

---

## 4. Draggable (Legacy)
**Recommendation:** Use the **Pointer Events API** or **HTML5 Drag and Drop** for modern projects.

**Pointer Events Example (Shared Code):**
```javascript
// Register a meeple as draggable on the surface
this.bga.draggable.register(nodeId, {
    onStart: (id) => { ... },
    onDrag: (id, x, y) => { ... },
    onEnd: (id, x, y) => { ... }
});
```

---

## 5. UI Helpers
- **`BgaAutofit`**: Auto-scale text to fit boxes (e.g., card text).
- **`BgaScoreSheet`**: Animated end-game scoring table.
- **`ExpandableSection`**: Collapsible UI blocks (e.g., Player board sections).
