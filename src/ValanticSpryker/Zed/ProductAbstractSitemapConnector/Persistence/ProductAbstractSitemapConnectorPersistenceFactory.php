<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence;

use Orm\Zed\Url\Persistence\SpyUrlQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper\ProductAbstractSitemapUrlMapper;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig getConfig()
 */
class ProductAbstractSitemapConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper\ProductAbstractSitemapUrlMapper
     */
    public function createSitemapUrlMapper(): ProductAbstractSitemapUrlMapper
    {
        return new ProductAbstractSitemapUrlMapper(
            $this->getConfig(),
        );
    }

    /**
     * @return \Orm\Zed\Url\Persistence\SpyUrlQuery
     */
    public function createSpyUrlQuery(): SpyUrlQuery
    {
        return SpyUrlQuery::create();
    }
}
