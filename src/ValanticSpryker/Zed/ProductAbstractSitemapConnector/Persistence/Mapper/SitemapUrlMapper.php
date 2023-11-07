<?php

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Persistence\Mapper;

use Generated\Shared\Transfer\SitemapUrlTransfer;
use Orm\Zed\UrlStorage\Persistence\SpyUrlStorage;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Client\ProductStorage\ProductStorageClientInterface;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;

class SitemapUrlMapper
{
    /**
     * @var ProductAbstractSitemapConnectorConfig
     */
    private ProductAbstractSitemapConnectorConfig $config;

    /**
     * @var ProductStorageClientInterface
     */
    private ProductStorageClientInterface $productStorageClient;

    public function __construct(
        ProductAbstractSitemapConnectorConfig $config,
        ProductStorageClientInterface         $productStorageClient
    )
    {
        $this->config = $config;
        $this->productStorageClient = $productStorageClient;
    }

    /**
     * @param ObjectCollection $urlStorageEntities
     * @param string $storeName
     *
     * @return array
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function mapUrlStorageEntitiesToSitemapUrlTransfers(
        ObjectCollection $urlStorageEntities,
        string           $storeName
    ): array
    {
        $transfers = [];
        /** @var \Orm\Zed\UrlStorage\Persistence\SpyUrlStorage $entity */
        foreach ($urlStorageEntities as $entity) {
            $isResourceAvailableForStore = $this->isResourceAvailableForStore($entity);

            if (!$isResourceAvailableForStore) {
                continue;
            }

            $transfers[] = (new SitemapUrlTransfer())
                ->setUrl(
                    sprintf(
                        '%s%s/',
                        $this->config->getYvesBaseUrl(),
                        rtrim($this->resolvePathWithStorePrefix($storeName, $entity->getUrl()), '/'),
                    ),
                )
                ->setUpdatedAt($entity->getUpdatedAt()->format('Y-m-d'));
        }

        return $transfers;
    }

    /**
     * @param string $storeName
     * @param string $url
     *
     * @return string
     */
    private function resolvePathWithStorePrefix(string $storeName, string $url): string
    {
        //todo move to config.
        $storePrefixMap = [
            'de' => '/de/',
            'at' => '/at/',
        ];

        return str_replace(
            '/de/',
            $storePrefixMap[strtolower($storeName)] ?? '/de/',
            $url,
        );
    }

    /**
     * @param SpyUrlStorage $entity
     *
     * @return bool
     */
    public function isResourceAvailableForStore(SpyUrlStorage $entity): bool
    {
        if ($entity->getFkProductAbstract()) {
            return $this->productStorageClient->isProductAbstractRestricted(
                $entity->getFkProductAbstract(),
            );
        }
        return true;
    }
}
