<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use ValanticSpryker\Service\Sitemap\SitemapServiceInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator\ProductAbstractSitemapCreator;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter\UrlFilter;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter\UrlFilterInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\BlackListFilterer;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\FiltererInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorDependencyProvider;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig getConfig()
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorRepositoryInterface getRepository()
 */
class ProductAbstractSitemapConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator\ProductAbstractSitemapCreator
     */
    public function createProductSitemapCreator(): ProductAbstractSitemapCreator
    {
        return new ProductAbstractSitemapCreator(
            $this->getSitemapService(),
            $this->getRepository(),
            $this->getConfig(),
            $this->getStoreFacade(),
            $this->createUrlFilter(),
        );
    }

    /**
     * @return \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter\UrlFilterInterface
     */
    public function createUrlFilter(): UrlFilterInterface
    {
        return new UrlFilter(
            $this->createFilterers(),
        );
    }

    /**
     * @return array<\ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\FiltererInterface>
     */
    private function createFilterers(): array
    {
        return [
            $this->createBlackListFilterer(),
        ];
    }

    /**
     * @return \Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    private function getProductListFacade(): ProductListFacadeInterface
    {
        return $this->getProvidedDependency(ProductAbstractSitemapConnectorDependencyProvider::FACADE_PRODUCT_LIST);
    }

    /**
     * @return \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\FiltererInterface
     */
    private function createBlackListFilterer(): FiltererInterface
    {
        return new BlackListFilterer(
            $this->getProductListFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @return \ValanticSpryker\Service\Sitemap\SitemapServiceInterface
     */
    private function getSitemapService(): SitemapServiceInterface
    {
        return $this->getProvidedDependency(ProductAbstractSitemapConnectorDependencyProvider::SITEMAP_SERVICE);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    private function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductAbstractSitemapConnectorDependencyProvider::FACADE_STORE);
    }
}
