<?php
namespace Tests\Domain;

include_once "autoload.php";

use Domain\LearningManager;
use Interfaces\LearningManagerInterface;
use PHPUnit\Framework\TestCase;

class LearningManagerTest extends TestCase
{
    public function testIfClassExists()
    {
        $learningManager = new LearningManager();
        $this->assertInstanceOf(LearningManager::class, $learningManager);
        $this->assertInstanceOf(LearningManagerInterface::class, $learningManager);
    }

    public function testAddingCardsToLearningBox()
    {
        $lm = new LearningManager();
        $array1 = [0, 1, 2];
        $lm->addCardsToLearningBox($array1);
        $this->assertEquals(count($array1), $lm->countLearningBox());

        $array2 = [0, 1, 2, 3, 4];
        $lm->addCardsToLearningBox($array2);
        $this->assertEquals(count($array1) + count($array2), $lm->countLearningBox());

    }

    /**
     * Sometimes the shuffled array is identical
     */
    public function testShuffle()
    {
        $lm = new LearningManager();
        $array1 = [0, 1, 2, 3];
        $lm->addCardsToLearningBox($array1);
        $lm->shuffleCards();

        if (count($array1) < 2) {
            $this->assertTrue(true);
        } else {
            # array_intersect_assoc returns identical elements from both arrays:
            # keys and values are used to comparison
            $this->assertNotEquals(count($array1), count(array_intersect_assoc($array1, $lm->getLearningBox())));
        }
    }

}