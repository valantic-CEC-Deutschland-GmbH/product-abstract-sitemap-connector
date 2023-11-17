<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use ValanticSpryker\Zed\Sitemap\Dependency\Plugin\SitemapCreatorPluginInterface;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\ProductAbstractSitemapConnectorFacadeInterface getFacade()
 */
class ProductAbstractSitemapCreatorPlugin extends AbstractPlugin implements SitemapCreatorPluginInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\SitemapFileTransfer>
     */
    public function createSitemapXml(): array
    {
        return $this->getFacade()
            ->createSitemapXml();
    }
}
