## Pripraveni projektu
- vytvoreni slozky
```
mkdir "nazev"
```
- smazani slozky
```
rmdir "nazev"
```
- slozku vytvaret v Ubuntu konzoli ale klonovat v PHPStorm konzoli

## Získání projektu
```
git clone "repository"
```

## Rozjetí projektu

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
- přepneme se do php kontejneru
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
- vytvoříme složku pro cache "temp" (cache se generuje sama)
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
> pokud jsme na windows
> - přidat `bin/console` z CRLF na LF kódování (pravo dole) - jinak nepůjde (error)
```
make init
```
