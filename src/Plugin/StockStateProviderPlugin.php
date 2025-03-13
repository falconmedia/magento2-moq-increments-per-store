<?php

declare(strict_types=1);

namespace FalconMedia\MoqIncrementsPerStore\Plugin;

use Magento\CatalogInventory\Model\StockStateProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class StockStateProviderPlugin
{
    protected $storeManager;
    protected $scopeConfig;

    public function __construct(StoreManagerInterface $storeManager, ScopeConfigInterface $scopeConfig)
    {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundGetMinSaleQty(StockStateProvider $subject, callable $proceed, $productId, $stockId)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $minQty = $this->scopeConfig->getValue('cataloginventory/item_options/min_sale_qty', 'stores', $storeId);

        return $minQty !== null ? (float) $minQty : $proceed($productId, $stockId);
    }

    public function aroundGetEnableQtyIncrements(StockStateProvider $subject, callable $proceed, $productId, $stockId)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $EnableQtyIncrement = $this->scopeConfig->getValue('cataloginventory/item_options/enable_qty_increments', 'stores', $storeId);

        return $EnableQtyIncrement !== null ? (float) $minQty : $proceed($productId, $stockId);
    }

    public function aroundGetQtyIncrements(StockStateProvider $subject, callable $proceed, $productId, $stockId)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $qtyIncrement = $this->scopeConfig->getValue('cataloginventory/item_options/qty_increments', 'stores', $storeId);

        return $qtyIncrement !== null ? (float) $qtyIncrement : $proceed($productId, $stockId);
    }
}
