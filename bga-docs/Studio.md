# Studio - Board Game Arena

**URL:** https://en.doc.boardgamearena.com/Studio

---

## Game File Reference

### Overview

- **dbmodel.sql** - database model
- **gameinfos.inc.php** - meta-information
- **gameoptions.json** - game options & user preferences
- **img/** - game art
- **Game Metadata Manager** - tags and metadata media
- **material.inc.php** - static data
- **misc/** - studio-only storage
- **modules/** - additional game code
- **States/** - State classes
- **states.inc.php** - state machine
- **stats.json** - statistics
- **action.php** - player actions
- **.css** - interface stylesheet
- **Game.php** - main logic
- **Game.js** - interface logic
- **view.php** - dynamic game layout
- **.tpl** - static game layout

---

## Useful Components

### Official

- **Deck**: a PHP component to manage cards (deck, hands, picking cards, moving cards, shuffle deck, ...).
- **PlayerCounter and TableCounter**: PHP components to manage counters.
- **Draggable**: a JS component to manage drag'n'drop actions.
- **Counter**: a JS component to manage a counter that can increase/decrease (ex: player's score).
- **ExpandableSection**: a JS component to manage a rectangular block of HTML than can be displayed/hidden.
- **Scrollmap**: a JS component to manage a scrollable game area (useful when the game area can be infinite. Examples: Saboteur or Takenoko games).
- **Stock**: a JS component to manage and display a set of game elements displayed at a position.
- **Zone**: a JS component to manage a zone of the board where several game elements can come and leave, but should be well displayed together (See for example: token's places at Can't Stop).
- **bga-animations**: a JS component for animations.
- **bga-cards**: a JS component for cards.
- **bga-dice**: a JS component for dice.
- **bga-autofit**: a JS component to make text fit on a fixed size div.
- **bga-score-sheet**: a JS component to help you display an animated score sheet at the end of the game.

### Unofficial

- **BGA Code Sharing** - Shared resources, projects on git hub, common code, other links
- **BGA Studio Cookbook** - Tips and instructions on using API's, libraries and frameworks
- **Common board game elements image resources**

---

## Game Development Process

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

## Guides for Common Topics

- Translations - make your game translatable
- Game Replay
- Mobile Users
- Compatibility

---

## Miscellaneous Resources

- Studio FAQ
- Tools and tips of BGA Studio - Tips and instructions on setting up development environment
- Studio logs - Instructions for log access
- Practical debugging - Tips focused on debugging
- Troubleshooting - Most common "I am really stuck" situations
- Studio Bugs - Reports against Studio itself (not BGA!)

---

## What is Board Game Arena Studio?

**Board Game Arena Studio** is a platform to build online board game adaptations using the Board Game Arena platform.

It is open to any gamer with software development skills :)

BGA Studio website: https://studio.boardgamearena.com

Original announcement on BGA forum: https://forum.boardgamearena.com/viewtopic.php?f=10&t=1973

## Discover BGA Studio in 5 presentations

Why, how, what... to start discovering BGA Studio, we prepared 5 "powerpoint" presentations for you:

- 5 reasons why you should use BGA Studio for your online board game (or Download as PDF)
- The 8 steps to create a board game on Board Game Arena (or Download as PDF)
- The BGA Framework at a glance (or Download as PDF)
- Focus on BGA game state machine (or Download as PDF)
- BGA developers guidelines (or Download as PDF)

## How to join the BGA developer team?

Please see this page: How to join BGA developer team?

## Great, I'm in! ... How should I start?

If you didn't already, check the presentations at the top of this page to get the basics.

Then, you should checkout the First steps with BGA Studio to make sure that runs fine.

After that, we strongly advise you to take one of these game creation tutorials:

- Tutorial reversi (recommended, closest to the actual BGA implementation and maintained by the BGA team) - an abstract strategy game played on an 8x8 uncheckered board for 2 players
- Tutorial hearts - a card game for 4 players

Then start editing files and see what happens! ;)

Once you're done with tutorials, you can start a real game (or join existing project)

- Create a game in BGA Studio: Complete Walkthrough

If you have any questions, please check out the Studio FAQ or Contact BGA Studio.

To search wiki pages on studio enter this text in search bar:

```
 "Category:Studio" white rabbit
```

That is if you want to search for white rabbit

## BGA Studio documentation

### BGA Studio Framework reference

This part of the documentation focuses on the development framework itself: functions and methods available to build your game.

File structure of a BGA game

#### Game logic (Server side)

- Main game logic: Game.php
- Your game state classes: States directory
- Game database model: dbmodel.sql
- Game material description: material.inc.php
- Game statistics: stats.json

#### Game interface (Client side)

- Game interface logic: Game.js
- Game art: img directory
- Game interface stylesheet: yourgamename.css
- Game layout: view and template: yourgamename.view.php and yourgamename_yourgamename.tpl
- Your game mobile version

#### Other components

- Translations (how to make your game translatable)
- Game Options and Preferences
- Game meta-information: gameinfos.inc.php
- Game replay

### BGA Studio game components reference

Game components are useful tools you can use in your game adaptations.

**JS:**

- Counter: a JS component to manage a counter that can increase/decrease (ex: player's score).
- Scrollmap: a JS component to manage a scrollable game area (useful when the game area can be infinite. Examples: Saboteur or Takenoko games).
- Stock: a JS component to manage and display a set of game elements displayed at a position.
- Zone: a JS component to manage a zone of the board where several game elements can come and leave, but should be well displayed together (See for example: token's places at Can't Stop).
- Draggable: a JS component to manage drag'n'drop actions.
- ExpandableSection: a JS component to manage a rectangular block of HTML than can be displayed/hidden.
- Anti-Stock: Code snippets in vanilla JS/HTML5 to do what stock does (that is if you cannot beat Stock into submission)
- bga-animations: a JS component for animations.
- bga-cards: a JS component for cards.
- bga-dice: a JS component for dice.
- bga-autofit: a JS component to make text fit on a fixed size div.
- bga-score-sheet: a JS component to help you display an animated score sheet at the end of the game.

**PHP:**

- Deck: a PHP component to manage cards (deck, hands, picking cards, moving cards, shuffle deck, ...)
- PlayerCounter and TableCounter: php component to manager counters

### BGA Studio user guide

This part of the documentation is a user guide for the BGA Studio online development environment.

**Lifecycle**

- BGA game Lifecycle
- BGA Game licenses
- Create a game in BGA Studio: Complete Walkthrough
- Pre-release checklist - Go throught this list if you think you done development
- Post-release phase

**Tools and Advice**

- BGA Studio Guidelines
- Tutorials checklist
- I wish I knew this when I started - one liners on most common missed features, mistakes, etc with further doc references
- Tools and tips of BGA Studio - Tips and instructions on setting up development environment
  - Setting up BGA Development environment using VSCode
  - Practical debugging - Tips focused on debugging
  - Testing by developer
  - Studio logs - Instructions for log access
  - Troubleshooting - Most common "I am really stuck" situations
- Production issues reporting tool
- BGA Studio Cookbook - Tips and instructions on using API's, libraries and frameworks
  - Using Vue - work-in-progress guide on using the modern framework Vue.js to create a game
  - Using Typescript and Scss - How to auto-build Typescript and SCSS files to make your code cleaner
  - BGA Type Safe Template - Setting up a fully typed project using typescript and more!
  - Bots and Artificial Intelligence - How to add AI/Bots to the game
- BGA Studio Migration Guide - Migration tips from older version of studio framework
- Studio FAQ

**Sharing**

- Common board game elements image resources - Dice, meeples, cubes, etc
- BGA Code Sharing - Shared resources, projects on git hub, common code, other links

## Software Versions

Versions currently used by BGA framework:

- Dojo Toolkit 1.15
- PHP: 8.4
- SQL: MySQL 5.7
- JS/CSS/HTML: limited by what minimization tools support: JS minimization
- Font Awesome: 4.7 https://fontawesome.com/v4.7/icons/ (available as `<i class="fa fa-clock" />`)
- Font Awesome: 6.4.0 https://fontawesome.com/v6/search?o=r&m=free (available as `<i class="fa6 fa6-clock" />`)

### PHP Extensions Used

The following PHP extensions are - as of May 8th, 2022 - in use in BGA Studio and available:

date, libxml, openssl, pcre, zlib, filter, hash, Reflection, SPL, session, standard, sodium, apache2handler, mysqlnd, PDO, xml, apcu, bz2, calendar, ctype, curl, dom, mbstring, FFI, fileinfo, ftp, gd, gettext, gmp, iconv, igbinary, json, exif, msgpack, mysqli, pdo_mysql, apc, posix, readline, shmop, SimpleXML, sockets, sysvmsg, sysvsem, sysvshm, tokenizer, v8js, xmlreader, xmlwriter, xsl, zip, Phar, memcached, Zend OPcache

## Other resources

- Development forum
- Bug tracking system FOR STUDIO issues and APIs
- DISCORD chat server/room invite link https://discord.gg/YxEUacY if it does not work check this topic https://forum.boardgamearena.com/viewtopic.php?f=12&t=17403&hilit=discord
- Developer BLOGS https://bga-devs.github.io/blog/
- BGA Mainsite releases https://en.boardgamearena.com/forum/viewtopic.php?t=23289&start=100
- Contact BGA Studio
