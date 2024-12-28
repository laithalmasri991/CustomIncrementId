<?php

namespace Laith\CustomIncrementId\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class AddCustomSequences implements DataPatchInterface
{
    private $moduleDataSetup;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        // Define custom sequences
        $entities = [
            'order' => 'sales_order',
            'invoice' => 'sales_invoice',
            'creditmemo' => 'sales_creditmemo',
        ];

        foreach ($entities as $entityName => $tableName) {
            $sequenceTableName = $this->moduleDataSetup->getTable('sequence_' . $tableName);
            if (!$this->moduleDataSetup->getConnection()->isTableExists($sequenceTableName)) {
                $table = $this->moduleDataSetup->getConnection()->newTable(
                    $sequenceTableName
                )->addColumn(
                    'sequence_value',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Sequence Value'
                );

                $this->moduleDataSetup->getConnection()->createTable($table);
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
