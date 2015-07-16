# HistoryLog

This is a Laravel 5 package, that can log Model history. 

It's under development, not recommended for production use!

## Installation

1. add bundle to composer: "andrewboy/historylog": "dev-master"
2. run composer: 

```bash
composer install / update
```

3. add service provider to the providers list: 'Andrewboy\HistoryLog\HistoryLogServiceProvider'
4. publish config and migration: php artisan vendor:publish --provider="Andrewboy\HistoryLog\HistoryLogServiceProvider"
5. php artisan migrate

## Usage

1. You have to create a Trait that uses the "HistoryLog" trait and implement the "getUserId" abstract method.

```php

use Andrewboy\HistoryLog\Traits\HistoryLogTrait;

trait MyHistoryLogTrait{

    use HistoryLogTrait;
    
    /**
     * Get the logged users' ID
     * @return integer | null On success user ID
     */
    public function getUserId()
    {
        ...
    }
}

```

2. Simply just add the trait to your model

```php

use App\Traits\MyHistoryLogTrait;

class MyModel extends Model
{

    use KonicaHistoryLogTrait;
    
}

```
