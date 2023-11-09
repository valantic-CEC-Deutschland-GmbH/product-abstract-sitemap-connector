<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use ValanticSpryker\Service\Sitemap\SitemapServiceInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator\ProductSitemapCreator;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductSitemapConnectorDependencyProvider;
use ValanticSpryker\Zed\Sitemap\Business\SitemapFacadeInterface;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorRepositoryInterface getRepository()
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication\ProductAbstractSitemapConnectorConfig getConfig()
 */
class ProductSitemapConnectorCommunicationFactory extends AbstractCommunicationFactory
{
 /**
  * @return \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator\ProductSitemapCreator
  */
    public function createProductSitemapCreator(): ProductSitemapCreator
    {
        return new ProductSitemapCreator(
            $this->getSitemapService(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getStoreFacade(),
        );
    }

    /**
     * @return \ValanticSpryker\Service\Sitemap\SitemapServiceInterface
     */
    public function getSitemapService(): SitemapServiceInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::SITEMAP_SERVICE);
    }

    /**
     * @return \ValanticSpryker\Zed\Sitemap\Business\SitemapFacadeInterface
     */
    public function getSitemapFacade(): SitemapFacadeInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::SITEMAP_REPOSITORY);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    private function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductSitemapConnectorDependencyProvider::FACADE_STORE);
    }
}
