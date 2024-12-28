<?php

namespace Laith\CustomIncrementId\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;

class ApplyCustomIncrementId implements ObserverInterface
{
    protected $scopeConfig;
    protected $resourceConnection;
    protected $logger;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ResourceConnection $resourceConnection,
        LoggerInterface $logger
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $isEnabled = $this->scopeConfig->getValue(
            'custom_increment_id/general_settings/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $invoicePrefix = $this->scopeConfig->getValue(
            'custom_increment_id/general_settings/invoice_prefix',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($isEnabled && $invoicePrefix) {
            $invoice = $observer->getEvent()->getInvoice();
            $incrementId = $invoice->getIncrementId();

            // Log the current increment ID
            $this->logger->info('Current Invoice Increment ID: ' . $incrementId);

            if (empty($incrementId)) {
                // Generate a new increment ID if missing
                $incrementId = $this->generateNextSequence('sales_invoice');
                $this->logger->info('Generated Missing Increment ID: ' . $incrementId);
            }

            if (strpos($incrementId, $invoicePrefix) !== 0) {
                $numericId = preg_replace('/[^0-9]/', '', $incrementId);

                // Ensure the new increment ID is unique
                $newIncrementId = $invoicePrefix . $numericId;

                if (!$this->isUniqueIncrementId('sales_invoice', $newIncrementId)) {
                    $newIncrementId = $invoicePrefix . $this->generateNextSequence('sales_invoice');
                }

                $invoice->setIncrementId($newIncrementId);

                // Log the new increment ID
                $this->logger->info('New Invoice Increment ID: ' . $newIncrementId);
            }
        }
    }

    private function isUniqueIncrementId($table, $incrementId)
    {
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()
            ->from($this->resourceConnection->getTableName($table))
            ->where('increment_id = ?', $incrementId);

        $result = $connection->fetchOne($select);

        // Log the uniqueness check
        $this->logger->info('Checking uniqueness for Increment ID: ' . $incrementId . ' - Result: ' . ($result ? 'Exists' : 'Unique'));

        return !$result;
    }

    private function generateNextSequence($table)
    {
        $connection = $this->resourceConnection->getConnection();
        $sequenceTable = $this->resourceConnection->getTableName('sequence_' . $table);
        $connection->insert($sequenceTable, []);
        $nextId = $connection->lastInsertId($sequenceTable);

        // Log the generated sequence ID
        $this->logger->info('Generated Next Sequence ID: ' . $nextId);

        return $nextId;
    }
}
