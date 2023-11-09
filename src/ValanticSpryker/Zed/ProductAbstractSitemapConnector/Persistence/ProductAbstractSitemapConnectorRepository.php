<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence;

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
  * @param string $storeName
  * @param int|null $page
  * @param int|null $limit
  *
  * @return array
  */
    public function findProductUrlsMappedToSitemapUrlTransfers(string $storeName, ?int $page = null, ?int $limit = null): array
    {
        $urlStorageEntities = $this->findVisibleProductUrls($page, $limit);

        return $this->getFactory()
            ->createSitemapUrlMapper()
            ->mapUrlStorageEntitiesToSitemapUrlTransfers(
                $urlStorageEntities,
                $storeName,
            );
    }

    /**
     * @param int|null $page
     * @param int|null $limit
     *
     * @return \Propel\Runtime\Collection\ObjectCollection
     */
    private function findVisibleProductUrls(?int $page = null, ?int $limit = null): ObjectCollection
    {
        $query = $this->getFactory()->getSpyUrlStorageQuery()
            ->filterByFkRedirect(null, Criteria::ISNULL)
            ->filterByFkProductAbstract(null, Criteria::ISNOTNULL)
            ->addJoin(SpyUrlStorageTableMap::COL_FK_URL, SpyUrlTableMap::COL_ID_URL, Criteria::INNER_JOIN);

        if ($page !== null && $limit !== null) {
            $offset = ($page - 1) * $limit;
            $query
                ->setOffset($offset)
                ->setLimit($limit);
        }

        return $query->find();
    }
}
