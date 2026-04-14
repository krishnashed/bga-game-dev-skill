# MemoryCards - Board Game Arena Implementation

A classic memory game (Concentration/Pairs) implemented on the Board Game Arena (BGA) platform.

## About the Game

**MemoryCards** is a digital adaptation of the timeless memory-testing card game. Players take turns flipping two cards from a hidden grid, searching for pairs with matching colors and labels.

### How to Play

1.  **Objective:** Collect the most pairs of matching cards.
2.  **On Your Turn:**
    *   Flip one card to reveal its color/label.
    *   Flip a second card.
3.  **Matches:** If the two cards match, you score a point and get another turn. The matched cards remain face-up.
4.  **Mismatches:** If the cards do not match, they are flipped back face-down, and the turn passes to the next player.
5.  **Game End:** The game ends when all pairs have been found. The player with the most points wins.

---

## Technical Overview & Development

This project was developed using the **`bga-game-dev-skill`** (BGA Studio Expert), leveraging modern 2025/2026 development patterns for the BGA platform.

### Development with `bga-game-dev-skill`

The project was built following the **Research -> Strategy -> Execution** lifecycle, guided by the specialized BGA development agent. Key highlights include:

*   **Modern Backend Architecture:**
    *   Utilizes **PHP 8+ Attributes** (e.g., `#[PossibleAction]`) for clean, declarative state management.
    *   Implements **PSR-4 Namespaced State Classes** located in `modules/php/States/`, moving away from monolithic switch statements in `Game.php`.
*   **Modern Frontend (ESM):**
    *   The frontend logic in `modules/js/Game.js` is built using **ES Modules (ESM)**.
    *   Implements a modular state-based UI controller for handling card interactions and game transitions.
*   **Asynchronous Communication:**
    *   Leverages **Async/Await** in notifications (`notif_cardFlipped`, `notif_matchFound`, etc.) to ensure smooth animations and timing without "callback hell."
    *   Uses Promise-based synchronization between the server state and client-side UI.
*   **Standardized Data Model:**
    *   A clean `dbmodel.sql` implementing the "Tokens" pattern for game pieces, ensuring reliable persistence of card states (Face-down, Face-up, Solved).

### Project Structure

*   `modules/php/States/`: PHP State classes defining the game's core logic.
*   `modules/js/Game.js`: The ESM entry point for the client-side game interface.
*   `dbmodel.sql`: Database schema for cards and game state.
*   `gameinfos.inc.php`: Meta-information and player configuration.
*   `memorycards.css`: Styling for the 3D card flip effects and responsive grid layout.

---

*This project is a demonstration of modern BGA Studio development practices.*
