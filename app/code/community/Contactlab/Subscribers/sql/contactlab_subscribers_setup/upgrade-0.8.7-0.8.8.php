<?php


$installer = $this;

$subscribersTable = $installer->getTable('newsletter/subscriber');
$conn = $installer->getConnection();

// Alter subscribers table
$conn->addColumn($subscribersTable,
        'last_updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
            'nullable' => true
        ), 'Updated at');

$installer->run("update $subscribersTable set last_updated_at = utc_timestamp()");