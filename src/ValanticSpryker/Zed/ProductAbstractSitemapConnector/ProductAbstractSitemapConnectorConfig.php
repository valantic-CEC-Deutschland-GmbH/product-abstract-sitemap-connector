<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use ValanticSpryker\Shared\Sitemap\SitemapConstants;

class ProductAbstractSitemapConnectorConfig extends AbstractBundleConfig
{
    public const RESOURCE_TYPE = 'abstract_product';

    /**
     * @return string
     */
    public function getYvesBaseUrl(): string
    {
        return $this->get(ApplicationConstants::BASE_URL_YVES);
    }

    /**
     * @return int
     */
    public function getSitemapUrlLimit(): int
    {
        return $this->get(SitemapConstants::SITEMAP_URL_LIMIT, 100);
    }

    /**
     * @return bool
     */
    public function filterAbstractProductsByBlackLists(): bool
    {
        return $this->get(SitemapConstants::SITEMAP_USE_BLACKLISTS, false);
    }
}
