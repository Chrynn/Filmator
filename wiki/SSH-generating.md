## Generování SSH
> - může být nudné neustále vyplňovat informace při použití HTTP
> - vygenerujeme SSH (jinak nemůžeme používat SSH metodu při klonování - permision denied)
> - zepta se nas na vytvoreni "passphrase" - zapamatovat (bude to chtit pri klonovani)
> - pri pregenerovani potreba nove pridat do vsech git aplikaci (github, gitlab atd.)

- vygenerujeme SSH soubor a vypise cestu k nemu
> pokud nevygeneruje cestu, nachází se v:
> - `cd ~`
> - `ls -la` - s `a` vypise i skryte soubory
> - `cd .ssh`
> - nyni vypise `id_rsa` (soukromy, nikde nezverejnovat) a `id_rsa.pub` (verejny, nechame vypsat)
```
ssh-keygen -o
```
- nechame vypsat obsah vygenerovaneho SSH souboru (zkopirujeme celé!)
```
cat "link"
```
- nyní v Githubu přidáme tento klíč mezi ostatní (záložka "SSH and GPG keys")