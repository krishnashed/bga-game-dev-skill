# MemoryCards - Board Game Arena Implementation

A classic memory game (Concentration/Pairs) implemented on the Board Game Arena (BGA) platform.

---

## 📺 Gameplay Demo

[![MemoryCards Gameplay Demo](https://img.youtube.com/vi/85roFRfDDZI/0.jpg)](https://www.youtube.com/watch?v=85roFRfDDZI)

_Watch the game in action on YouTube: [MemoryCards Gameplay Demo](https://www.youtube.com/watch?v=85roFRfDDZI)_

---

## 🚀 Overview

**MemoryCards** is a digital adaptation of the timeless memory-testing card game. Players take turns flipping two cards from a hidden grid, searching for pairs with matching colors and labels.

This project was built using **AI** and the [**bga-game-dev-skill**](https://github.com/krishnashed/bga-game-dev-skill) to demonstrate modern, automated development workflows for the BGA platform.

### ✨ Key Features

- **Multiplayer Support:** 2 to 4 players.
- **Interactive 3D Grid:** Smooth CSS-based card flipping animations.
- **Real-time Synchronization:** State-based logic ensures all players see the same board state simultaneously.
- **Responsive Design:** Optimized for various screen sizes.

---

## 🛠️ Technical Implementation

This project leverages modern 2025/2026 development patterns for the BGA Studio environment.

### Built with `bga-game-dev-skill`

The entire logic was orchestrated using a specialized AI agent focused on BGA best practices:

- **Modular State Machine:** Moving away from monolithic PHP files.
- **ESM Frontend:** Modern JavaScript modules (ESM).
- **Automated Validation:** Ensures compliance with BGA framework standards.

### Architecture Highlights

- **Backend (PHP 8+):** Uses Namespaced State Classes in `modules/php/States/` and PHP Attributes for action routing.
- **Frontend (JS ESM):** Asynchronous notification handling with `async/await` for frame-perfect animations.
- **Persistence:** A robust SQL schema in `dbmodel.sql` tracking card states (Hidden, Revealed, Matched).

---

## 📂 Project Structure

- `modules/php/States/`: Backend state logic and transition handlers.
- `modules/js/Game.js`: Frontend ESM controller.
- `dbmodel.sql`: Database schema.
- `memorycards.css`: 3D flip effects and layout.

---

## 📄 License

This project is released under the **Board Game Arena (BGA) License**.
See `LICENCE_BGA` for full details.

_“This code has been produced on the BGA studio platform for use on https://boardgamearena.com”_
