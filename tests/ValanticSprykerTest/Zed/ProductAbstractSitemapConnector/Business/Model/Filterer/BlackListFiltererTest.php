<?php


/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace ValanticSprykerTest\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductListProductConcreteRelationTransfer;
use Generated\Shared\Transfer\ProductListTransfer;
use Generated\Shared\Transfer\SitemapUrlNodeTransfer;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\Business\Model\Filterer\BlackListFilterer;
use ValanticSpryker\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConfig;
use ValanticSprykerTest\Zed\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorTester;

/**
 * Auto-generated group annotations
 *
 * @group ValanticSprykerTest
 * @group Zed
 * @group ProductAbstractSitemapConnector
 * @group Business
 * @group Model
 * @group Filterer
 * Add your own group annotations below this line
 */
class BlackListFiltererTest extends Unit
{
    public ProductAbstractSitemapConnectorTester $tester;

    /**
     * @return void
     */
    public function testFilterWhenNoBlackListIsFound(): void
    {
        // Arrange
        $product = $this->tester->haveFullProduct();
        $productListFacade = $this->tester->getLocator()->productList()->facade();

        $productListTransfer = new ProductListTransfer();
        $productListTransfer->setKey('random-key');
        $productListTransfer->setTitle('example-title');
        $productListTransfer->setProductListProductConcreteRelation((new ProductListProductConcreteRelationTransfer())->setProductIds([]));
        $productListTransfer->setType('blacklist'); // black list type
        $productListFacade->createProductList($productListTransfer);

        $configMock = $this->createMock(ProductAbstractSitemapConnectorConfig::class);
        $configMock
            ->method('filterAbstractProductsByBlackLists')
            ->willReturn(true);

        $blackListFilterer = new BlackListFilterer(
            $productListFacade,
            $configMock,
        );

        $sitemapUrlNodeTransfer = new SitemapUrlNodeTransfer();
        $sitemapUrlNodeTransfer->setResourceId($product->getFkProductAbstract());

        // Act
        $filterResult = $blackListFilterer->filter($sitemapUrlNodeTransfer);

        // Assert
        self::assertTrue($filterResult);
    }

    /**
     * @return void
     */
    public function testFilterWhenThereAreBlackListedConcreteProducts(): void
    {
        // Arrange
        $product = $this->tester->haveFullProduct();
        $productListFacade = $this->tester->getLocator()->productList()->facade();
        $idConcrete = $product->getIdProductConcrete();

        $productListTransfer = new ProductListTransfer();
        $productListTransfer->setKey('random-key');
        $productListTransfer->setTitle('example-title');
        $productListTransfer->setProductListProductConcreteRelation((new ProductListProductConcreteRelationTransfer())->setProductIds([$idConcrete]));
        $productListTransfer->setType('blacklist'); // black list type
        $productListFacade->createProductList($productListTransfer);

        $configMock = $this->createMock(ProductAbstractSitemapConnectorConfig::class);
        $configMock
            ->method('filterAbstractProductsByBlackLists')
            ->willReturn(true);

        $blackListFilterer = new BlackListFilterer(
            $productListFacade,
            $configMock,
        );

        $sitemapUrlNodeTransfer = new SitemapUrlNodeTransfer();
        $sitemapUrlNodeTransfer->setResourceId($product->getFkProductAbstract());

        // Act
        $filterResult = $blackListFilterer->filter($sitemapUrlNodeTransfer);

        // Assert
        self::assertFalse($filterResult);
    }

    /**
     * @return void
     */
    public function testFilterWhenThereAreBlackListedConcreteProductsButConfigForFilteringIsDisabled(): void
    {
        // Arrange
        $product = $this->tester->haveFullProduct();
        $productListFacade = $this->tester->getLocator()->productList()->facade();
        $idConcrete = $product->getIdProductConcrete();

        $productListTransfer = new ProductListTransfer();
        $productListTransfer->setKey('random-key');
        $productListTransfer->setTitle('example-title');
        $productListTransfer->setProductListProductConcreteRelation((new ProductListProductConcreteRelationTransfer())->setProductIds([$idConcrete]));
        $productListTransfer->setType('blacklist'); // black list type
        $productListFacade->createProductList($productListTransfer);

        $configMock = $this->createMock(ProductAbstractSitemapConnectorConfig::class);
        $configMock
            ->method('filterAbstractProductsByBlackLists')
            ->willReturn(false);

        $blackListFilterer = new BlackListFilterer(
            $productListFacade,
            $configMock,
        );

        $sitemapUrlNodeTransfer = new SitemapUrlNodeTransfer();
        $sitemapUrlNodeTransfer->setResourceId($product->getFkProductAbstract());

        // Act
        $filterResult = $blackListFilterer->filter($sitemapUrlNodeTransfer);

        // Assert
        self::assertTrue($filterResult);
    }
}
