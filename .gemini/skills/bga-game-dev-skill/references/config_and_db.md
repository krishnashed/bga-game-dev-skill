# BGA Studio: Configuration & Database Reference

This file contains standard templates for BGA configuration files and database schemas.

## 1. `dbmodel.sql` (Database Schema)
Standard table for cards and generic game tokens.

```sql
-- Standard Deck table
CREATE TABLE IF NOT EXISTS `card` (
  `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_type` varchar(16) NOT NULL,
  `card_type_arg` int(11) NOT NULL,
  `card_location` varchar(32) NOT NULL, -- INCREASED SIZE for player IDs
  `card_location_arg` int(11) NOT NULL,
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Generic Token table (Meeples, resources, dice)
CREATE TABLE IF NOT EXISTS `token` (
  `token_key` varchar(32) NOT NULL,
  `token_location` varchar(32) NOT NULL,
  `token_state` int(10) DEFAULT '0',
  PRIMARY KEY (`token_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Adding custom columns to the player table
ALTER TABLE `player` ADD `player_reserve_size` SMALLINT UNSIGNED NOT NULL DEFAULT '7';
```

## 2. `gameinfos.inc.php` (Metadata & Advanced Features)
Core settings for the game environment.

```php
$gameinfos = array( 
    'game_name' => "MyGame",
    'player_colors' => array( "ff0000", "008000", "0000ff", "ffa500" ),
    'favorite_colors_support' => true,
    'db_undo_support' => true,
    'is_coop' => 0, // Set to 1 for co-op games
    'losers_not_ranked' => false, // Set to true for win/lose games
    'tie_breaker_description' => totranslate("Describe tie breaker formula"),
    
    // LANGUAGE DEPENDENCY (for word games)
    'language_dependency' => false, // or array('en', 'fr')
    
    // SETUP NEW GAME DEFAULTS
    'setup_new_game_default_options' => array( 100 => 1 ),
);
```

## 3. `gameoptions.json` & `gamepreferences.json`
Configuration for game variants and user interface settings.

**`gameoptions.json` (Table-level options):**
```json
[
  {
    "id": 100,
    "name": "Game Variant",
    "values": {
      "1": { "name": "Standard", "description": "Original rules" },
      "2": { "name": "Expert", "description": "Expert rules with more cards" }
    },
    "default": 1
  }
]
```

**`gamepreferences.json` (Per-user UI preferences):**
```json
[
  {
    "id": 201,
    "name": "Card Size",
    "values": {
      "1": { "name": "Standard" },
      "2": { "name": "Large" }
    },
    "default": 1
  }
]
```

## 4. `stats.json` (Statistics)
Definition of game statistics.

```json
{
  "table": {
    "turns_number": {
      "id": 10,
      "name": "Number of turns",
      "type": "int"
    }
  },
  "player": {
    "played_cards": {
      "id": 11,
      "name": "Cards played",
      "type": "int"
    }
  }
}
```
