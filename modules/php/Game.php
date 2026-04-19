<?php
/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * MemoryCards implementation : © krishnashed <krishnashed@boardgamearena.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * Game.php
 *
 * This is the main file for your game logic.
 *
 * In this PHP file, you are going to defines the rules of the game.
 */
declare(strict_types=1);

namespace Bga\Games\MemoryCards;

class Game extends \Bga\GameFramework\Table
{
    public static array $CARD_TYPES;

    public function __construct()
    {
        parent::__construct();

        self::$CARD_TYPES = [
            1 => ["name" => clienttranslate("Red"), "color" => "ff0000"],
            2 => ["name" => clienttranslate("Green"), "color" => "008000"],
            3 => ["name" => clienttranslate("Blue"), "color" => "0000ff"],
            4 => ["name" => clienttranslate("Yellow"), "color" => "ffff00"],
            5 => ["name" => clienttranslate("Orange"), "color" => "ffa500"],
            6 => ["name" => clienttranslate("Purple"), "color" => "800080"],
            7 => ["name" => clienttranslate("Cyan"), "color" => "00ffff"],
            8 => ["name" => clienttranslate("Pink"), "color" => "ffc0cb"],
        ];
    }

    public function getGameProgression()
    {
        $totalCards = static::getUniqueValueFromDB("SELECT count(*) FROM `card` WHERE `card_location` = 'grid'");
        if ($totalCards == 0) return 100;

        $solvedCards = static::getUniqueValueFromDB("SELECT count(*) FROM `card` WHERE `card_location` = 'grid' AND `card_state` = 2");
        return (int) (($solvedCards / $totalCards) * 100);
    }

    public function upgradeTableDb($from_version)
    {
        // Ensure all required columns exist in card table.
        // This handles cases where the Studio DB is out of sync (e.g. during development).
        $columns = static::getCollectionFromDB("SHOW COLUMNS FROM `card` ");
        $columnNames = array_map(fn($c) => $c['Field'], $columns);

        if (!in_array('card_color', $columnNames)) {
            static::DbQuery("ALTER TABLE `card` ADD COLUMN `card_color` INT NOT NULL DEFAULT 0");
        }
        if (!in_array('card_state', $columnNames)) {
            static::DbQuery("ALTER TABLE `card` ADD COLUMN `card_state` INT NOT NULL DEFAULT 0");
        }
    }

    protected function getAllDatas(int $currentPlayerId): array
    {
        $result = [];
        $result["players"] = $this->getCollectionFromDB(
            "SELECT `player_id` AS `id`, `player_score` AS `score`, `player_color` AS `color`, `player_name` AS `name` FROM `player`"
        );

        // Get all cards from the grid.
        $cards = static::getCollectionFromDB("SELECT `card_id` AS `id`, `card_color` AS `color`, `card_location_arg` AS `pos`, `card_state` AS `state` FROM `card` WHERE `card_location` = 'grid'");

        // Hide colors for face-down cards.
        foreach ($cards as &$card) {
            if ($card['state'] == 0) {
                $card['color'] = null; // Secret!
            }
        }

        $result["cards"] = $cards;
        $result["card_types"] = self::$CARD_TYPES;

        return $result;
    }

    protected function setupNewGame($players, $options = [])
    {
        $this->upgradeTableDb(0);

        $gameinfos = $this->getGameinfos();
        $default_colors = $gameinfos['player_colors'];

        foreach ($players as $player_id => $player) {
            $query_values[] = vsprintf("(%s, '%s', '%s')", [
                $player_id,
                array_shift($default_colors),
                addslashes($player["player_name"]),
            ]);
        }

        static::DbQuery(
            sprintf(
                "INSERT INTO `player` (`player_id`, `player_color`, `player_name`) VALUES %s",
                implode(",", $query_values)
            )
        );

        $this->reattributeColorsBasedOnPreferences($players, $gameinfos["player_colors"]);
        $this->reloadPlayersBasicInfos();

        // Setup the initial grid: 4x4 (16 cards).
        $numPairs = 8;
        $positions = range(0, 15);
        shuffle($positions);

        $cardsToInsert = [];
        for ($colorId = 1; $colorId <= $numPairs; $colorId++) {
            // Two cards for each color.
            for ($i = 0; $i < 2; $i++) {
                $pos = array_pop($positions);
                $cardsToInsert[] = sprintf("(%d, 'grid', %d, 0)", $colorId, $pos);
            }
        }

        static::DbQuery(
            sprintf(
                "INSERT INTO `card` (`card_color`, `card_location`, `card_location_arg`, `card_state`) VALUES %s",
                implode(",", $cardsToInsert)
            )
        );

        $this->activeNextPlayer();

        return States\FirstSelection::class;
    }

    /**
     * Example of debug function.
     * Here, jump to a state you want to test (by default, jump to next player state)
     * You can trigger it on Studio using the Debug button on the right of the top bar.
     */
    public function debug_goToState(int $state = 3) {
        $this->gamestate->jumpToState($state);
    }

    /**
     * Another example of debug function, to easily test the zombie code.
     */
    public function debug_playOneMove() {
        $this->bga->debug->playUntil(fn(int $count) => $count == 1);
    }

    /*
    Another example of debug function, to easily create situations you want to test.
    Here, put a card you want to test in your hand (assuming you use the Deck component).

    public function debug_setCardInHand(int $cardType, int $playerId) {
        $card = array_values($this->cards->getCardsOfType($cardType))[0];
        $this->cards->moveCard($card['id'], 'hand', $playerId);
    }
    */
}
