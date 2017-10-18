<?php
namespace frontend\models\api\v1\tariffs\discount;


use frontend\models\api\v1\tariffs\Tariff;

/**
 * Class DiscountPercent was created for Tariff to make a discount
 *
 * Usage:
 *
 * ```php
 * $discount = new DiscountValue(1000);
 * $tariff->applyDiscount($discount);
 *
 * $cost_with_discount = $tariff->getTotalCost();
 * ```
 */
class DiscountValue extends DiscountAbstract
{
    public function calculate(Tariff $tariff)
    {
        $this->calculate_value = $this->getValue();

        $cost = $tariff->getTotalCost() // cost of tariff
            - $this->calculate_value; // value of discount

        $tariff->setTotalCost( $cost );
        return $this;
    }
}