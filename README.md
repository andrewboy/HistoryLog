# HistoryLog

This is a Laravel 5 package, that can log Model history. 

It's under development, not recommended for production use!

## Installation

1. add bundle to composer: "andrewboy/historylog": "dev-master"
2. composer install / update
3. add service provider to the providers list: 'Andrewboy\HistoryLog\HistoryLogServiceProvider'
4. publish config and migration: php artisan vendor:publish --provider="Andrewboy\HistoryLog\HistoryLogServiceProvider"
5. php artisan migrate
