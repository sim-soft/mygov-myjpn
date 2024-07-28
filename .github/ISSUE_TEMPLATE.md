Hello,

I encountered an issue with the following code:

```php
$validator = new Validator();
if($validator->validate()) {
    echo 'Valid';
} else {
    echo 'Invalid';
    $validator->getErrors();
}
```

Package version: PUT HERE YOUR PACKAGE VERSION (exact version)

PHP version: PUT HERE YOUR PHP VERSION

I expected to get:

```php
Valid
```
But I actually get:

```php
errors
```
Thanks!
