<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace pdaleramirez\superpaymentadjuster\elements\db;

use craft\elements\db\ElementQuery;



class PaymentAdjusterQuery extends ElementQuery
{

    /**
     * @inheritdoc
     */
    protected function beforePrepare(): bool
    {
        $this->joinElementTable('superpaymentadjuster_payment_adjuster');

        $this->query->select([
            'superpaymentadjuster_payment_adjuster.id',
            'superpaymentadjuster_payment_adjuster.name',
            'superpaymentadjuster_payment_adjuster.handle',
            'superpaymentadjuster_payment_adjuster.description',
            'superpaymentadjuster_payment_adjuster.gatewayHandle',
            'superpaymentadjuster_payment_adjuster.method',
            'superpaymentadjuster_payment_adjuster.type',
            'superpaymentadjuster_payment_adjuster.amountType',
            'superpaymentadjuster_payment_adjuster.baseAmount',
            'superpaymentadjuster_payment_adjuster.percentAmount'
        ]);

        return parent::beforePrepare();
    }
}
