<?php

declare(strict_types=1);

namespace Bga\Games\MemoryCards\States;

use Bga\GameFramework\StateType;
use Bga\GameFramework\States\GameState;
use Bga\GameFramework\States\PossibleAction;
use Bga\GameFramework\UserException;
use Bga\Games\MemoryCards\Game;

class FirstSelection extends GameState
{
    function __construct(
        protected Game $game,
    ) {
        parent::__construct($game,
            id: 10,
            type: StateType::ACTIVE_PLAYER,
        );
    }

    public function getArgs(): array
    {
        return [
            "selectableCards" => $this->game->getCollectionFromDb("SELECT `card_id` FROM `card` WHERE `card_state` = 0")
        ];
    }

    #[PossibleAction]
    public function actFlipCard(int $cardId, int $activePlayerId)
    {
        $card = $this->game->getNonEmptyObjectFromDb("SELECT `card_id` AS `id`, `card_color` AS `color`, `card_state` AS `state` FROM `card` WHERE `card_id` = $cardId");

        if ($card['state'] != 0) {
            throw new UserException(clienttranslate("This card is already flipped or solved."));
        }

        // Update card state to Face-up.
        static::DbQuery("UPDATE `card` SET `card_state` = 1 WHERE `card_id` = $cardId");

        // Notify players.
        $this->bga->notify->all("cardFlipped", clienttranslate('${player_name} flipped a card'), [
            "player_id" => $activePlayerId,
            "player_name" => $this->game->getPlayerNameById($activePlayerId),
            "card_id" => $cardId,
            "color" => $card['color'],
        ]);

        return SecondSelection::class;
    }

    function zombie(int $playerId) {
        $args = $this->getArgs();
        $cardIds = array_keys($args['selectableCards']);
        $zombieChoice = $cardIds[array_rand($cardIds)];
        return $this->actFlipCard($zombieChoice, $playerId);
    }
}
