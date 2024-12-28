<?php
namespace Laith\CustomIncrementId;

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Laith_CustomIncrementId',
    __DIR__
);
