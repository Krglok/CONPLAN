<?php
/*
  Projekt :  MAIN

  Datei   :  main.php

  Datum   :  2002/06/12 

  Rev.    :  2.0 

  Author  :  Olaf Duda

  beschreibung :
            Ueber das Script wird der Oeffentliche Teil der HP abgewickelt.
            Es gibt keine Zugriffsverwaltung und keine Rechte !
            Es werden Datenbanklisten generiert.
            Es werden Subseiten mit eigenen PHP-scripten aufgerufen.
            Es werden HTML Seiten angezeigt.
            Die HTML Seiten befinden sich im verzeichnis
            
            ./
            
            Die images kommen aus dem Verzeichnis 
            
            ./images

            Die HTML Seiten werden mit der Funktion 
            
            function print_data($html_file)
            
            dargestellt.

            Die zugehoerigen HTML Seiten sollten in einem Subdir sein 2)
            Alle PHP-Scripte sind in einem Verzeichnis. siehe 1)
            Die Uebergabe Parameter werden aus den $_GET, $_POST
            Variablen geholt.
            
    1) Anmerkung: Alle Scripe muessen in einem Verzeichnis sein, da sonst
                  eine Wiederverwendung nicht moeglich ist.
                  Die Include zeigen dann auf ein falsches Verzeichnis !

    2) Anmerkung: Die HTML Steien liegen in einem Unterverzeichnis.
                  Dies hat zur Folge, dass die Bilder in einem Pfad unterhalb
                  des Aufrufpfades liegen. Ein Rueckschritt "../" ist daher nicht
                  notwendig.
                  Diese ist zwar etwas umstaendlich bei der Erstellun, aber ohne
                  Unterverzeichnisse findet man seinen HTML Seiten fuer einen Bereich
                  nicht wieder zusammen.

  1.1  2004/01/27   Länge des Kalenders geaendert, kw1, kw2 nicht LIMIT des SELECT
  #1   20.11.2007		Länge des Kalenders geändert, "AND  < kw2 "  entfernt, damit alle 
  									folgenden Wochen angezeigt werden. 
  									Folgejahr mit abgefragt durch "OR jahr =$j1
  									Order Klausel geaendert auf "jahr,kw"

  REVISION          
  #2  09.06.2008    Die Page wurde auf ein geaendertes Session Managment und
                    einen veraenderte Konfiguration eingestellt
                    - einheitliches Layout
                    - funktionen fuer Bilder und Icon im Kopf
                    - print_body(typ) mit dem Hintergrundbild der Seite
                    - print_kopf  mit
                        - LOGO links
                        - LOGO Mitte
                        - Text1, Text2  fuer rechte Seite

  MACHT nur die weiterleitung zur neuen Seite
*/


header ("Location: conplan/main.php?md=0");  // Umleitung des Browsers
exit;  // Sicher stellen, das nicht trotz Umleitung nachfolgender
// Code ausgeführt wird.




?>