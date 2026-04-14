/**
 * BGA Studio: Frontend Patterns (JS/TS)
 * 
 * ES Module (Modern Framework)
 */

import { GameBase } from "ebg/core/GameBase";

export class Game extends GameBase {
    /**
     * 1. ESM ASYNC SETUP
     */
    async setup(gamedatas) {
        // Load libraries asynchronously
        const BgaAnimations = await importEsmLib('bga-animations', '1.x');
        const BgaCards = await importEsmLib('bga-cards', '1.x');

        // Create animation manager
        this.animationManager = new BgaAnimations.Manager({
            animationsActive: () => this.bga.gameui.bgaAnimationsActive(),
        });

        // Initialize Card Manager (with type-casting for sorting)
        this.cardsManager = new BgaCards.Manager({
            animationManager: this.animationManager,
            getId: (card) => card.id,
            setupFrontDiv: (card, div) => {
                // Ensure gamedatas numeric props are Number for calculation
                const type = Number(card.type);
                const typeArg = Number(card.type_arg);
                div.classList.add(`card_type_${type}`);
                div.style.backgroundPosition = `...`; // Dynamic calculation
            }
        });

        // Initialize HandStock
        this.playerHand = new BgaCards.HandStock(this.cardsManager, document.getElementById('my-hand'));
        this.playerHand.addCards(Object.values(gamedatas.hand)); // Use Object.values for map -> array

        // Notifications
        this.setupNotifications();
    }

    /**
     * 2. ASYNC NOTIFICATION HANDLING
     */
    setupNotifications() {
        // Register synchronous notification with dynamic duration
        this.bga.notifications.subscribe('playCard', (notif) => this.notif_playCard(notif));
        this.bga.gameui.notifqueue.setSynchronous('playCard');
    }

    async notif_playCard(notif) {
        const card = notif.args.card;
        // Run animation and await it
        await this.playerHand.removeCard(card);
        await this.tableStock.addCard(card);
        
        // Finalize notification (release queue)
        this.bga.gameui.notifqueue.setSynchronousDuration(500);
    }

    /**
     * 3. DIALOGS & ACTION BUTTONS
     */
    onUpdateActionButtons(stateName, args) {
        if (stateName === 'DiscardCardState') {
            this.bga.statusBar.addActionButton(_('Confirm Discard'), () => {
                const selected = this.playerHand.getSelection();
                if (selected.length === 0) {
                    this.bga.dialogs.showMessage(_('Select a card first!'), 'error');
                } else {
                    this.performAction('actDiscard', { cardIds: selected.map(c => c.id) });
                }
            }, {
                color: 'primary',
                confirm: _('Are you sure?') // Integrated confirmation
            });
        }
    }

    /**
     * 4. LOG INJECTION (Override bgaFormatText)
     */
    bgaFormatText(text, args) {
        // Custom logic to replace ${card_name} with an image/icon in the log
        if (args && args.card_id) {
            const iconHtml = `<div class="card-icon card_type_${args.card_type}"></div>`;
            return text.replace('${card_name}', iconHtml + args.card_name);
        }
        return super.bgaFormatText(text, args);
    }
}
