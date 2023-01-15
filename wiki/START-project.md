## Začínáme

- Jelikož projekt používá Linuxové příkazy, je doporučeno používat operační systém `Linux` nebo Virtuální operační systém jako například `Ubuntu`

### Doporučené technologie
- Linux OS based on system (Mac, Ubuntu etc.)
- Docker application (devOps)
- Make (commands) - `sudo apt install make`

### Naklonování repozitáře

- `git clone` naklonuje repozitář do vybrané složky 
- Můžete použít HTTPS (potřeba ověřit identitu) nebo SSH link (potřeba vygenerovat SSH klíč)
- Osobně doporučuji SSH, ale je to na Vás

```
git clone git@github.com:Chrynn/Chess-Club.git
```

### Zapnutí projektu
> nyní máme hlavní soubory projektu, ale ještě bude potřeba přidat pár věcí

- Vytvořte `local.neon` soubor do `config` složky s obsahem níže
- Můžete použít `touch` a `nano` příkazy nebo provést manuálně

```
parameters:

database:
    dsn: 'mysql:host=127.0.0.1;dbname=test'
    user: root
    password: root
    
# nextras mailer
tracy:
	bar:
		- Nextras\MailPanel\MailPanel(%tempDir%/mail-panel-latte)

services:
	nette.mailer:
		class: Nette\Mail\Mailer
		factory: Nextras\MailPanel\FileMailer(%tempDir%/mail-panel-mails)
```

- Použijte Makefile příkaz `make start`, který:
1. nastaví Docker kontejner a image
2. přidá potřebné práva `log` a `cache` složce
3. nastaví composer balíčky jako `vendor` složku
4. načte a vyplní databázi testovacími daty - použije `make init`

> pokud jsme na windows
> - upravit kódování bin/console z CRLF na LF (pravo dole) - jinak nepůjde (error)

```
make start
```
- Nyní by vám měl projekt plně fungovat v prohlížeči na URL adrese `localhost:90` a databázi na `localhost:10000`- **Ujistěte se** že vám neběží nějaký jiný projekt na portu s číslem `90`
> Hotovo, hodně štěstí s testováním projektu!

- Pokud chcete projekt vypnout, provolejte `make down` příkaz
```
make down
```
- Pro znovu zapnutí, provolejte `make up`
```
make up
```