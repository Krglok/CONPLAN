CONPLAN
=======
php homepage for larp orga and conplaning
no multilanguage, german only (sorry)

Verschiede Bereiche der Homepage:
- PUBLIC , ohne login
- USER , mit login
- AUTHOR , zum bearbeiten des Content
- SUBSL , fuer die Con-Planung
- SL , fuer Regelwerke und Regeln
- ADMIN , fuer Homepageverwaltung und -konfiguration

Features:
- Die Bereiche ab USER sind  mit login.
- Eigene Userverwaltung mit Zugriffsgruppen.
- Die Bereiche sind auch die Zugriffsgruppen.
- Contentbearbeitung Online für HTML und Datenbank.
- Konfigureirbares Hilfesystem.
- Datenbank MySQL
- Scripte PHP 5.4, Javascript
- ckEditor ein open source Inline Editor.


Datenbank mit diversen Datentabellen fuer:
- News
- Terminliste fuer eigene Cons
- internes Forum
- Bildergalerie
- Regelwerk
- Charakterverwaltung
- NSC-Verwaltung
- Conplanung
- Con-Anmeldung für User
Das Layout kann mit CSS geändert werden.

Detaillierte Beschreibung der Bereiche
<h3>Bereich Public</h3>
- Newsliste
- Terminliste
- Subbereichen fuer Regeln, Orga, Land mit HTML-Seiten
- Impressum als HTML
- Veranstalter als HTML
- Bildergalerie
- Con-Berichte
- Download
- Spielerliste
- Login fuer internen Bereich

<h3>Bereich Intern</h3>
- Userverwaltung (Datenbank)
- Spielerverwaltung (Datenbank)
- Forum
- erweiterte Bildergalerie, mit Upload und Kommentaren (Datenbank)
- Legendenliste als Hintergrund des Spiels (Datenbank) nur Lesen
- Con-Anmeldung
- Regelwerk (Datenbank)
- Spruchliste (Datenbank)
- Trankliste (Datenbank)
- erweiterte Con-Berichte mit Erstellung neuer Berichte (Datenbank)
- Bibliothek (Datenbak) 
- Charakterverwaltung mit XP Verwaltung pro und Fertigkeiten (Datenbank)

<h3>Autoren Zugriff</h3>
- Bearbeitung der Subbereiche 
- Bearbeitung der Con-Berichte

<h3>SUBSL Zugriff</h3>
- Contage fuer Anmeldung (Datenbank)
- Conplanung fuer Con-tage (Datenbank)

<h3>SL Zugriff</h3>
- Bearbeitung Regelwerk
- Bearbeitung Spruchliste (Datenbank)
- Bearbeitung Trankliste (Datenbank)
- Bearbeitung Artefakte
- Bearbeitung NSC-Verwaltung (wie Charakterverwaltung) Datenbank
- Bearbeitung Legenden (Datenbank)

<h3>ADMIN Zugriff</h3>
- User/Spielerverwaltung
- Contageverwaltung / Contagezugriff
- Terminverwaltung
- Bildergalerieverwaltung
- Bibliothekverwaltung
- Newsverwaltung
- Charakterverwaltung
- Downloadverwaltung
- Bearbeitung System HTML Pages
- Bearbeitung Helpsystem
- Configuration Datentabellen
- Configuration Datenliste
- Configuration Subbereiche 
 
 <h2>technische Features</h2>
 - Steuerung der Applikation komplett in PHP
 - Einbinden von Datenbanktabellen als Listen oder Detailansichten
 - Einbinden von HTML-Seiten als Daten
 - RT-Editor (ckEditor) für die HTML-Seiten und Contenttexte
 - komplett auf CSS-Layout aufgebaut
 - konfigurierbar Hntergrund
 - konfigurierbare Bilder fuer Logos, Buttons
 - Userverwaltung mit hierarchischen Zugrifssrechten
 - Der gesamte Content ist Onluine bearbeitbar
 - Die Applikation läuft in einem Verzeichnis
 - erprobtes Sytem, die Applikation ist seit 2002 im Einsatz
 
 <h3>Voraussetzungen</h3>
 - PHP 5.x
 - Datenbank MySQL 5.x Schema MyISAM
 - ckEditor (javasript)
 - phpMyAdmin
  
  <h3>locale Testversion</h3>
  Eine lokale Testversion läuft mit XAMP.
  Es gibt eine betriebsbereite, lokale Testinstalltion .
   
  ACHTUNG: Eine XAMP Installtion ist nicht fuer den Betrieb im Internet geeignet !!
  