<?php
namespace tests\codeception\frontend\models\api\v1\tariff;


use Codeception\Test\Unit;
use frontend\models\api\v1\tariffs\config\Config;
use frontend\models\api\v1\tariffs\Tariff;

class TariffTest extends Unit
{
    /**
     * @var \tests\codeception\frontend\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testTariffExpert()
    {
        $config = Config::get()['expert'];
        $price_month = $config['price_month'];

        $tariff = new Tariff(Config::TARIFF_EXPERT);
        $tariff
            ->setCountMonth(12)
            ->setCountUser(1)
            ->calculate();

        $this->assertTrue(
            $tariff->getCost() == 1 * 12  * $price_month
        );
    }

    public function testTariffCompany()
    {
        $config = Config::get()['company'];
        $price_month = $config['price_month'];

        $tariff = new Tariff(Config::TARIFF_COMPANY);
        $tariff
            ->setCountMonth(12)
            ->setCountUser(1)
            ->calculate();

        $this->assertTrue(
            $tariff->getCost() == 1 * 12  * $price_month
        );
    }

    public function testTariffAgency()
    {
        $config = Config::get()['agency'];
        $price_month = $config['price_month'];

        $tariff = new Tariff(Config::TARIFF_AGENCY);
        $tariff
            ->setCountMonth(12)
            ->setCountUser(1)
            ->calculate();

        $this->assertTrue(
            $tariff->getCost() == 1 * 12  * $price_month
        );
    }
}