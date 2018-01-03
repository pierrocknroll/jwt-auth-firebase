# jwt-auth-firebase
Replace [jose](https://github.com/namshi/jose) (who is depracated) with [firebase](https://github.com/firebase/php-jwt) provider in [jwt-auth](https://github.com/tymondesigns/jwt-auth) 

### Installation
* First, install [firebase/php-jwt](https://github.com/firebase/php-jwt) with composer in your Laravel project :

```
composer require firebase/php-jw
```

* Install the provider in **app/Providers/JWT/**

* Then change the config file of jwt-auth, under providers :
```
'jwt' => App\Providers\JWT\Firebase::class,
```
