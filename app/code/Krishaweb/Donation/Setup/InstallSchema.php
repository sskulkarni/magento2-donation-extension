<?php

namespace Krishaweb\Donation\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {

    public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'posts'
         */
         $setup->getConnection()->addColumn(
              $setup->getTable('quote'),
              'donation_amount',
              [
                  'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                  'nullable' => true,
                  'comment' => 'Donation Amount',
             ]
        );

        $installer->endSetup();
    }
}