<?php
namespace tests\codeception\frontend\models\api\v1\tariff;


use Codeception\Test\Unit;
use frontend\models\api\v1\tariffs\config\Config;
use frontend\models\api\v1\tariffs\discount\DiscountMonth;
use frontend\models\api\v1\tariffs\discount\DiscountPercent;
use frontend\models\api\v1\tariffs\discount\DiscountValue;
use frontend\models\api\v1\tariffs\Tariff;

class DiscountTest extends Unit
{
    /**
     * @var \tests\codeception\frontend\UnitTester
     */
    protected $tester;
    /**
     * @var Tariff
     */
    private $tariff;

    protected function _before()
    {
        $this->tariff = new Tariff(Config::TARIFF_EXPERT);
        $this->tariff
            ->setCountMonth(12)
            ->setCountUser(1)
            ->calculate();
    }

    protected function _after()
    {
    }

    // tests
    public function testDiscountPercent()
    {
        $this->tariff
            ->applyDiscount(new DiscountPercent(10));

        $this->assertTrue(
            $this->tariff->getTotalCost() == $this->tariff->getCost() * 0.9
        );
    }

    public function testDiscountMonth()
    {
        $this->tariff
            ->applyDiscount(new DiscountMonth(2));

        $this->assertTrue(
            $this->tariff->getTotalCost() == $this->tariff->getCost() * 10 / 12
        );
    }

    public function testDiscountValue()
    {
        $this->tariff
            ->applyDiscount(new DiscountValue(100));

        $this->assertTrue(
            $this->tariff->getTotalCost() == $this->tariff->getCost() - 100
        );
    }

    public function testDiscountMultiple()
    {
        $this->tariff
            ->applyDiscount(new DiscountValue(100))
            ->applyDiscount(new DiscountPercent(10))
            ->applyDiscount(new DiscountMonth(1));

        $this->assertTrue(
            $this->tariff->getTotalCost() == ($this->tariff->getCost() - 100) * 0.9 * 11 / 12
        );
    }

    public function testDiscount2Month()
    {
        $this->tariff
            ->applyDiscount(new DiscountMonth(1))
            ->applyDiscount(new DiscountMonth(1));

        $this->assertTrue(
            $this->tariff->getTotalCost() == $this->tariff->getCost() * 10 / 12
        );
    }
}