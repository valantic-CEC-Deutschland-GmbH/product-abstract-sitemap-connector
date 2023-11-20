<?php


/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer;

use Generated\Shared\Transfer\SitemapUrlTransfer;
use Spryker\Zed\ProductList\Business\ProductListFacadeInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;

class BlackListFilterer implements FiltererInterface
{
    /**
     * @var \Spryker\Zed\ProductList\Business\ProductListFacadeInterface
     */
    private ProductListFacadeInterface $productListFacade;

    /**
     * @var \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig
     */
    private ProductAbstractSitemapConnectorConfig $config;

    /**
     * @param \Spryker\Zed\ProductList\Business\ProductListFacadeInterface $productListFacade
     * @param \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig $config
     */
    public function __construct(
        ProductListFacadeInterface $productListFacade,
        ProductAbstractSitemapConnectorConfig $config
    ) {
        $this->productListFacade = $productListFacade;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\SitemapUrlTransfer $sitemapUrlTransfer
     *
     * @return bool
     */
    public function filter(SitemapUrlTransfer $sitemapUrlTransfer): bool
    {
        if (!$this->config->filterAbstractProductsByBlackLists()) {
            return true;
        }

        $blackListIdsTheProductIsIn = $this->productListFacade
            ->getProductBlacklistIdsByIdProductAbstract(
                $sitemapUrlTransfer->getResourceId(),
            );

        return count($blackListIdsTheProductIsIn) === 0;
    }
}
