<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business;

interface ProductAbstractSitemapConnectorFacadeInterface
{
    /**
     * Specification:
     * - Creates sitemap XML to be consumed by parent module.
     *
     * @return array<\Generated\Shared\Transfer\SitemapFileTransfer>
     */
    public function createSitemapXml(): array;
}
