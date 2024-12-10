<?php
/*******************************************************************************
 * ADOBE CONFIDENTIAL
 * ___________________
 *
 * Copyright 2024 Adobe
 * All Rights Reserved.
 *
 * NOTICE: All information contained herein is, and remains
 * the property of Adobe and its suppliers, if any. The intellectual
 * and technical concepts contained herein are proprietary to Adobe
 * and its suppliers and are protected by all applicable intellectual
 * property laws, including trade secret and copyright laws.
 * Adobe permits you to use and modify this file
 * in accordance with the terms of the Adobe license agreement
 * accompanying it (see LICENSE_ADOBE_PS.txt).
 * If you have received this file from a source other than Adobe,
 * then your use, modification, or distribution of it
 * requires the prior written permission from Adobe.
 ******************************************************************************/

namespace CasioUk\Websites\Model;

use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\ResourceModel\Group;
use Magento\Store\Model\ResourceModel\Store;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\WebsiteFactory;

class CreateWebsite
{
    /**
     * @var WebsiteFactory
     */
    private WebsiteFactory $websiteFactory;

    /**
     * @var Website
     */
    private Website $websiteResourceModel;

    /**
     * @var StoreFactory
     */
    private StoreFactory $storeFactory;

    /**
     * @var GroupFactory
     */
    private GroupFactory $groupFactory;

    /**
     * @var Group
     */
    private Group $groupResourceModel;

    /**
     * @var Store
     */
    private Store $storeResourceModel;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $eventManager;

    /**
     * WebsitesCreator constructor.
     * @param WebsiteFactory $websiteFactory
     * @param Website $websiteResourceModel
     * @param Store $storeResourceModel
     * @param Group $groupResourceModel
     * @param StoreFactory $storeFactory
     * @param GroupFactory $groupFactory
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        WebsiteFactory $websiteFactory,
        Website $websiteResourceModel,
        Store $storeResourceModel,
        Group $groupResourceModel,
        StoreFactory $storeFactory,
        GroupFactory $groupFactory,
        ManagerInterface $eventManager
    ) {
        $this->websiteFactory = $websiteFactory;
        $this->websiteResourceModel = $websiteResourceModel;
        $this->storeFactory = $storeFactory;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $groupResourceModel;
        $this->storeResourceModel = $storeResourceModel;
        $this->eventManager = $eventManager;
    }

    /**
     * @param $websiteInfo
     */
    public function createWebsite($websiteInfo): void
    {
        try {
            $website = $this->websiteFactory->create();
            $website->load($websiteInfo['website_code']);

            $group = $this->groupFactory->create();

            if (!$website->getId()) {
                $website->setCode($websiteInfo['website_code']);
                $website->setName($websiteInfo['website_name']);
                $website->setDefaultGroupId(1);
                $this->websiteResourceModel->save($website);

                $group->setWebsiteId($website->getWebsiteId());
                $group->setName($websiteInfo['group_name']);
                $group->setCode($websiteInfo['group_code']);
                $group->setRootCategoryId(2);
                $group->setDefaultStoreId(1);
                $this->groupResourceModel->save($group);
            }

            $store = $this->storeFactory->create();
            $store->load($websiteInfo['store_code']);
            if (!$store->getId() && $website->getId() && $group->getId()) {
                $store->setCode($websiteInfo['store_code']);
                $store->setName($websiteInfo['store_name']);
                $store->setWebsite($website);
                $store->setGroup($group);
                $store->setIsActive(1);
                $this->storeResourceModel->save($store);
                $this->storeResourceModel->addCommitCallback(function () use ($store) {
                    $this->eventManager->dispatch('store_add', ['store' => $store]);
                });
            }
        } catch (\Exception $e) {
            // Continue
        }

    }
}
