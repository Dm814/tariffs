<?php
namespace frontend\models\api\v1\tariffs\discount;


use frontend\models\api\v1\tariffs\Tariff;

/**
 * Class DiscountMonth was created for Tariff to make a discount, value is amount of month
 *
 * Usage:
 *
 * ```php
 * $discount = new DiscountMonth(1);
 * $tariff->applyDiscount($discount);
 *
 * $cost_with_discount = $tariff->getTotalCost();
 * ```
 */
class DiscountMonth extends DiscountAbstract
{
    public function calculate(Tariff $tariff)
    {
        $cost = $tariff->getTotalCost() // actual cost of tariff
                    * (1 - $this->getValue() / $tariff->getCountMonthPaid()); // count of months to pay

        $tariff->setTotalCost($cost);
        $tariff->setCountMonthPaid($tariff->getCountMonthPaid() - $this->getValue());

        return $this;
    }
}