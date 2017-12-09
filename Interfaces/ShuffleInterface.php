<?php
namespace Interfaces;

use Domain\FlashCardsCollection;

/**
 * Interface to shuffle cards
 *
 * @author PP
 */
interface ShuffleInterface
{
    /**
     * Shuffle cards in the learning box.
     *
     * @param FlashCardsCollection $collection Cards to shuffle
     *
     * @author PP
     * @return mixed
     */
    public function shuffle(FlashCardsCollection $collection);
}