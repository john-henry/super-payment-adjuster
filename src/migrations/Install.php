<?php
/**
 * Super Payment Adjuster plugin for Craft CMS 3.x
 *
 * Add shipping or order cost based on the payment method selected
 *
 * @link      https://github.com/pdaleramirez
 * @copyright Copyright (c) 2020 Dale Ramirez
 */

namespace pdaleramirez\superpaymentadjuster\migrations;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;
use pdaleramirez\superpaymentadjuster\records\PaymentAdjuster;

/**
 * @author    Dale Ramirez
 * @package   SuperPaymentAdjuster
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;$this->createTables();
        $this->createIndexes();

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%payment_adjuster}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%payment_adjuster}}',
                [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(),
                    'handle' => $this->string(),
                    'description' => $this->text(),
                    'gatewayHandle' => $this->string(),
                    'method' => $this->string()->defaultValue('paymentAdjusterMethodAdd'),
                    'type' => $this->string()->defaultValue('shipping'),
                    'amountType' => $this->string()->defaultValue('baseAmount'),
                    'baseAmount' => $this->decimal(14, 4)->notNull()->defaultValue(0),
                    'percentAmount' => $this->decimal(14, 4)->notNull()->defaultValue(0),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid()
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(null, '{{%payment_adjuster}}', 'handle', true);
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        // payment_adjuster table
        $this->dropTableIfExists('{{%payment_adjuster}}');
    }
}
