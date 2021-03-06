<?php

/**
 * Upgrade - 1.0.0.53 to 1.0.0.54
 * 
 * Adding custom tax attributes to quotes & orders
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$conn = $installer->getConnection();
/* @var $conn Varien_Db_Adapter_Pdo_Mysql */

// Quote / Order Goods totals
$conn->modifyColumn($installer->getTable('sales/quote'), 'bsv_goods_total', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Goods Total'
));

$conn->modifyColumn($installer->getTable('sales/quote'), 'bsv_goods_total_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Goods Total Incl. Tax'
));

$conn->modifyColumn($installer->getTable('sales/order'), 'bsv_goods_total', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Goods Total'
));

$conn->modifyColumn($installer->getTable('sales/order'), 'bsv_goods_total_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Goods Total Incl. Tax'
));

// Quote / Order Carriage Amount

$conn->modifyColumn($installer->getTable('sales/order'), 'bsv_carriage_amount', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Carriage Amount'
));

$conn->modifyColumn($installer->getTable('sales/order'), 'bsv_carriage_amount_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Carriage Amount Incl. Tax'
));

$conn->modifyColumn($installer->getTable('sales/quote'), 'bsv_carriage_amount', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Carriage Amount'
));

$conn->modifyColumn($installer->getTable('sales/quote'), 'bsv_carriage_amount_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Carriage Amount Incl. Tax'
));

// Quote / Order Grand Total

$conn->modifyColumn($installer->getTable('sales/quote'), 'bsv_grand_total', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Grand Total'
));

$conn->modifyColumn($installer->getTable('sales/quote'), 'bsv_grand_total_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Grand Total Incl. Tax'
));

$conn->modifyColumn($installer->getTable('sales/order'), 'bsv_grand_total', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Grand Total'
));

$conn->modifyColumn($installer->getTable('sales/order'), 'bsv_grand_total_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Grand Total Incl. Tax'
));

// Quote / Order Item line price

$conn->modifyColumn($installer->getTable('sales/quote_item'), 'bsv_price', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Item Price'
));

$conn->modifyColumn($installer->getTable('sales/quote_item'), 'bsv_price_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Item Price Incl. Tax'
));

$conn->modifyColumn($installer->getTable('sales/order_item'), 'bsv_price', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Item Price'
));

$conn->modifyColumn($installer->getTable('sales/order_item'), 'bsv_price_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Item Price Incl. Tax'
));

// Quote / Order Item line value

$conn->modifyColumn($installer->getTable('sales/quote_item'), 'bsv_line_value', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Line Value'
));

$conn->modifyColumn($installer->getTable('sales/quote_item'), 'bsv_line_value_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Line Value Incl. Tax'
));

$conn->modifyColumn($installer->getTable('sales/order_item'), 'bsv_line_value', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Line Value'
));

$conn->modifyColumn($installer->getTable('sales/order_item'), 'bsv_line_value_inc', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'BSV Line Value Incl. Tax'
));

$conn->modifyColumn($installer->getTable('sales/quote_item'), 'epicor_original_price', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'Original Price'
));

$conn->modifyColumn($installer->getTable('sales/order_item'), 'epicor_original_price', array(
    'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'length' => '12,4',
    'comment' => 'Original Price'
));

$installer->endSetup();
