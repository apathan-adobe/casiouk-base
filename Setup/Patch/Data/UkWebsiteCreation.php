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

namespace CasioUk\Websites\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use CasioUk\Websites\Model\CreateWebsite;
use CasioUk\Websites\Model\UkWebsite;

class UkWebsiteCreation implements DataPatchInterface, SchemaPatchInterface
{
    /**
     * @var CreateWebsite
     */
    private CreateWebsite $website;

    /**
     * @var UkWebsite
     */
    private UkWebsite $ukWebsite;

    /**
     * WebsitesCreator constructor.
     * @param CreateWebsite $website
     * @param UkWebsite $ukWebsite
     */
    public function __construct(
        CreateWebsite $website,
        UkWebsite $ukWebsite
    ) {
        $this->website = $website;
        $this->ukWebsite = $ukWebsite;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function apply(): void
    {
        $websiteDetails = $this->getWebsiteDetails();

        foreach ($websiteDetails as $websiteInfo) {
            $this->website->createWebsite($websiteInfo);
        }
    }

    /**
     * @return string[][]
     */
    private function getWebsiteDetails(): array
    {
        return [
            [
                'website_code' => $this->ukWebsite->getWebsiteCode(),
                'website_name' => $this->ukWebsite->getWebsiteName(),
                'group_code' => $this->ukWebsite->getGroupCode(),
                'group_name' => $this->ukWebsite->getGroupName(),
                'store_code' => $this->ukWebsite->getStoreCode(),
                'store_name' => $this->ukWebsite->getStoreName()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
