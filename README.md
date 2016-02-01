ZlepsujemeSkolstvo.sk
=====================

Zdrojový kód aplikácie ZlepsujemeSkolstvo.sk na zbieranie konštruktívnych podnetov k zlepšeniu školstva.

Aplikácia je napísaná v PHP frameworku [Symfony 2.8](http://symfony.com/doc/2.8/index.html)

Ak chceš pomôcť s vývojom, pozri si [Issues](https://github.com/teo-sk/zlepsujemeskolstvo-sk/issues) a pridaj komentár, ak ideš niektorú riešiť. Po vyriešení sprav štandardný Pull Request, ktorý po reviewnutí mergneme a nasadíme; tým aj ty pomôžeš zlepšiť naše školstvo.

K práci so Symfony2 potrebuješ [composer](https://getcomposer.org/download/). Ak ho máš, aplikáciu si rozbeháš takto:

* Naklonuj si tento repozitár
* `composer install`
* nakonfiguruj si `app/config/parameters.yml` podľa svojej databázy
* `php bin/console doctrine:schema:update --force`
* `php bin/console server:run`
* následne na http://127.0.0.1:8000/config.php si skontroluj či tvoj systém splňa požiadavky na symfony
* `php bin/console fos:user:create --super-admin` - vygeneruj si superadmin užívateľa
* `php bin/console sonata:admin:setup-acl`

Následne na http://127.0.0.1:8000 nájdeš aplikáciu a na http://127.0.0.1:8000/admin administrátorské rozhranie.

Za digital_nomads ďakuje a zdraví Teo :)
