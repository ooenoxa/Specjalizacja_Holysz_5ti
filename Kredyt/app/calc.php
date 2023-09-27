<?php
require_once dirname(__FILE__).'/../config.php';


$kwota = $_REQUEST ['kwota'];
$procent = $_REQUEST ['procent'];
$rata = $_REQUEST ['rata'];

// Walidacja danych
if ( ! (isset($kwota) && isset($procent) && isset($rata))) {
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}


if ( $kwota == "") {
	$messages [] = 'Nie podano kwoty kredytu!!';
}
if ( $procent == "") {
	$messages [] = 'Nie podano oprocentowania!!';
}
if ( $rata == "") {
	$messages [] = 'Nie podano ilości rat!!';
}

if (empty( $messages )) {
	

	if (! is_numeric( $kwota )) {
		$messages [] = 'Kwota nie jest liczbą całkowitą!!';
	}
	
	if (! is_numeric( $procent )) {
		$messages [] = 'Procent nie jest liczbą całkowitą!!';
	}

	if (! is_numeric( $rata )) {
		$messages [] = 'Rata nie jest liczbą całkowitą!!';
	}

}


if (empty ( $messages )) {
	
	
	$kwota = intval($kwota);
	$procent = floatval($procent); //liczba zmiennoprzecinkowa
	$rata = intval($rata);


	$oproc_kwota = $kwota*($procent/100);
	$wynik = $oproc_kwota + $kwota;
	$wynik = round($wynik,2); //Zaokrąglanie wyniku do dwóch liczb po przecinku

}

include 'kredyt_widok.php';