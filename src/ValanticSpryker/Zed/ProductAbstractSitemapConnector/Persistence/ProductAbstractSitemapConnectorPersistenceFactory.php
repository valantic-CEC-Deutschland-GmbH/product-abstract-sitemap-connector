<?php

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence;


use Spryker\Client\CategoryStorage\CategoryStorageClientInterface;
use Spryker\Client\ProductStorage\ProductStorageClientInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper\SitemapUrlMapper;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductSitemapConnectorDependencyProvider;

/**
 * @method ProductAbstractSitemapConnectorConfig getConfig()
 */
class ProductAbstractSitemapConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return SitemapUrlMapper
     */
    public function createSitemapUrlMapper(): SitemapUrlMapper
    {
        return new SitemapUrlMapper(
            $this->getConfig(),
            $this->getProductStorageClient()
        );
    }

    /**
     * @return ProductStorageClientInterface
     */
    private function getProductStorageClient(): ProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }
}
