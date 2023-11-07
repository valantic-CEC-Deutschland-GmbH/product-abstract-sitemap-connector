<?php

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication\Plugin;


use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication\ProductSitemapConnectorCommunicationFactory;
use ValanticSpryker\Zed\Sitemap\Dependency\Plugin\SitemapCreatorPluginInterface;

/**
 * @method ProductSitemapConnectorCommunicationFactory getFactory()
 */
class ProductSitemapCreatorPlugin extends AbstractPlugin implements SitemapCreatorPluginInterface
{

    /**
     * @return array
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createSitemapXml(): array
    {
       $this->getFactory()->createProductSitemapCreator()->createSitemapXml();
    }
}
