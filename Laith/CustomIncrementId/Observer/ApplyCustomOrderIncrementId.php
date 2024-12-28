<?php

namespace Laith\CustomIncrementId\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ApplyCustomOrderIncrementId implements ObserverInterface
{
    protected $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        $isEnabled = $this->scopeConfig->getValue(
            'custom_increment_id/general_settings/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $orderPrefix = $this->scopeConfig->getValue(
            'custom_increment_id/general_settings/order_prefix',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if ($isEnabled) {
            $order = $observer->getEvent()->getOrder();
            $incrementId = $order->getIncrementId();

            // Check if the prefix is already applied
            if (strpos($incrementId, $orderPrefix) !== 0) {
                $order->setIncrementId($orderPrefix . $incrementId);
            }
        }
    }
}
