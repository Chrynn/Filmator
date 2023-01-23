## Generování SSH
> - může být nudné neustále vyplňovat informace při použití HTTP
> - vygenerujeme SSH - jinak nemůžeme používat SSH metodu při klonování `permision denied`
> - zeptá se nás na vytvoření "passphrase" - zapamatovat (bude to chtít při klonovaní)
> - pri přegenerovaní je potřeba nově přidat do všech git aplikací (github, gitlab atd.)

- vygenerujeme SSH soubor a vypíše cestu k němu
> pokud nevygeneruje cestu, nachází se v:
> - `cd ~`
> - `ls -la` - s `a` vypíše i skryte soubory
> - `cd .ssh`
> - nyní vypíše `id_rsa` - soukromý (nikde nezveřejňovat) a `id_rsa.pub` - veřejny (necháme vypsat)
```
ssh-keygen -o
```
- necháme vypsat obsah vygenerovaného SSH souboru (zkopirujeme celé)
```
cat "link"
```
- nyní v Githubu přidáme tento klíč mezi ostatní - záložka `SSH and GPG keys`
