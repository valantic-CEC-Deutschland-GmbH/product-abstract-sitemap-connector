<?php

declare(strict_types = 1);

namespace ValanticSprykerTest\Zed\Business;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use InvalidArgumentException;
use Orm\Zed\Url\Persistence\SpyUrlQuery;
use ValanticSprykerTest\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorTester;

/**
 * Auto-generated group annotations
 *
 * @group ValanticSprykerTest
 * @group Zed
 * @group ProductAbstractSitemapConnector
 * @group Business
 * @group Facade
 * @group ProductAbstractSitemapConnectorFacadeTest
 * Add your own group annotations below this line
 */
class ProductAbstractSitemapConnectorFacadeTest extends Unit
{
    public ProductAbstractSitemapConnectorTester $tester;

    /**
     * @return void
     */
    public function testOnlyLinksVisibleToStoreAreRendered(): void
    {
        // ARRANGE
        $allStores = $this->tester->getLocator()->store()->facade()->getAllStores();
        $currentStore = $this->tester->getLocator()->store()->facade()->getCurrentStore();
        $otherStore = $this->getDifferentCurrentStore($allStores, $currentStore);

        $storeRelationTransfer = $this->createStoreRelationByStore($currentStore);
        $emptyStoreRelation = $this->createStoreRelationByStore($otherStore);

        $product = $this->tester->haveFullProduct([], [
            ProductAbstractTransfer::STORE_RELATION => $storeRelationTransfer,
        ]);

        $product2 = $this->tester->haveFullProduct([], [
            ProductAbstractTransfer::STORE_RELATION => $emptyStoreRelation,
        ]);

        $url = SpyUrlQuery::create()
            ->findOneByFkResourceProductAbstract($product->getFkProductAbstract());

        $url2 = SpyUrlQuery::create()
            ->findOneByFkResourceProductAbstract($product2->getFkProductAbstract());

        $this->tester->getLocator()->urlStorage()->facade()->publishUrl(
            [
                $url->getIdUrl(),
                $url2->getIdUrl(),
            ],
        );

        // ACT
        $sitemapXml = $this->tester->getLocator()->productAbstractSitemapConnector()->facade()->createSitemapXml();

        // ASSERT
        self::assertTrue($this->containsUrlInSitemap($sitemapXml, $url->getUrl()));
        self::assertFalse($this->containsUrlInSitemap($sitemapXml, $url2->getUrl()));
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $currentStore
     *
     * @return \Generated\Shared\Transfer\StoreRelationTransfer
     */
    private function createStoreRelationByStore(StoreTransfer $currentStore): StoreRelationTransfer
    {
        $stores = new ArrayObject();
        $stores->append($currentStore);

        return (new StoreRelationTransfer())
            ->setStores($stores)
            ->setIdStores([$currentStore->getIdStore()]);
    }

    /**
     * @param array<\Generated\Shared\Transfer\StoreTransfer> $allStores
     * @param \Generated\Shared\Transfer\StoreTransfer $currentStore
     *
     * @throws \InvalidArgumentException
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    private function getDifferentCurrentStore(array $allStores, StoreTransfer $currentStore): StoreTransfer
    {
        foreach ($allStores as $store) {
            if ($store->getIdStore() !== $currentStore->getIdStore()) {
                return $store;
            }
        }

        throw new InvalidArgumentException();
    }

    /**
     * @param array<\Generated\Shared\Transfer\SitemapFileTransfer> $sitemapXml
     * @param string $needle
     *
     * @return bool
     */
    private function containsUrlInSitemap(array $sitemapXml, string $needle): bool
    {
        foreach ($sitemapXml as $item) {
            if (strpos($item->getContent(), $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
