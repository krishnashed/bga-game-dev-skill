/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * MemoryCards implementation : © krishnashed <krishnashed@boardgamearena.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 * 
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

class Selection {
    constructor(game, bga) {
        this.game = game;
        this.bga = bga;
    }

    onEnteringState(args, isCurrentPlayerActive) {
        this.bga.statusBar.setTitle(isCurrentPlayerActive ? 
            _('${you} must select a card') :
            _('${actplayer} must select a card')
        );
    }

    onLeavingState(args, isCurrentPlayerActive) {}

    onCardClick(card_id) {
        if (!this.bga.states.isCurrentPlayerActive()) return;

        this.bga.actions.performAction("actFlipCard", { 
            cardId: card_id,
        });        
    }
}

export class Game {
    constructor(bga) {
        this.bga = bga;

        // Register states.
        const selectionState = new Selection(this, bga);
        this.bga.states.register('FirstSelection', selectionState);
        this.bga.states.register('SecondSelection', selectionState);
    }
    
    setup( gamedatas ) {
        this.gamedatas = gamedatas;

        // Create the grid.
        this.bga.gameArea.getElement().insertAdjacentHTML('beforeend', `
            <div id="game_container">
                <div id="memory_grid"></div>
            </div>
        `);

        // Sort cards by position.
        const sortedCards = Object.values(gamedatas.cards).sort((a, b) => a.pos - b.pos);

        sortedCards.forEach(card => {
            this.renderCard(card);
        });
        
        this.setupNotifications();
    }

    renderCard(card) {
        const grid = document.getElementById('memory_grid');
        let classes = 'memory_card';
        let style = '';
        let colorName = '';

        if (card.state == 1) classes += ' flipped';
        if (card.state == 2) classes += ' solved flipped';

        if (card.color !== null) {
            const type = this.gamedatas.card_types[card.color];
            style = `background-color: #${type.color};`;
            colorName = type.name;
        }

        grid.insertAdjacentHTML('beforeend', `
            <div id="card_${card.id}" class="${classes}" data-id="${card.id}">
                <div class="card_back">?</div>
                <div class="card_front" style="${style}">${colorName}</div>
            </div>
        `);

        document.getElementById(`card_${card.id}`).addEventListener('click', () => {
            const state = this.bga.states.getCurrentState();
            if (state && (state.name === 'FirstSelection' || state.name === 'SecondSelection')) {
                state.instance.onCardClick(card.id);
            }
        });
    }

    setupNotifications() {
        this.bga.notifications.setupPromiseNotifications({
            // logger: console.log
        });
    }

    async notif_cardFlipped(args) {
        const cardId = args.card_id;
        const color = args.color;
        const type = this.gamedatas.card_types[color];
        
        const cardEl = document.getElementById(`card_${cardId}`);
        const frontEl = cardEl.querySelector('.card_front');
        
        frontEl.style.backgroundColor = `#${type.color}`;
        frontEl.innerText = type.name;
        
        cardEl.classList.add('flipped');
        
        await new Promise(resolve => setTimeout(resolve, 500));
    }

    async notif_matchFound(args) {
        const cardIds = args.card_ids;
        
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        cardIds.forEach(id => {
            document.getElementById(`card_${id}`).classList.add('solved');
        });
    }

    async notif_mismatch(args) {
        const cardIds = args.card_ids;
        
        // Brief memorization window.
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        cardIds.forEach(id => {
            document.getElementById(`card_${id}`).classList.remove('flipped');
        });
    }
}
