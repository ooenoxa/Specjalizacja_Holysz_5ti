<?php
require_once dirname(__FILE__).'/../config.php';
	
function getParams(&$kwota,&$procent,&$rata){
	$kwota= isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$procent = isset($_REQUEST['procent']) ? $_REQUEST['procent'] : null;
	$rata = isset($_REQUEST['rata']) ? $_REQUEST['rata'] : null;	
}


	

//walidacja parametrów z przygotowaniem zmiennych dla widoku
function validate(&$kwota,&$procent,&$rata,&$messages){
	// sprawdzenie, czy parametry zostały przekazane
	if ( ! (isset($kwota) && isset($procent) && isset($rata))) {
		// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
		// teraz zakładamy, ze nie jest to błąd. Po prostu nie wykonamy obliczeń
		return false;
	}

	// sprawdzenie, czy potrzebne wartości zostały przekazane
	if ( $kwota == "") {
		$messages [] = 'Nie podano liczby 1';
	}
	if ( $procent == "") {
		$messages [] = 'Nie podano liczby 2';
	}

	//nie ma sensu walidować dalej gdy brak parametrów
	if (count ( $messages ) != 0) return false;
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $kwota )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $procent )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	

	if (count ( $messages ) != 0) return false;
	else return true;
}
function process(&$kwota,&$procent,&$rata,&$messages,&$wynik){
	$kwota = intval($kwota);
	$procent = floatval($procent); //liczba zmiennoprzecinkowa
	$rata = intval($rata);





	$oproc_kwota = $kwota*($procent/100);
	$wynik = $oproc_kwota + $kwota;
	$wynik = round($wynik,2); //Zaokrąglanie wyniku do dwóch liczb po przecinku
}
	//definicja zmiennych kontrolera
$kwota = null;
$procent = null;
$rata = null;
$wynik = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kwota,$procent,$rata);
if ( validate($kwota,$procent,$rata,$messages) ) { // gdy brak błędów
	process($kwota,$procent,$rata,$messages,$wynik);
}


include 'calc_view.php';