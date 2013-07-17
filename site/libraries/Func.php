<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Func {
	
/**
 * Returns page name
 *
 * @access	public
 * @param	active record object with page_id
 * @param	int id to be matched to page_id
 * @return	string of pretty name
 */
	public function make_navigation()
	{ 

	}	
	
/**
 * Returns page name
 *
 * @access	public
 * @param	active record object with page_id
 * @param	int id to be matched to page_id
 * @return	string of pretty name
 */
	public function return_page_name($pages, $id)
	{
		foreach($pages as $page){
			if($page->id == $id){
				return $page->pretty_name;
			}
		}
	}

}
?>