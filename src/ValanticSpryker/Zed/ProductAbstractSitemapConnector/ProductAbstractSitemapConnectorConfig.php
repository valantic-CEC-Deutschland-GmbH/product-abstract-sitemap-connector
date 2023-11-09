<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use ValanticSpryker\Shared\Sitemap\SitemapConstants;

class ProductAbstractSitemapConnectorConfig extends AbstractBundleConfig
{
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
        return $this->get(SitemapConstants::SITEMAP_URL_LIMIT);
    }
}
