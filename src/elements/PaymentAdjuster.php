<?php

namespace pdaleramirez\superpaymentadjuster\elements;

use Craft;
use craft\base\Element;
use craft\elements\db\ElementQueryInterface;
use craft\helpers\UrlHelper;
use pdaleramirez\superpaymentadjuster\elements\db\PaymentAdjusterQuery;
use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster as PaymentAdjusterRecord;
use yii\base\Exception;

class PaymentAdjuster extends Element
{
    public $name;
    public $handle;
    public $gatewayHandle;
    public $description;
    public $method;
    public $type;
    public $amountType;
    public $baseAmount;
    public $percentAmount;

    public function __toString()
    {
        return (string) $this->title ?: (string) $this->id;
    }

    public static function hasTitles(): bool
    {
        return true;
    }

    public static function hasContent(): bool
    {
        return true;
    }

    public function getCpEditUrl()
    {
        return UrlHelper::cpUrl('super-payment-adjuster/payment-adjusters/edit/' . $this->id);
    }

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('super-payment-adjuster', 'Payment Adjuster');
    }

    public static function find(): ElementQueryInterface
    {
        return new PaymentAdjusterQuery(static::class);
    }

    /**
     * @inheritdoc
     */
    protected static function defineSources(string $context = null): array
    {
        return [
            [
                'key' => '*',
                'label' => Craft::t('super-payment-adjuster', 'All Payment Adjusters')
            ]
        ];
    }

    protected static function defineTableAttributes(): array
    {
        return [
            'title' => ['label' => Craft::t('super-payment-adjuster', 'Title')],
            'dateCreated' => ['label' => Craft::t('super-payment-adjuster', 'Date Created')]
        ];
    }

    public static function hasStatuses(): bool
    {
        return true;
    }


    /**
     * @inheritdoc
     */
    protected static function defineSortOptions(): array
    {
        $attributes = [
            'elements.dateCreated' => Craft::t('super-payment-adjuster', 'Date Created')
        ];

        return $attributes;
    }

    public function afterSave(bool $isNew)
    {
        if (!$isNew) {
            $record = PaymentAdjusterRecord::findOne($this->id);

            if (!$record) {
                throw new Exception('Invalid payment adjuster ID: ' . $this->id);
            }
        } else {
            $record = new PaymentAdjusterRecord();
            $record->id = $this->id;
        }

        $record->name = $this->name;
        $record->handle = $this->handle;
        $record->gatewayHandle = $this->gatewayHandle;
        $record->description = $this->description;
        $record->method = $this->method;
        $record->type = $this->type;
        $record->amountType = $this->amountType;
        $record->baseAmount = abs($this->baseAmount);
        $record->percentAmount = abs($this->percentAmount);
        $record->save(false);

        $this->id = $record->id;

        parent::afterSave($isNew); // TODO: Change the autogenerated stub
    }

    public function getMethods(): array
    {
        return [
            PaymentAdjusterRecord::METHOD_ADD => "Add Cost",
            PaymentAdjusterRecord::METHOD_DEDUCT => "Deduct Cost",
        ];
    }

    public function getAmountTypes(): array
    {
        return [
            PaymentAdjusterRecord::AMOUNT_FLAT => "Flat Amount Off Order",
            PaymentAdjusterRecord::AMOUNT_PERCENT => "Percentage Off %"
        ];
    }
}
