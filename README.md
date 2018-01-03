# jwt-auth-firebase
Replace [jose](https://github.com/namshi/jose) (who is depracated) with [firebase](https://github.com/firebase/php-jwt) provider in [jwt-auth](https://github.com/tymondesigns/jwt-auth) 

### Installation
* First, install me with composer in your Laravel project :

```
composer require "pierrocknroll/jwt-auth-firebase @dev"
```

* Then change the config file of jwt-auth (config/jwt.php), under providers :
```
'jwt' => Pierrocknroll\JwtAuthFirebase\Firebase::class,
```
