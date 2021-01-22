<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\records;

use pdaleramirez\superpaymentadjuster\db\Table;
use craft\db\ActiveRecord;

/**
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class PaymentAdjuster extends ActiveRecord
{
    const TYPE_SHIPPING = 'paymentAdjusterTypeShipping';
    const TYPE_ORDER = 'paymentAdjusterTypeOrder';
    const METHOD_ADD = 'paymentAdjusterMethodAdd';
    const METHOD_SUBTRACT = 'paymentAdjusterMethodSubtract';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Table::PAYMENT_ADJUSTER;
    }
}
