```php
define('TOKEN', '管理=>设置=>其他 令牌 的值');
define('HOST', '域名');

use Hercules\AlistURLSigner\Signer;
$signer = new Signer(HOST, TOKEN, true, 0);
echo $signer->sign('/your-filename');
```
