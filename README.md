<p align="center"><img src="https://www.technovacollege.nl/sites/all/themes/custom/technova/logo.svg" width="400"></p>

# Wandelbankje.nl

Wandelbankje.nl is een mobile-first webapplicatie die zitbankjes weergeeft in een lijst en op een kaart.
Bankjes kunnen worden gesorteerd op afstand en er kan een navigatie naartoe geopend worden via Google Maps. Op deze manier kan de gebruiker van de applicatie gemakkelijk een zit plek vinden wanneer hij of zei aan het wandelen is.

Gebruikers kunnen zelf een bankje toevoegen na het maken van een account. Hierbij wordt gebruik gemaakt van de huidige locatie van de gebruiker en kan deze een foto van het bankje toevoegen. Dit is geen vereiste omdat andere geregistreerde gebruikers later ook nog een foto kunnen toevoegen aan het bankje.


Bankjes kunnen worden gerapporteerd omdat het bankje bijvoorbeeld verwijderd of beschadigd (niet meer zitbaar) is. Deze komt dan terecht op de pagina van de moderator waarna deze het bankje kan verwijderen.


Nieuw toegevoegde bankjes of foto’s komen ook terecht op de moderator pagina. Deze kunnen hierna worden geaccepteerd of verwijderd. Nieuwe bankjes zijn wel gelijk zichtbaar op de website, ook als deze nog niet is goedgekeurd.


----------

###<a href="https://wandelbankje.nl/">Live Demo URL</a>

----------

### Installeren:
1. Clone of download de applicatie.
2. Open een terminal in het project en voer `composer install` uit.
3. Voer `npm install && npm run dev` uit.
4. Kopieer .env.example naar .env en configureer de database.
5. Voer `php artisan key:generate` uit in de terminal.
6. Voer `php artisan migrate && php artisan db:seed` om de database tabellen aan te maken en te vullen met test data.

----------
