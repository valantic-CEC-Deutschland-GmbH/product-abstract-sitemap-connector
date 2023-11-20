<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator;

use Spryker\Zed\Store\Business\StoreFacadeInterface;
use ValanticSpryker\Service\Sitemap\SitemapServiceInterface;
use ValanticSpryker\Shared\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConstants;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter\UrlFilterInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorRepositoryInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;

class ProductAbstractSitemapCreator
{
    private SitemapServiceInterface $sitemapService;

    private ProductAbstractSitemapConnectorConfig $config;

    private StoreFacadeInterface $storeFacade;

    private ProductAbstractSitemapConnectorRepositoryInterface $repository;

    /**
     * @var \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter\UrlFilterInterface
     */
    private UrlFilterInterface $urlFilter;

    /**
     * @param \ValanticSpryker\Service\Sitemap\SitemapServiceInterface $sitemapService
     * @param \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorRepositoryInterface $repository
     * @param \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig $config
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter\UrlFilterInterface $urlFilter
     */
    public function __construct(
        SitemapServiceInterface $sitemapService,
        ProductAbstractSitemapConnectorRepositoryInterface $repository,
        ProductAbstractSitemapConnectorConfig $config,
        StoreFacadeInterface $storeFacade,
        UrlFilterInterface $urlFilter
    ) {
        $this->sitemapService = $sitemapService;
        $this->repository = $repository;
        $this->config = $config;
        $this->storeFacade = $storeFacade;
        $this->urlFilter = $urlFilter;
    }

    /**
     * @return array<\Generated\Shared\Transfer\SitemapFileTransfer>
     */
    public function createSitemapXml(): array
    {
        $urlLimit = $this->config->getSitemapUrlLimit();
        $sitemapList = [];
        $currentStoreTransfer = $this->storeFacade->getCurrentStore();
        $page = 1;

        do {
            $urlList = $this->repository->findActiveAbstractProductUrls(
                $currentStoreTransfer,
                $page,
                $urlLimit,
            );

            $this->filterUrls($urlList);

            $sitemapTransfer = $this->sitemapService->createSitemapXmlFileTransfer(
                $urlList,
                $page,
                $currentStoreTransfer->getName(),
                ProductAbstractSitemapConnectorConstants::RESOURCE_TYPE,
            );

            if ($sitemapTransfer !== null) {
                $sitemapList[] = $sitemapTransfer;
            }

            $page++;
        } while ($sitemapTransfer !== null);

        return $sitemapList;
    }

    /**
     * @param array<\Generated\Shared\Transfer\SitemapUrlTransfer> $urlList
     *
     * @return void
     */
    protected function filterUrls(array $urlList): void
    {
        foreach ($urlList as $key => $url) {
            if (!$this->urlFilter->filterUrl($url)) {
                unset($url[$key]);
            }
        }
    }
}
