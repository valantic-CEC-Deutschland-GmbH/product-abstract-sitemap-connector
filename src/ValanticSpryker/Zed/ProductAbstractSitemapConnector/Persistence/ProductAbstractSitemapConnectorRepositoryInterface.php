<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence;

interface ProductAbstractSitemapConnectorRepositoryInterface
{
    /**
     * @param string $storeName
     * @param int|null $page
     * @param int|null $limit
     *
     * @return array
     */
    public function findProductUrlsMappedToSitemapUrlTransfers(string $storeName, ?int $page = null, ?int $limit = null): array;
}
