Hello,

I encountered an issue with the following code:
```phpt
$validator = new Validator();
if($validator->validate()) {
    echo 'Valid';
} else {
    echo 'Invalid';
    $validator->getErrors();
}
```

WeCanTrack version: PUT HERE YOUR WECANTRACK VERSION (exact version)

PHP version: PUT HERE YOUR PHP VERSION

I expected to get:
```phpt
Valid
```
But I actually get:
```phpt
errors
```
Thanks!