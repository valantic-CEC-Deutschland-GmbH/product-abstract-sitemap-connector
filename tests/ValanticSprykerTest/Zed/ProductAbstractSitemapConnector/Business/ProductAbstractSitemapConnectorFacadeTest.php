<?php

declare(strict_types = 1);

namespace ValanticSprykerTest\Zed\Business;

use ArrayObject;
use Codeception\Test\Unit;
use DOMDocument;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\SitemapFileTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use InvalidArgumentException;
use League\Uri\Uri;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractStoreTableMap;
use Orm\Zed\Url\Persistence\Map\SpyUrlTableMap;
use Orm\Zed\Url\Persistence\SpyUrlQuery;
use Orm\Zed\UrlStorage\Persistence\Map\SpyUrlStorageTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
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
    public function testFacadeRendersCorrectAmountOfUrlsWithCorrectStructure(): void
    {
        // Arrange
        $storeFacade = $this->tester->getLocator()->store()->facade();
        $idStore = $storeFacade->getCurrentStore()->getIdStore();
        $validEntries = SpyUrlQuery::create()
            ->filterByFkResourceProductAbstract(null, Criteria::ISNOTNULL)
            ->filterByFkResourceRedirect(null, Criteria::ISNULL)
            ->addJoin(
                [SpyUrlTableMap::COL_FK_RESOURCE_PRODUCT_ABSTRACT, $idStore],
                [SpyProductAbstractStoreTableMap::COL_FK_PRODUCT_ABSTRACT, SpyProductAbstractStoreTableMap::COL_FK_STORE],
                Criteria::INNER_JOIN,
            )
            ->addJoin(SpyUrlTableMap::COL_ID_URL, SpyUrlStorageTableMap::COL_FK_URL, Criteria::INNER_JOIN)
            ->select(SpyUrlTableMap::COL_URL)
            ->limit(100)
            ->find()
            ->getData();

        $validEntries = array_map(static function (string $url): string {
            return Uri::createFromString($url)->toString();
        }, $validEntries);

        $validEntryCount = count($validEntries);

        // Act
        /** @var array<\Generated\Shared\Transfer\SitemapFileTransfer> $result */
        $result = $this->tester->getLocator()->productAbstractSitemapConnector()->facade()->createSitemapXml()[0] ?? null;

        // Assert
        self::assertInstanceOf(SitemapFileTransfer::class, $result);
        self::assertNotEmpty($result->getContent());
        self::assertNotEmpty($result->getStoreName());
        self::assertNotFalse(parse_url($result->getYvesBaseUrl()));

        $domDoc = new DOMDocument();
        $domDoc->loadXML($result->getContent());
        $urls = $domDoc->getElementsByTagName('url');

        foreach ($urls as $url) {
            $loc = $url->getElementsByTagName('loc')->item(0)->textContent;
            $lastMod = $url->getElementsByTagName('lastmod')->item(0)->textContent;

            self::assertContains(rtrim(parse_url($loc)['path']), $validEntries);

            self::assertNotFalse(parse_url($loc));
            self::assertNotEmpty($lastMod);
        }

        self::assertSame($validEntryCount, $urls->count());
    }

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
