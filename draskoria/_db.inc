<?php
/**
 * Datenbank Anbindung
 * Umschaltung zwischen 
 * 
 * - lokaler Datenbank / Testumgebung
 * 
 * - produktive Datenbank / Onlineumgebung
 * 
 * Am leichtesten geht dies durch ausklammern
 */
// DB-Verbindung
// $DB_HOST='192.168.5.173';	// dies ist WICHTIG !!!!
// $DB_NAME='db472520777';		//
// $DB_USER='root';			// Achtung user muss vorhanden sein und die rechte auf die DB haben
// $DB_PASS='_root';				// !!

 $DB_HOST='db472520777.db.1and1.com';
 $DB_NAME='db472520777';
 $DB_USER='dbo472520777';
 $DB_PASS='_draskoria';

$TBL_USER='user_liste';		// Tabellname fuer die Userliste m, muss bestimmte Felder beinhalten

?>