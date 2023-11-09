<?php

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use ValanticSpryker\Zed\Sitemap\Dependency\Plugin\SitemapCreatorPluginInterface;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication\ProductSitemapConnectorCommunicationFactory getFactory()
 */
class ProductSitemapCreatorPlugin extends AbstractPlugin implements SitemapCreatorPluginInterface
{
 /**
  * @return array
  */
    public function createSitemapXml(): array
    {
        return $this->getFactory()->createProductSitemapCreator()->createSitemapXml();
    }
}
