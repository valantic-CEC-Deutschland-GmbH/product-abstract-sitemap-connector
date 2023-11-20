# Abstract Product Sitemap Connector

# Description

This module is used alongside `valantic-spryker/sitemap` Sitemap module to extend the sitemap with abstract product URLs.

# Usage

1. `composer require valantic-spryker/product-abstract-sitemap-connector`
2. Since this is under ValanticSpryker namespace, make sure that in config_default:
   1. `$config[KernelConstants::CORE_NAMESPACES]` has the namespace
   2. `$config[KernelConstants::PROJECT_NAMESPACES]` has the namespace
5. Add `ProductAbstractSitemapCreatorPlugin` to `\ValanticSpryker\Zed\Sitemap\SitemapDependencyProvider::getSitemapCreatorPluginStack`
6. Add `\ValanticSpryker\Shared\ProductAbstractSitemapConnector\ProductAbstractSitemapConnectorConstants` to `\ValanticSpryker\Yves\Sitemap\SitemapDependencyProvider::getAvailableSitemapRouteResources`
7. Now the Sitemap will include **published** URLs of abstract products.



