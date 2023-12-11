<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence;

use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractStoreTableMap;
use Orm\Zed\Url\Persistence\Map\SpyUrlTableMap;
use Orm\Zed\UrlStorage\Persistence\Map\SpyUrlStorageTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\ProductAbstractSitemapConnectorPersistenceFactory getFactory()
 */
class ProductAbstractSitemapConnectorRepository extends AbstractRepository implements ProductAbstractSitemapConnectorRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $currentStore
     * @param int $page
     * @param int $limit
     *
     * @return array<\Generated\Shared\Transfer\SitemapUrlTransfer>
     */
    public function findActiveAbstractProductUrls(StoreTransfer $currentStore, int $page, int $limit): array
    {
        $urlEntities = $this->findVisibleProductUrls($currentStore->getIdStore(), $page, $limit);

        return $this->getFactory()
            ->createSitemapUrlMapper()
            ->mapUrlEntitiesToSitemapUrlTransfers($urlEntities);
    }

    /**
     * @param int $idStore
     * @param int $page
     * @param int $urlLimit
     *
     * @return \Propel\Runtime\Collection\ObjectCollection
     */
    private function findVisibleProductUrls(int $idStore, int $page, int $urlLimit): ObjectCollection
    {
        $query = $this->getFactory()
            ->createSpyUrlQuery()
            ->filterByFkResourceProductAbstract(null, Criteria::ISNOTNULL)
            ->filterByFkResourceRedirect(null, Criteria::ISNULL)
            ->addJoin(
                [SpyUrlTableMap::COL_FK_RESOURCE_PRODUCT_ABSTRACT, $idStore],
                [SpyProductAbstractStoreTableMap::COL_FK_PRODUCT_ABSTRACT, SpyProductAbstractStoreTableMap::COL_FK_STORE],
                Criteria::INNER_JOIN,
            )
            ->addJoin(SpyUrlTableMap::COL_ID_URL, SpyUrlStorageTableMap::COL_FK_URL, Criteria::INNER_JOIN)
            ->withColumn(SpyUrlStorageTableMap::COL_UPDATED_AT, 'updated_at')
            ->setOffset($this->calculateOffsetByPage($page, $urlLimit))
            ->setLimit($urlLimit);

        return $query->find();
    }

    /**
     * @param int $page
     * @param int $pageLimit
     *
     * @return int
     */
    private function calculateOffsetByPage(int $page, int $pageLimit): int
    {
        return ($page - 1) * $pageLimit;
    }
}
