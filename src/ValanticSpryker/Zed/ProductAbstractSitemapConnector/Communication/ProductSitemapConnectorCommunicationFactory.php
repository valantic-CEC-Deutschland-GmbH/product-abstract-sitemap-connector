<?php

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use ValanticSpryker\Service\Sitemap\SitemapServiceInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator\ProductSitemapCreator;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorRepositoryInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductSitemapConnectorDependencyProvider;
use ValanticSpryker\Zed\Sitemap\Business\SitemapFacadeInterface;

/**
 * @method ProductAbstractSitemapConnectorRepositoryInterface getRepository()
 * @method ProductAbstractSitemapConnectorConfig getConfig()
 */
class ProductSitemapConnectorCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return ProductSitemapCreator
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createProductSitemapCreator(): ProductSitemapCreator
    {
        return new ProductSitemapCreator(
            $this->getSitemapService(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getStoreFacade()
        );
    }

    /**
     * @return SitemapServiceInterface
     * @throws ContainerKeyNotFoundException
     */
    public function getSitemapService():SitemapServiceInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::SITEMAP_SERVICE);
    }

    /**
     * @return SitemapFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getSitemapFacade():SitemapFacadeInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::SITEMAP_REPOSITORY);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     * @throws ContainerKeyNotFoundException
     */
    private function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::FACADE_STORE);
    }
}
