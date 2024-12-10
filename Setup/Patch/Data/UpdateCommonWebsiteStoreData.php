<?php

namespace CasioUk\Websites\Setup\Patch\Data;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;

class UpdateCommonWebsiteStoreData implements DataPatchInterface
{
    /**
     * @var ResourceConnection
     */
    private ResourceConnection $resourceConnection;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * Constructor.
     *
     * @param ResourceConnection $resourceConnection
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        StoreManagerInterface $storeManager
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->storeManager = $storeManager;
    }

    /**
     * Apply data patch.
     *
     * @return void
     * @throws LocalizedException
     */
    public function apply(): void
    {

        $connection = $this->resourceConnection->getConnection();
        $storeManager = $this->storeManager;

        // Load main website, store, and store view
        $mainWebsite = $storeManager->getWebsite('base');
        $mainStoreGroup = $storeManager->getGroup($mainWebsite->getDefaultGroupId());
        $mainStore = $storeManager->getStore($mainStoreGroup->getDefaultStoreId());

        // Rename and update codes
        $connection->update(
            $this->resourceConnection->getTableName('store_website'),
            ['name' => 'Common Website', 'code' => 'common'],
            ['website_id = ?' => $mainWebsite->getId()]
        );

        $connection->update(
            $this->resourceConnection->getTableName('store_group'),
            ['name' => 'Common Store', 'code' => 'common_store'],
            ['group_id = ?' => $mainStoreGroup->getId()]
        );

        $connection->update(
            $this->resourceConnection->getTableName('store'),
            [
                'name' => 'Common Store View',
                'code' => 'common_store_view'
            ],
            ['store_id = ?' => $mainStore->getId()]
        );
    }

    /**
     * Get aliases for the patch.
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Get dependencies for the patch.
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
