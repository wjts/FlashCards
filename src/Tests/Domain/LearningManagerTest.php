<?php
namespace Feft\FlashCards\Tests\Domain;

use Feft\FlashCards\Domain\FlashCard;
use Feft\FlashCards\Domain\FlashCardsCollection;
use Feft\FlashCards\Domain\LearningManager;
use Feft\FlashCards\Interfaces\LearningManagerInterface;
use PHPUnit\Framework\TestCase;
use Feft\FlashCards\Services\ShuffleCardService;
use Feft\FlashCards\Tests\FlashCardsProvider;

class LearningManagerTest extends TestCase
{
    public function testIfClassExists()
    {
        $learningManager = new LearningManager(new ShuffleCardService());
        $this->assertInstanceOf(LearningManager::class, $learningManager);
        $this->assertInstanceOf(LearningManagerInterface::class, $learningManager);
    }

    public function testAddingCardsToLearningBox()
    {
        $lm = new LearningManager(new ShuffleCardService());
        $collection1 = $this->getFlashCards(3);
        $lm->addCardsToLearningBox($collection1);
        $this->assertEquals($collection1->count(), $lm->countLearningBox());

        $collection2 = $this->getFlashCards(4);
        $lm->addCardsToLearningBox($collection2);
        $this->assertEquals($collection1->count() + $collection2->count(), $lm->countLearningBox());
    }

    public function testShuffleWhenUsedAtLeastTwoElements()
    {
        $lm = new LearningManager(new ShuffleCardService());
        $collection1 = $this->getFlashCards(3);
        $lm->addCardsToLearningBox($collection1);
        $lm->shuffleCards();
        # sometimes (eg. when array is small) is possible that shuffle php function
        # doesn't change elements order
        # and hand made order changing is needed
        $collection2 = $this->getFlashCards(3);
        $lm->addCardsToLearningBox($collection2);
        $lm->shuffleCards();

        $this->assertNotEquals($collection1->getArray() + $collection2->getArray(), $lm->getLearningBox()->getArray());
    }

    public function testDecreaseLearningBoxWhenMoveCardToLearned()
    {
        $amountOfCards = 6;
        $lm = new LearningManager(new ShuffleCardService());
        $collection1 = $this->getFlashCards($amountOfCards);
        $lm->addCardsToLearningBox($collection1);
        $elementToLearn = $lm->getCard();
        $this->assertEquals($amountOfCards - 1, $lm->countLearningBox());
        $lm->moveCardToLearnedBox($elementToLearn);
        $this->assertEquals(1, $lm->countLearned());
    }

    /**
     * @author PP
     */
    public function testThrowWhenGetCardFromEmptyLearningBox()
    {
        $this->expectException(\LogicException::class);
        $lm = new LearningManager(new ShuffleCardService());
        $lm->getCard();
    }

    /**
     * Prepare collection of cards.
     *
     * @param int $amount how many cards is needed
     * @author PP
     * @return FlashCardsCollection
     */
    private function getFlashCards(int $amount): FlashCardsCollection
    {
        return FlashCardsProvider::getFlashCards($amount);
    }
}
