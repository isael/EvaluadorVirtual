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

	public static function createSpecialSelector($responseTextId, $resultsId, $results, $placeholder, $extraButton = null){
		$result = '';
		$extraButtonElement = '';
		if(!is_null($extraButton)){
			$extraButtonElement = '<li><a href="'.$extraButton->href.'">+ '.$extraButton->value.'</a></li>';
		}
		$result = 	'<div class="col-xs-12 col-sm-12">
						<ul class="col-xs-12 selector">
								<li class="response">
									<input class="form-control" type="text" placeholder="'.$placeholder.'" name="pregunta_texto" value="" id="'.$responseTextId.'" onfocus="javascript:handleFocus('.$resultsId.',true)" onfocusout="javascript:handleFocus('.$resultsId.',false)">
									<ul id="'.$resultsId.'">
										<li><a href="javascript:updateResponse('.$resultsId.','.$responseTextId.',\'Web Development\')">Web Development</a></li>
										<li><a href="javascript:updateResponse('.$resultsId.','.$responseTextId.',\'Logo Design\')">Logo Design</a></li>
										<li><a href="javascript:updateResponse('.$resultsId.','.$responseTextId.',\'Identity & Branding\')">Identity & Branding &raquo;</a></li>
										<li><a href="javascript:updateResponse('.$resultsId.','.$responseTextId.',\'Wordpress\')">Wordpress</a></li>
										<li><br></li>
										'.$extraButtonElement.'
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
