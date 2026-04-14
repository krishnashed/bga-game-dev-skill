<?php
/**
 * BGA Studio: Backend Patterns (PHP)
 * 
 * PSR-4 Namespace: Bga\Games\YourGameName
 */

namespace Bga\Games\YourGameName;

use Bga\GameFramework\Actions\PossibleAction;
use Bga\GameFramework\Actions\JsonParam;
use Bga\GameFramework\States\StateType;
use Bga\GameFramework\States\GameState;
use Bga\GameFramework\NotificationMessage;

/**
 * 1. MODERN STATE CLASS PATTERN
 */
class PlayCardState extends GameState {
    public function getType(): StateType {
        return StateType::ACTIVE_PLAYER;
    }

    public function getDescription(): string {
        return clienttranslate('${actplayer} must play a card');
    }

    public function getDescriptionMyTurn(): string {
        return clienttranslate('${you} must play a card');
    }

    public function getArgs(): array {
        return [
            'hand' => $this->game->cards->getCardsInLocation('hand', $this->getActivePlayerId()),
            '_no_notify' => true, // Prevents "active player change" banner blinking
        ];
    }

    #[PossibleAction]
    public function actPlayCard(#[JsonParam] array $cardIds): void {
        $this->game->checkAction('actPlayCard');
        // Logic...
        $this->nextState('NextPlayer');
    }
}

/**
 * 2. SECURE RANDOMIZATION WRAPPERS
 */
trait RandomUtils {
    public function bga_shuffle(array &$array): void {
        $size = count($array);
        for ($i = $size - 1; $i > 0; $i--) {
            $j = bga_rand(0, $i);
            $tmp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $tmp;
        }
    }

    public function bga_pick(array $array): mixed {
        if (empty($array)) return null;
        $keys = array_keys($array);
        return $array[$keys[bga_rand(0, count($keys) - 1)]];
    }
}

/**
 * 3. NOTIFICATION DECORATORS (Constructor)
 */
// In Game.php __construct:
// $this->bga->notify->addDecorator(function(string $message, array $args) {
//     // Auto-resolve player name if player_id is present but player_name is missing
//     if (isset($args['player_id']) && !isset($args['player_name']) && str_contains($message, '${player_name}')) {
//         $args['player_name'] = $this->getPlayerNameById($args['player_id']);
//     }
//     return $args;
// });

/**
 * 4. COMPLEX NOTIFICATION WITH i18n
 */
// $this->bga->notify->all('playCard', 
//     clienttranslate('${player_name} plays ${card_name}'), 
//     [
//         'i18n' => ['card_name'], // Tells client to translate this arg
//         'player_id' => $playerId,
//         'card_name' => $card['name'], // Original English string from Material.php
//         'preserve' => ['card_id'] // Keep card_id in history log for F5 reloads
//     ]
// );

/**
 * 5. DATABASE MIGRATION (upgradeTableDb)
 */
// public function upgradeTableDb($from_version) {
//     if ($from_version <= 2024010100) {
//         // Add a column to the card table
//         $sql = "ALTER TABLE `card` ADD `card_is_flipped` TINYINT(1) NOT NULL DEFAULT '0'";
//         self::applyDbUpgrade($sql);
//     }
// }
