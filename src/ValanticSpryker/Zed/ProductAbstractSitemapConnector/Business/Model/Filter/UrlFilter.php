<?php


/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filter;

use Generated\Shared\Transfer\SitemapUrlTransfer;

class UrlFilter implements UrlFilterInterface
{
    /**
     * @var array<\ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\FiltererInterface>
     */
    private array $urlFilterers;

    /**
     * @param array<\ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\FiltererInterface> $urlFilterers
     */
    public function __construct(array $urlFilterers)
    {
        $this->urlFilterers = $urlFilterers;
    }

    /**
     * @param \Generated\Shared\Transfer\SitemapUrlTransfer $sitemapUrlTransfer
     *
     * @return bool
     */
    public function filterUrl(SitemapUrlTransfer $sitemapUrlTransfer): bool
    {
        foreach ($this->urlFilterers as $urlFilterer) {
            if (!$urlFilterer->filter($sitemapUrlTransfer)) {
                return false;
            }
        }

        return true;
    }
}
