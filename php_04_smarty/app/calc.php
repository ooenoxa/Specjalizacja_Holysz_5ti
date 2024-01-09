<?php
// kontroler kalkulatora
require_once dirname(__FILE__).'/../config.php';
//ladowanie smarty
require_once _ROOT_PATH.'/libs/Smarty.class.php';



//ochrona kontrolera


function getParams(&$form){
    $form['kwota'] = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
    $form['rata'] = isset($_REQUEST['rata']) ? $_REQUEST['rata'] : null;
    $form['operacja'] = isset($_REQUEST['operacja']) ? $_REQUEST['operacja'] : null;
}
	
// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku
	function validate(&$form,&$infos,&$msgs,&$hide_intro){
		// sprawdzenie, czy parametry zostały przekazane
		if ( ! (isset($form['kwota']) && isset($form['rata']) && isset($form['operacja']))) {
			//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false;
		}
		$hide_intro = true;
		$infos [] = 'Przekazano parametry.';
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ( $form['kwota'] == "") {
			$msgs [] = 'Nie podano kwoty';
		}
		if ( $form['rata'] == "") {
			$msgs [] = 'Nie podano liczby liczby rat';
		}
		if ( $form['operacja'] == "") {
			$msgs [] = 'Nie podano liczby oprocentowania';
		}

		//nie ma sensu walidować dalej gdy brak parametrów
		if (count ( $msgs ) != 0) return false;

		// sprawdzenie, czy $x i $y są liczbami całkowitymi
		if (! is_numeric( $form['kwota'] )) {
			$msgs [] = 'Kwota nie jest liczbą całkowitą';
		}
		
		if (! is_numeric( $form['rata'] )) {
			$msgs [] = 'Rata wartość nie jest liczbą całkowitą';
		}

		if (! is_numeric( $form['operacja'] )) {
			$msgs [] = 'Operacja nie jest liczbą całkowitą';
		}		
		
		if (count($msgs)>0) return false;
		else return true;
	}

	function procces(&$form, &$infos, &$msgs, &$result) {
		$infos[] = 'Parametry poprawne. Wykonuję obliczenia.';
		
		//konwersja parametrów na int
		$form['kwota'] = intval($form['kwota']);
		$form['rata'] = intval($form['rata']);
		$form['operacja'] = intval($form['operacja']);
	
		//wykonanie operacji
		$procent = $form['operacja'] * 0.01;
		$wynik1 = $form['kwota'] * $procent;
		$wynik2 = $form['kwota'] + $wynik1;
		$wynik3 = $wynik2 / $form['rata'];
		$result = $wynik3;
	}
	
	
	//definicja zmiennych kontrolera
	$form = null;
	$infos = array();
	$messages = array();
	$result = null;

	//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
	getParams($form);
	if (validate($form, $infos, $messages, $hide_intro)) {
    procces($form, $infos, $messages, $result); 
}
	$smarty = new Smarty();

	$smarty->assign('app_url',_APP_URL);
	$smarty->assign('root_path',_ROOT_PATH);
	$smarty->assign('page_title','Przykład 04');
	$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
	$smarty->assign('page_header','Szablony Smarty');
	
	//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
	$smarty->assign('form',$form);
	$smarty->assign('result', $result);
	$smarty->assign('messages',$messages);
	$smarty->assign('infos',$infos);
	

	//wywołanie szablonu
	$smarty->display(_ROOT_PATH.'/app/calc_view.html');