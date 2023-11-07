<?php
declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Creator;

use Spryker\Zed\Store\Business\StoreFacadeInterface;
use ValanticSpryker\Service\Sitemap\SitemapService;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorRepositoryInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;
use ValanticSpryker\Zed\Sitemap\Business\SitemapFacadeInterface;

class ProductSitemapCreator
{

    /**
     * @var string
     */
    private const PRODUCTS = 'products';

    private SitemapService $sitemapService;
    private ProductAbstractSitemapConnectorConfig $config;
    private StoreFacadeInterface $storeFacade;
    private ProductAbstractSitemapConnectorRepositoryInterface $repository;

    /**
     * @param SitemapFacadeInterface $sitemapFacade
     * @param StoreFacadeInterface $storeFacade
     */
    //todo create service from helper
    public function __construct(
        SitemapService $sitemapService,
        ProductAbstractSitemapConnectorRepositoryInterface $repository,
        ProductAbstractSitemapConnectorConfig $config,
        StoreFacadeInterface $storeFacade
    ) {
        $this->sitemapService = $sitemapService;
        $this->repository = $repository;
        $this->config = $config;
        $this->storeFacade = $storeFacade;

    }

    /**
     * @return array
     */
    public function createSitemapXml(): array
    {
        $urlLimit = $this->config->getSitemapUrlLimit();
        $sitemapList = [];
        foreach ($this->storeFacade->getAllStores() as $storeTransfer) {
            $page = 1;

            do {
                $urlList = $this->repository->findProductUrlsMappedToSitemapUrlTransfers(
                    $storeTransfer->getName(),
                    $page,
                    $urlLimit,
                );
                $sitemapTransfer = $this->sitemapService->createSitemapXmlFileTransfer(
                    $urlList,
                    $page,
                    $storeTransfer->getName(),
                    self::PRODUCTS,
                );

                if ($sitemapTransfer !== null) {
                    $sitemapList[] = $sitemapTransfer;
                }

                $page++;
            } while ($sitemapTransfer !== null);
        }

        return $sitemapList;
    }
}
