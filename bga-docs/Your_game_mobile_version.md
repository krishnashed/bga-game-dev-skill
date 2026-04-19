# Your game mobile version

**URL:** https://en.doc.boardgamearena.com/Your_game_mobile_version

---

__Game File Reference__

__Overview__

- __dbmodel.sql__ - database model
- __gameinfos.inc.php__ - meta-information
- __gameoptions.json__ - game options & user preferences
- __img/__ - game art
- __Game Metadata Manager__ - tags and metadata media
- __material.inc.php__ - static data
- __misc/__ - studio-only storage
- __modules/__ - additional game code
- __States/__ - State classes
- __states.inc.php__ - state machine
- __stats.json__ - statistics
- X.__action.php__ - player actions
- X__.css__ - interface stylesheet
- __Game.php__ - main logic
- __Game.js__ - interface logic
- X.__view.php__ - dynamic game layout
- X_X.__tpl__ - static game layout

---

__Useful Components__

__Official__

- Deck: a PHP component to manage cards (deck, hands, picking cards, moving cards, shuffle deck, ...).
- PlayerCounter and TableCounter: PHP components to manage counters.
- Draggable: a JS component to manage drag'n'drop actions.
- Counter: a JS component to manage a counter that can increase/decrease (ex: player's score).
- ExpandableSection: a JS component to manage a rectangular block of HTML than can be displayed/hidden.
- Scrollmap: a JS component to manage a scrollable game area (useful when the game area can be infinite. Examples: Saboteur or Takenoko games).
- Stock: a JS component to manage and display a set of game elements displayed at a position.
- Zone: a JS component to manage a zone of the board where several game elements can come and leave, but should be well displayed together (See for example: token's places at Can't Stop).
- bga-animations : a JS component for animations.
- bga-cards : a JS component for cards.
- bga-dice : a JS component for dice.
- bga-autofit : a JS component to make text fit on a fixed size div.
- bga-score-sheet : a JS component to help you display an animated score sheet at the end of the game.

__Unofficial__

- BGA Code Sharing - Shared resources, projects on git hub, common code, other links
- BGA Studio Cookbook - Tips and instructions on using API's, libraries and frameworks
- Common board game elements image resources

---

__Game Development Process__

- First steps with BGA Studio
- Create a game in BGA Studio: Complete Walkthrough
- Tutorial reversi
- Tutorial hearts
- BGA Studio Guidelines
- BGA game Lifecycle
- Pre-release checklist
- Post-release phase
- Player Resources - add player help/rules to your game page

---

__Guides for Common Topics__

- Translations - make your game translatable
- Game Replay
- Mobile Users
- Compatibility

---

__Miscellaneous Resources__

- Studio FAQ
- Tools and tips of BGA Studio - Tips and instructions on setting up development environment
- Studio logs - Instructions for log access
- Practical debugging - Tips focused on debugging
- Troubleshooting - Most common "I am really stuck" situations
- Studio Bugs - Reports against Studio itself (not BGA!)

## Contents

- 1 Declare your interface minimum width
  - 1.1 Autoscale
- 2 Touchscreen compatibility
- 3 Viewport <meta> tag

Board Game Arena is now adaptated for Mobiles and Tablets too.

It is very easy to have a mobile version of the game you developed with BGA Studio. In fact, your game is probably already 100% playable on mobile.

However, to provide your players the best experience, you should follow the two piece of advice below.

## Declare your interface minimum width

By default, your game can run in a window of up to 740 pixels wide. Including the information in the right column (player's panel), it fits on a 1024px wide screen.

However, you can choose to declare that your game is able to run with a smaller width. This way, the game will appear much better on mobile screens and tablets.

For example, the Reversi board is only 540px wide. If we stay with the default width (740px), the game interface displayed on mobile will be too large and some space will be lost on the left and on the right. Consequently the Reversi board will appear very small on the mobile screen, and players will have to "pinch & zoom" to display it correctly.

To avoid that, we can specify that the game can be played with an interface with a minimum width of 540 pixels, by adding the following to __gameinfos.inc.php__ :

```
 // Game interface width range (pixels)
 // Note: game interface = space on the left side, without the column on the right
 'game_interface_width' => array(
 
   // Minimum width
   //  default: 740
   //  maximum possible value: 740 (i.e. your game interface should fit with a 740px width, corresponding to a 1024px screen)
   //  minimum possible value: 320 (the lower the value you specify, the better the display is on mobile)
   'min' => 540,
 ),
```

And that's it! Now, BGA can choose the better display for your game interface, whatever the device.

__Important__

If you declare that your interface can run with a 540 pixels width, it must effectively run on an interface with 540 pixels width.

Note that this doesn't mean that your interface must _always_ be 540 pixels width; you just have to make your interface fluid and/or use CSS media queries to fit any width.

Under 490, player panels aren't on 2 columns on mobile, so you probably shouldn't go under 490.

Examples :

- On __Can't Stop__, when the screen is too narrow, we move the dice on another position (below the main board) to fit within the width :

```
 @media only screen and (max-width: 990px) {
 
   #dicechoices {
       left: 180px;
       top: 530px;
   }
   #cantstop_wrap {
       height: 900px;
       width: 550px;
   }
 }
```

- On Seasons, we have some panels on the right of the board. On small screens, we display these panels below the board:

```
 @media only screen and (max-width: 970px) {
 
   #board {
       float: none;
       margin: auto;
   }
   .seasons_rightpanel {
       margin-left: 0px;
   }
 
 }
```

Tip: on mobile, BGA displays player panels at the top of the page (instead of displaying them on the right). When doing this, BGA applies the CSS class "mobile_version" to the root HTML element with id "ebd-body". If you want you can use this CSS "mobile_version" class to optimize some of your game adaptations to this change. In the opposite, when the "normal" version is active, the CSS class "desktop_version" BGA applies the CSS class "desktop_version" to the root HTML element with id "ebd-body".

### Autoscale

There is an option in `game_interface_width`, called `autoscale`, than can be `true`, `false` or `viewport`

- autoscale: true -> it sets CSS zoom property on player panels, title bar, and game area
- autoscale: false -> it sets CSS zoom property on player panels, title bar, but NOT and game area. Some devs disabled it with `zoom: 1 !important`, now they can remove the hack and use this framework flag instead :)

- autoscale: 'viewport' -> use native viewport (it makes chat button and bar very small)

currently, the default autoscale value is 'true'

```
 'game_interface_width' => [
   "autoscale" => true
  ...
```

Discussion about this option in https://discord.com/channels/753304735615811584/1276225578797633536

## Touchscreen compatibility

Most of your games should work with touchscreen devices without needing any changes.

Note: when your game is running on a touchscreen device, the global CSS class "touch-device" is added to the to the root HTML element with id "ebd-body" (and "notouch-device" is added for the opposite).

Special cases:

__CSS :hover__

Because there is no mouse, ":hover" won't be triggered. This is not an issue unless it is needed to play the game. In addition, some touch devices consider that a short touch must trigger a ":hover" (and should apply corresponding CSS), which can block an interaction in your game. We advise you to explicitely disable ":hover" effects when your game is running on a touchscreen device (for ex. by adding ".notouch-device" as a prefix to all your CSS :hover rules).

__Tooltips__

Tooltips generally do not work properly on mobile, if important consider alternative implementation

__Mouse events__

If you use "onmouseover" or other mouse events, it won't work on mobile devices. Use pointer events.

__Drag'n'drop__

Not considering some old ways here is basically two ways of doing it:

- Use pointer events Pointer Events API
  - code pen https://codepen.io/VictoriaLa/pen/MWOgYYZ
  - game: Century

- Use native drag and drop HTML Drag and Drop
  - code pen https://codepen.io/VictoriaLa/pen/rNGXKxj
  - game: Patchwork

Note that you may need to add the CSS property `touch-action: none` on elements where you listen for touch events, in order to prevent the browser from interpreting the touch as a request to scroll/zoom the page.

## Viewport <meta> tag

```
Disclaimer: the infamouse chrome update 128 changed zoom implementation (properly below), as a result framework code was changed (Sep 2024) and text below may not be applicable. 
Please follow discussion on dev discord for now  and update wiki if you have more information. There is autoscale option in 'game_interface_width' to mitigate some of the zoom issues.
```

Mobile is an area where the BGA framework is very much showing its age. The built-in handling for mobile is incredibly unsatisfying because the framework was designed for a previous era, before mobile became the predominant form of web browsing (mobile has outpaced desktop browsing since 2016).

The most obvious problem is that the BGA framework uses the non-standard "zoom" CSS property to resize your game for the mobile screen. The proper method is the viewport <meta> tag, which is supported by all mobile browsers and offers more control. You can disable BGA's broken "zoom" feature with the following code:

In gameinfos.inc.php

(that is probably already there, just make sure min is set to minimum value)

```
    'game_interface_width' => [
        'min' => 550,
    ],
```

In yourgame.js

```
  return declare("bgagame.yourgame", ebg.core.gamegui, {
    setup: function (gamedatas) {
      // Set mobile viewport for portrait orientation based on gameinfos.inc.php
      this.default_viewport = "width=" + this.interface_min_width;
      this.onScreenWidthChange();
      
      ...
    },
    
    // To be overrided by games
    onScreenWidthChange: function () {
      // Remove broken "zoom" property added by BGA framework
      this.gameinterface_zoomFactor = 1;
      $("page-content").style.removeProperty("zoom");
      $("page-title").style.removeProperty("zoom");
      $("right-side-first-part").style.removeProperty("zoom");
    },
```

Note that in landscape orientation, the BGA framework always sets the viewport to "width=980". Overriding the viewport for landscape orientation is much more complicated (requires overriding undocumented framework functions), so it is not recommended.

This code you cannot really test in desktop browser because bga framework with check window.orientation field which is likely not set on desktop, if you want to test on desktop (and override landscape viewport) you can add this code and the end of onScreenWidthChange. I suggest to remove it after testing

```
  var viewport = document.querySelector('meta[name="viewport"]');
  if (viewport) {
     viewport.content = this.default_viewport;
  }
```
