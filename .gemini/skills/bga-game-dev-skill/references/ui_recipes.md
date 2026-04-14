# BGA Studio: UI Recipes & CSS Patterns

This reference contains copy-pasteable CSS and JS snippets for common UI challenges on Board Game Arena.

## 1. High-DPI / Retina Images
Use `@2x.png` sprites for high-resolution displays.

**CSS Media Query:**
```css
.piece {
    background-image: url('img/pieces.png');
    background-size: 240px 320px; /* Original size */
}

@media (-webkit-min-device-pixel-ratio: 2), (min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .piece {
        background-image: url('img/pieces@2x.png');
    }
}
```

**JS Setup (Selective Loading):**
```javascript
setup: function (gamedatas) {
    const isRetina = "(-webkit-min-device-pixel-ratio: 2), (min-device-pixel-ratio: 2), (min-resolution: 192dpi)";
    if (window.matchMedia(isRetina).matches) {
        this.bga.images.dontPreloadImage('pieces.png');
    } else {
        this.bga.images.dontPreloadImage('pieces@2x.png');
    }
}
```

## 2. Dynamic CSS Sprites
Map data attributes to sprite positions using `calc()`.

**HTML:**
```html
<div class="card" data-suit="H" data-rank="10"></div>
```

**CSS:**
```css
.card {
   background-image: url('img/cards.jpg');
   background-size: 1500% auto; /* 15 columns */
   aspect-ratio: 1 / 1.4;
}

.card[data-rank="10"] {
   background-position-x: calc(100% / (15 - 1) * (10 - 2)); /* (rank - first_rank_in_sprite) */
}

.card[data-suit="H"] {
   background-position-y: calc(100% / (4 - 1) * 1); /* row 1 for Hearts */
}
```

## 3. Drop Shadows (Advanced)
Use `filter: drop-shadow` for irregular shapes (PNGs).

**CSS:**
```css
.meeple {
    filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.5));
}

/* User preference to disable for performance */
.no-shadow .meeple {
    filter: none !important;
}
```

**Shadows with `clip-path`:**
Shadows won't work on the same element as `clip-path`. Wrap it:
```html
<div class="shadow-wrap">
    <div class="clipped-hex"></div>
</div>
```
```css
.shadow-wrap { filter: drop-shadow(0 0 5px #000); }
.clipped-hex { clip-path: polygon(50% 0, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }
```

## 4. Responsive Board Scaling
Auto-scale a large board (e.g., 1400px wide) to fit smaller viewports.

**HTML Template:**
```html
<div id="game-container">
    <div id="scaled-board" style="width: 1400px;">
        <!-- Board Content -->
    </div>
</div>
```

**JS Scaling Logic:**
```javascript
setZoom: function (zoom) {
  const board = document.getElementById("scaled-board");
  if (zoom === 1) {
    board.style.removeProperty("transform");
    board.style.removeProperty("width");
  } else {
    board.style.transform = `scale(${zoom})`;
    board.style.transformOrigin = "0 0";
    board.style.width = `${100 / zoom}%`;
  }
  this.onScreenWidthChange();
}
```

## 5. Hex Tile Grid
CSS-only hex shape with clip-path.

**CSS:**
```css
.hex {
  width: 100px;
  aspect-ratio: 1 / 1.119;
  background-color: #ffd700;
  clip-path: polygon(50% 0, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
  cursor: pointer;
}

.hex:hover { filter: brightness(1.2); }
```
