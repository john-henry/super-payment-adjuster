<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace pdaleramirez\superpaymentadjuster\elements\db;

//use craft\elements\db\ElementQuery;
use craft\db\Query;


class PaymentAdjusterQuery extends ElementQuery
{

    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        $this->joinElementTable('payment_adjuster');

        $this->query->select([
            'payment_adjuster.id',
            'payment_adjuster.name',
            'payment_adjuster.handle',
            'payment_adjuster.description',
            'payment_adjuster.gatewayHandle',
            'payment_adjuster.method',
            'payment_adjuster.type',
            'payment_adjuster.amountType',
            'payment_adjuster.baseAmount',
            'payment_adjuster.percentAmount'
        ]);

        return parent::beforePrepare();
    }
}
