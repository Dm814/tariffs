<?php
namespace frontend\models\api\v1\tariffs\discount;


use frontend\models\api\v1\tariffs\Tariff;

/**
 * Class DiscountPercent was created for Tariff to make a discount, value is amount of percents
 *
 * Usage:
 *
 * ```php
 * $discount = new DiscountPercent(10);
 * $tariff->applyDiscount($discount);
 *
 * $cost_with_discount = $tariff->getTotalCost();
 * ```
 */
class DiscountPercent extends DiscountAbstract
{

    public function calculate(Tariff $tariff)
    {
        $this->calculate_value = $tariff->getTotalCost() * $this->getValue() / 100;

        $cost = $tariff->getTotalCost() // cost of tariff
            - $this->calculate_value; // value of discount

        $tariff->setTotalCost( $cost );

        return $this;
    }
}