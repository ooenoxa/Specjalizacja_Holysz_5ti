<?php
require_once dirname(__FILE__).'/../config.php';
include _ROOT_PATH.'/app/security/check.php';

	
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
		$messages [] = 'Nie podano kwoty kredytu';
	}
	if ( $procent == "") {
		$messages [] = 'Nie podano oprocentowania';
	}
	if ( $rata == "") {
		$messages [] = 'Nie podano ilości rat kredytu';
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
//liczenie raty
function process(&$kwota,&$procent,&$rata,&$messages,&$wynik){
	global $role;
	$kwota = intval($kwota);
	$procent = floatval($procent); //Procent może być zmiennoprzecinkowy
	$rata = intval($rata);

	//wykonanie operacji
	if($role=='admin'){
	$wynik= (( $procent / 100) * $kwota + $kwota) / $rata;
	$wynik = round($wynik, 2); 
	}
	if($role=='user'){
		if($procent > 4.5){
			$messages [] = 'Tylko administrator może mieć oprocentowanie większe niż 4.5%';
		}
		if($kwota > 200000){
			$messages [] = 'Tylko administrator może mieć kwotę większą  niż 200000';
		}
	}
	if($procent < 4.5 && $kwota < 200000){
		$wynik= (( $procent / 100) * $kwota + $kwota) / $rata;
		$wynik = round($wynik, 2); 
	}

}
 
//kontroler
$kwota = null;
$procent = null;
$rata = null;
$wynik = null;
$messages = array();
getParams($kwota, $procent, $rata);
	if ( validate($kwota,$procent,$rata,$messages) ){
		process($kwota,$procent,$rata,$messages,$wynik);
	}



include 'calc_view.php';



