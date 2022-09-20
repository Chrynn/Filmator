## Připravení projektu

- vytvoření složky
```
mkdir "nazev"
```
- smazání složky
```
rmdir "nazev"
```
- složku vytvářet v Ubuntu konzoli, ale klonovat v PHPStorm konzoli

## Získání projektu
- bude potřeba mít vygenerovaný SSH klíč (pokud nemáme)
```
git clone "repository"
```

## Rozjetí projektu

> Pozn.
> - číslo portu nastavíme v `nginx/default.conf` a v `docker-compose.yml`
> - název databáze nastavíme v `docker-compose.yml`

- pro první rozjetí vybuildíme image
```
make up:build
```
- nahodíme stránku
```
make up
```
- přepneme se do PHP kontejneru
```
make exec:php
```
- aktualizujeme `composer.json` (nainstalujeme `vendor` složku)
```
composer update
```
- opustíme kontejner
```
exit
```
- vytvoříme složku pro cache `temp` (cache se generuje sama)
- nastavíme ji práva
```
chmod 777 temp
```
- do složky "config" vytvoříme `local.neon` soubor
```neon
parameters:


database:
    dsn: 'mysql:host=127.0.0.1;dbname=test'
    user:
    password:

# nextras mailer
tracy:
	bar:
		- Nextras\MailPanel\MailPanel(%tempDir%/mail-panel-latte)

services:
	nette.mailer:
		class: Nette\Mail\Mailer
		factory: Nextras\MailPanel\FileMailer(%tempDir%/mail-panel-mails)
```
- přidáme konzoli práva pro spuštění `make init` příkazu
```
sudo chmod 777 bin/console
```
- nahodíme databázi
```
make init
```
> pokud jsme na windows
> - upravit kódování `bin/console` z CRLF na LF (pravo dole) - jinak nepůjde (error)
