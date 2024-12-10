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

class UkWebsite
{
    const WEBSITE_CODE = 'uk';
    const WEBSITE_NAME = 'UK Website';
    const GROUP_CODE = 'uk_website_store';
    const GROUP_NAME = 'Casio UK, Inc.';
    const STORE_CODE = 'uk_store_view';
    const STORE_NAME = 'Casio UK Store View';

    /**
     * @return string
     */
    public function getWebsiteCode(): string
    {
        return self::WEBSITE_CODE;
    }

    /**
     * @return string
     */
    public function getWebsiteName(): string
    {
        return self::WEBSITE_NAME;
    }

    /**
     * @return string
     */
    public function getGroupCode(): string
    {
        return self::GROUP_CODE;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return self::GROUP_NAME;
    }

    /**
     * @return string
     */
    public function getStoreCode(): string
    {
        return self::STORE_CODE;
    }

    /**
     * @return string
     */
    public function getStoreName(): string
    {
        return self::STORE_NAME;
    }
}
