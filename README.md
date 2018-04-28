# PHPFuncs

PHP user defined functions for quick use on your projects.

Installation
------------

PHP 5.6+ is required.
```
composer require josephnc/phpfuncs
```

Usage
-------

```php
require_once __DIR__ . '/vendor/autoload.php';

#use function JosephNC\PHPFuncs\<function_name_here>;

use function JosephNC\PHPFuncs\real_ip;
use function JosephNC\PHPFuncs\is_array_equal;

$array1 = [
    'foo' => 'bar',
    'bar' => 'foo',
];

$array2 = [
    'bar' => 'foo',
    'foo' => 'bar',
];

$ip_address = real_ip();
$equal      = is_array_equal($array1, $array2);

echo 'Here is your IP Address: ' . $ip_address . '<br>';

if ($equal) {
    echo 'Your arrays are equal!';
} else {
    echo 'Your arrays are not equal.';
}
```

Output:
```
Here is your IP Address: 127.0.0.1
Your arrays are equal!
```

New Functions
-------
If you will like your custom functions to be added to this repository, please contact me.
Thanks.
