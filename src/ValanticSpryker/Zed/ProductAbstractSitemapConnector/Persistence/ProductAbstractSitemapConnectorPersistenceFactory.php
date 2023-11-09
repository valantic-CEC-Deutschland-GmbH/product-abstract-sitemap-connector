<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence;

use Spryker\Client\ProductStorage\ProductStorageClientInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper\SitemapUrlMapper;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductSitemapConnectorDependencyProvider;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig getConfig()
 */
class ProductAbstractSitemapConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper\SitemapUrlMapper
     */
    public function createSitemapUrlMapper(): SitemapUrlMapper
    {
        return new SitemapUrlMapper(
            $this->getConfig(),
            $this->getProductStorageClient(),
        );
    }

    /**
     * @return \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    private function getProductStorageClient(): ProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }
}
