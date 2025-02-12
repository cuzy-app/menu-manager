# Menu Manager

**Change top menu items and add a "Home" item.**

## Overview

Top menu items that can be managed:
- Dashboard
- People
- Spaces
- Classified Space browser
- Calendar
- Members Map
- Events Map
- eCommerce Store
- Surveys
- Jitsi Meet

A "Home" item can be added to the menu.
The homepage can be managed with [the Homepage module](https://marketplace.humhub.com/module/homepage), or by editing the configuration file `protected/config/web.php`, e.g.:
```php
return [
   'homeUrl' => '/s/some-space/',
];
```

Item settings:
- Show/hide to: All, Logged-in users, Admins only or None
- Label
- Icon
- Sort order

## Pricing

This module is free, but the result of a lot of work for design and maintenance over time.

If it's useful to you, please consider [making a donation](https://www.cuzy.app/checkout/donate/) or [participating in the code](https://github.com/cuzy-app/humhub-modules-auth-keycloak). Thanks!

## Repository

https://github.com/cuzy-app/menu-manager

## Publisher

[CUZY.APP](https://www.cuzy.app/)

## Licence

[GNU AGPL](https://github.com/cuzy-app/clean-theme/blob/master/docs/LICENCE.md)
