<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper;

use Generated\Shared\Transfer\SitemapUrlNodeTransfer;
use Orm\Zed\Url\Persistence\SpyUrl;
use Propel\Runtime\Collection\ObjectCollection;
use ValanticSpryker\Shared\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConstants;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;

class ProductAbstractSitemapUrlMapper
{
    /**
     * @var string
     */
    private const URL_FORMAT = '%s%s';

    /**
     * @var \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig
     */
    private ProductAbstractSitemapConnectorConfig $config;

    /**
     * @param \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig $config
     */
    public function __construct(
        ProductAbstractSitemapConnectorConfig $config
    ) {
        $this->config = $config;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $urlEntities
     *
     * @return array<\Generated\Shared\Transfer\SitemapUrlNodeTransfer>
     */
    public function mapUrlEntitiesToSitemapUrlNodeTransfers(ObjectCollection $urlEntities): array
    {
        $transfers = [];

        /** @var \Orm\Zed\Url\Persistence\SpyUrl $urlEntity */
        foreach ($urlEntities as $urlEntity) {
            $transfers[] = $this->createSitemapUrlNodeTransfer($urlEntity);
        }

        return $transfers;
    }

    /**
     * @param \Orm\Zed\Url\Persistence\SpyUrl $urlEntity
     *
     * @return \Generated\Shared\Transfer\SitemapUrlNodeTransfer
     */
    private function createSitemapUrlNodeTransfer(SpyUrl $urlEntity): SitemapUrlNodeTransfer
    {
        return (new SitemapUrlNodeTransfer())
            ->setUrl($this->formatUrl($urlEntity))
            ->setUpdatedAt($urlEntity->getVirtualColumn('updated_at'))
            ->setResourceId($urlEntity->getFkResourceProductAbstract())
            ->setResourceType(ProductAbstractSitemapConnectorConstants::RESOURCE_TYPE);
    }

    /**
     * @param \Orm\Zed\Url\Persistence\SpyUrl $urlEntity
     *
     * @return string
     */
    private function formatUrl(SpyUrl $urlEntity): string
    {
        return sprintf(
            self::URL_FORMAT,
            $this->config->getYvesBaseUrl(),
            $urlEntity->getUrl(),
        );
    }
}
