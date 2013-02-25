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
$DB_HOST='192.168.5.173';	// dies ist WICHTIG !!!!
$DB_NAME='db451197603';		//
$DB_USER='dbo451197603';			// Achtung user muss vorhanden sein und die rechte auf die DB haben
$DB_PASS='dbo451197603';				// !!

// $DB_HOST='db451197603.db.1and1.com';
// $DB_NAME='db451197603';
// $DB_USER='dbo451197603';
// $DB_PASS='db42039950';

$TBL_USER='user_liste';		// Tabellname fuer die Userliste m, muss bestimmte Felder beinhalten

?>