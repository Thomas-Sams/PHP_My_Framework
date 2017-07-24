<?php

namespace jupiter;

abstract class Controller
{
	protected $layout = 'default';

	function render($view, $data = null){
		
		$params = explode(":", $view);
        $controllerName = $params[0];
        $viewName = $params[1];

		ob_start();

		require(ROOT.'app/views/'.$controllerName.'/'.$viewName.'.html');

		$content_for_layout = ob_get_clean();

		if($data != null){
			foreach ($data as $key => $value){
				
	            $content_for_layout = str_replace("{{ $key }}", $value, $content_for_layout);
	        }
    	}

     	if($this->layout == false){

			echo $content_for_layout;
		}
		else{

			require(ROOT.'app/views/layout/'.$this->layout.'.html');
		}
	}
}