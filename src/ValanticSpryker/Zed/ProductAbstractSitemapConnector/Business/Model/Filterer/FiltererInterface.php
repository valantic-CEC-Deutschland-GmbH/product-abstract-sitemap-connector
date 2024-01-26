<?php


/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer;

use Generated\Shared\Transfer\SitemapUrlNodeTransfer;

interface FiltererInterface
{
    /**
     * Specification:
     *
     * - Filters url by specific condition. Returns false upon failure.
     *
     * @param \Generated\Shared\Transfer\SitemapUrlNodeTransfer $sitemapUrlNodeTransfer
     *
     * @return bool
     */
    public function filter(SitemapUrlNodeTransfer $sitemapUrlNodeTransfer): bool;
}
