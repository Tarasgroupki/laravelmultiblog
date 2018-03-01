<?php

namespace App\Widgets;

use Klisl\Widgets\Contract\ContractWidget;
use Illuminate\Support\Facades\DB;

/**
 * Class TestWidget
 * Класс для демонстрации работы расширения
 * @package App\Widgets
 */ 
class LanguagesWidget implements ContractWidget{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function execute(){
		$langs = DB::table('languages')->get();
		
		return view('Widgets::languages',['langs' => $langs]);
		
	}	
}
