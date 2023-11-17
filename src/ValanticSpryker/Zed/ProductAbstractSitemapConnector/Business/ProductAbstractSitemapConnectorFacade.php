<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\ProductAbstractSitemapConnectorBusinessFactory getFactory()
 */
class ProductAbstractSitemapConnectorFacade extends AbstractFacade implements ProductAbstractSitemapConnectorFacadeInterface
{
    /**
     * @inheritDoc
     */
    public function createSitemapXml(): array
    {
        return $this->getFactory()
            ->createProductSitemapCreator()
            ->createSitemapXml();
    }
}
