# ProductSitemapConnector:

## Integration

### Add composer registry
```
composer config repositories.gitlab.nxs360.com/461 '{"type": "composer", "url": "https://gitlab.nxs360.com/api/v4/group/461/-/packages/composer/packages.json"}'
```

### Add Gitlab domain
```
composer config gitlab-domains gitlab.nxs360.com
```

### Authentication
Go to Gitlab and create a personal access token. Then create an **auth.json** file:
```
composer config gitlab-token.gitlab.nxs360.com <personal_access_token>
```

Make sure to add **auth.json** to your **.gitignore**.

## Implementation

1. Install dependency
```
composer require valantic-spryker/product-sitemap-connector
```

2. Register ConnectorPlugin
```php
<?php


```

3. ..........
```php

```

5. .......
- .........
```php
aaaaa
```

## Access Sitemap
The following paths are considered
```
  - {$storeLocales}/sitemap_{number}.xml
  - {$storeLocales}/sitemap.xml
  - sitemap_{number}.xml
  - sitemap.xml
```
