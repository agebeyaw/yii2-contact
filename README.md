#Yii2 contact us module
##Description
Yii2 contact us module


##Install
```php
composer require demmonico/yii2-contact
```


##Configure 

```php
// main.php
'modules' => [
    'contact' => [
        'class' => 'demmonico\contact\Module',
        // configure
        'adminEmail' => 'demmonico@gmail.com',
        'mailerComponent' => 'mailer',
        'pageTitle' => 'APP_NAME - Contact Us',
    ],
],
```
```php
// routes
'/contact' => 'contact/contact/index',
'/contact/<action:[\w-]+>' => 'contact/contact/<action>',
```


###Migrations
```php
php ./yii migrate/up --migrationPath=@vendor/demmonico/yii2-contact/src/migrations
```
