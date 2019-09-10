<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Special Selector Helper.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Special_Selector
{

	public static function createSpecialSelector($responseTextId, $resultsId, $results, $placeholder, $extraButton = null, $attributes = null){
		$result = '';
		$extraButtonElement = '';
		$options = '';

		if(!is_null($extraButton)){
			$extraButtonElement = '<li><br></li>';
			$extraButtonElement = $extraButtonElement.'<li><a'; 
			foreach ($extraButton as $key => $value) {
				if($key !== "value")
					$extraButtonElement = $extraButtonElement.' '.$key.'="'.$value.'"';
			}
			$extraButtonElement = $extraButtonElement.'>'.$extraButton["value"].'</a></li>';
		}

		if (isset($results)) {
			$length = sizeof($results);
			for ($i=0; $i < $length; $i++) {
				$id = $results[$i][0];
				$text = $results[$i][1];
				$options = $options.'<li><a href="javascript:updateResponse('.$id.','.$resultsId.','.$responseTextId.',\''.$text.'\')">'.$text.'</a></li>';
			}
		}

		$atributos = '';
		if(isset($attributes)){
			foreach ($attributes as $key => $value) {
				$atributos = $atributos." ".$key."='".$value."'";
			}
		}

		$result = 	'<div class="col-xs-12 col-sm-12">
						<ul class="col-xs-12 selector">
								<li class="response">
									<input type="hidden" name="'.$responseTextId.'_option_selected" id="'.$responseTextId.'_option_selected" value="">
									<input class="form-control" type="text" placeholder="'.$placeholder.'" name="'.$responseTextId.'" value="" id="'.$responseTextId.'" onfocus="javascript:handleFocus('.$resultsId.',true)" onfocusout="javascript:handleFocus('.$resultsId.',false)"'.$atributos.'>
									<ul id="'.$resultsId.'">'.
										$options
										.$extraButtonElement.'
						            </ul>
						        </li>
						        <li class="button">
									<a href="javascript:toogleSelector('.$responseTextId.', '.$resultsId.')">v</a>
								</li>
						</ul>
						
					</div>';

		return $result;
	}
}
