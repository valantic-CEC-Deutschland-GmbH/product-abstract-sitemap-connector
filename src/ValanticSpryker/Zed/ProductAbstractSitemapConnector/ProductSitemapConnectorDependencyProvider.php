<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductSitemapConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
 /**
  * @var string
  */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const SITEMAP_SERVICE = 'SITEMAP_SERVICE';

    /**
     * @var string
     */
    public const CLIENT_PRODUCT_STORAGE = 'CLIENT_PRODUCT_STORAGE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addStoreFacade($container);
        $container = $this->addSitemapService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = $this->addProductStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSitemapService(Container $container): Container
    {
        $container->set(static::SITEMAP_SERVICE, function (Container $container) {
            return $container->getLocator()->sitemap()->service();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return $container->getLocator()->store()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addProductStorageClient(Container $container): Container
    {
        $container->set(
            self::CLIENT_PRODUCT_STORAGE,
            fn (Container $container) => $container->getLocator()->productStorage()->client(),
        );

        return $container;
    }
}
