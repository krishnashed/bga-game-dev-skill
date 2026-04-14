# BGA Studio: Bots & AI (Automa)

This reference covers the implementation of automated players, primarily for solo modes or "zombie" replacements.

## 1. The "Automa" Player Pattern
Since you cannot add fake players to the framework's `player` table, you must track them in a custom table.

**`dbmodel.sql`:**
```sql
CREATE TABLE IF NOT EXISTS `playerextra` (
 `player_id` int(10) unsigned NOT NULL,
 `player_name` varchar(32) NOT NULL,
 `player_color` varchar(6) NOT NULL,
 `player_no` int(10) NOT NULL,
 `player_score` int(10) NOT NULL DEFAULT '0',
 `player_ai` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## 2. Backend Integration (PHP)
Wrap framework methods to handle both real and bot players.

**`Game.php` Wrappers:**
```php
public function getPlayerName(int $playerId): string {
    if ($playerId <= 10) return _('Automa'); // Reserved bot IDs
    return $this->getPlayerNameById($playerId);
}

public function loadPlayersWithBots(): array {
    $players = $this->loadPlayersBasicInfos();
    $bots = $this->getCollectionFromDb("SELECT * FROM playerextra");
    return $players + $bots;
}
```

## 3. Bot Logic in States
Use the `zombie()` method in State Classes to simulate bot turns.

**State Class:**
```php
public function zombie(int $playerId): void {
    $args = $this->getArgs();
    // Level 1: Random Choice
    $choice = $args['possibleMoves'][bga_rand(0, count($args['possibleMoves']) - 1)];
    
    // Level 2: Greedy (Best immediate points)
    // $choice = $this->game->getBestMoveForBot($playerId);

    $this->actPlayCard($choice, $playerId); // Reuse action logic
}
```

## 4. Frontend UI (JS)
Bots need a visual presence in the player panels.

**`Game.js` Setup:**
```javascript
// In setup():
if (gamedatas.automa) {
    this.bga.playerPanels.addAutomataPlayerPanel(0, 'Automa', {
        iconClass: 'automa-avatar',
        score: gamedatas.automa.score,
        color: '000000'
    });
}
```

## 5. Implementation Rules
- **No `getCurrentPlayerId()`**: Inside bot logic, always use the passed `$playerId`.
- **Notifications**: Send `player_id` with the bot's ID so the UI knows where to animate from.
- **`getAllDatas`**: Must include bot data in the `players` key for the UI to initialize correctly.
