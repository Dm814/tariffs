<?php
namespace frontend\models\api\v1\tariffs;


use frontend\models\api\v1\tariffs\config\Config;
use frontend\models\api\v1\tariffs\discount\DiscountAbstract;

/**
 * Class Tariff
 *
 * Usage:
 *
 * ```php
 * $tariff = new Tariff(Config::TARIFF_EXPERT);
 * $tariff
 *      ->setCountMonth(12)
 *      ->setCountUser(1)
 *      ->calculate()
 *      ->applyDiscount(new DiscountPercent(10));
 *
 * $total = $tariff->getTotalCost();
 * ```
 */
class Tariff
{
    private $config;
    private $count_month;
    private $count_month_paid = null;
    private $count_user;
    private $cost;
    private $total_cost;

    public function __construct($name)
    {
        $this->config = Config::getTariffConfig($name);
    }

    public function applyDiscount(DiscountAbstract $discount)
    {
        $discount->calculate($this);
        return $this;
    }

    public function calculate()
    {
        $added_price = $this->getAddedPrice();
        $this->cost = $this->count_month * ($this->config['price_month'] + $added_price);

        $this->total_cost = $this->cost;
        return $this;
    }

    private function getAddedPrice()
    {
        if ($this->count_user <= $this->config['count_users']) {
            return 0;
        } else {
            return ($this->count_user - $this->config['count_users']) * $this->config['price_user_added'];
        }
    }

    public function setCountUser($count)
    {
        $this->count_user = $count;
        return $this;
    }

    public function setCountMonth($count)
    {
        $this->count_month = $count;
        return $this;
    }

    public function setCountMonthPaid($count)
    {
        $this->count_month_paid = $count;
        return $this;
    }

    public function setTotalCost($cost)
    {
        $this->total_cost = ($cost < 0) ? 0 : $cost;
        return $this;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getTotalCost()
    {
        return $this->total_cost;
    }

    public function getCountMonth()
    {
        return $this->count_month;
    }

    public function getCountMonthPaid()
    {
        return $this->count_month_paid ?: $this->count_month;
    }

    public function getName()
    {
        return $this->config['name'];
    }

    public function getId()
    {
        return $this->config['id'];
    }
}