<?php

namespace Domain;

use Interfaces\LearningManagerInterface;

/**
 * Class LearningManager.
 * Features:
 *  - add cards to learning box
 *  - shuffle cards in the learning box
 *  - show next card (question and answer)
 *  - move learned card to learned box
 */
class LearningManager implements LearningManagerInterface
{
    /**
     * @var FlashCardsCollection
     */
    private $learningBox;

    public function __construct()
    {
        $this->learningBox = new FlashCardsCollection();
    }

    /**
     * Add cards to the learning box.
     *
     * @param $cards FlashCardsCollection Cards to learning
     *
     * @return bool
     */
    public function addCardsToLearningBox(FlashCardsCollection $cards): bool
    {
        foreach ($cards as $card) {
            $this->learningBox->addFlashCard($card);
        }

        return true;
    }

    /**
     * Shuffle cards in the learning box.
     */
    public function shuffleCards()
    {
        # if array size is 0 or 1 exit from function,
        # because it is not possible to change the order this array
        if ($this->learningBox->count() < 2) {
            return;
        }

        # copy of array
        $array = $this->learningBox->getArray();

        $this->learningBox->shuffle();
        # if arrays is identical move first element to the end
        # because when array is small is possible that shuffle php function
        # doesn't change elements order and hand made order changing is needed
        if ($array === $this->learningBox->getArray()) {
            $element = $this->learningBox->removeFirstFlashCard();
            $this->learningBox->addFlashCard($element);
        }
    }

    /**
     * Get card from the learning box.
     *
     * @return FlashCard Card to learning.
     * @throws \LogicException if no card in learning box
     */
    public function getCard(): FlashCard
    {
        if ($this->countLearningBox() > 0) {
            return $this->learningBox->removeFirstFlashCard();
        }
        throw new \LogicException("No card in learning box");
    }

    /**
     * Move learned card to learned box.
     *
     * @param $card FlashCard Card to move
     *
     * @return bool
     */
    public function moveCardToLearnedBox(FlashCard $card): bool
    {
        return true;
    }

    /**
     * @return int size of learning box
     */
    public function countLearningBox(): int
    {
        return $this->learningBox->count();
    }

    public function getLearningBox()
    {
        return $this->learningBox;
    }
}