<?php
/**
 * Magento 2 Custom Increment ID Module
 *
 * @category   Magento2
 * @package    Laith_CustomIncrementId
 * @author     Laith Almasri
 * @license    MIT
 * @link       https://github.com/laithalmasri991/CustomIncrementId
 */
namespace Laith\CustomIncrementId;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Laith_CustomIncrementId',
    __DIR__
);
