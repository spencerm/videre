<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends CI_Controller {

	/**
	  * index function to take apart all 'photo' urls
	  * grabs paramaters from url 
	**/
	public function index()
	{
		// ------- set variables from url ------- \\
		$uri_part_two = $this->uri->segment(1, 0);
		$uri_part_three = $this->uri->segment(2, 0);
		$single_photo = urldecode($this->uri->segment(3, 0));
		// ------- set page defaults ------- \\
		$data['page']->url = base_url($uri_part_two."/".$uri_part_three."/");			
		$data['page']->pretty_name = $data['page']->name = preg_replace('/[^a-z]/i', ' ', $uri_part_three);	
		$data['page']->description = 'pictures of '.$uri_part_three;
		$data['page']->type = 'photo';	
		

		// @uri-segment-4, if true display single photo page
		if($single_photo){
			$data['photo'] = $this->Photomodel->get_photo_by_id($single_photo);
			$data['tags'] = $this->Photomodel->get_photo_tags($single_photo);
			if($uri_part_two === 'tag'){
				$data['page']->next_photo = $this->Photomodel->get_next_photo_from_tags($uri_part_three,$single_photo);
				$data['page']->previous_photo = $this->Photomodel->get_previous_photo_from_tags($uri_part_three,$single_photo);
			} else {
				$data['page']->next_photo = $this->Photomodel->get_next_photo($uri_part_three,$single_photo);
				$data['page']->previous_photo = $this->Photomodel->get_previous_photo($uri_part_three,$single_photo);
			}
			$this->showSingle($data);
		// @uri-segment-2, if 'tag' display folder page
		} else if ($uri_part_two === 'tag' && $uri_part_three) {
			$data['page']->photos = $this->Photomodel->get_photos_by_tag($uri_part_three);
			$this->showfolder($data);
		// @uri-segment-2, if 'collection' display folder page
		} else if ($uri_part_two === 'collection' && $uri_part_three) {
			$data['page']->photos = $this->Photomodel->get_photos_by_collection($uri_part_three);
			$this->showfolder($data);
		// @uri-segment-2, check if page
		} else if($this->Pagemodel->get_page_by_name($uri_part_two)){
			// set all $data['page'] to new page from database
			$data['page'] = $this->Pagemodel->get_page_by_name($uri_part_two);
			// if page get photos to display from page text
			if($data['page']->text){
				$photo_ids = explode(',',$data['page']->text);
				$data['page']->photos = array();
				foreach($photo_ids as $id){
					array_push($data['page']->photos,$this->Photomodel->get_photo_by_id($id));
				}
				$data['page']->titling = 'collections';
			// if that fails display new collection
			} else {
				$data['page']->photos = $this->Photomodel->get_photos_by_collection($uri_part_two);
				$data['page']->titling = 'photos';
			}
			$this->showIndex($data);
		// @nothing / display collections
		} else {
			$data['page']->photos = $this->Photomodel->get_collections();
			$data['page']->titling = 'collections';
			$data['page']->pretty_name = 'photos';
			$data['page']->description = 'africa by bicycle';
			$this->showIndex($data);
		}
	}
	
	private function showSingle ($data){
		$this->output->cache(10080);
		$this->load->view('header', $data);
		$this->load->view('photo/photo-single', $data);
	}
	private function showfolder ($data){
		$this->output->cache(10080);
		$this->load->view('header', $data);
		$this->load->view('photo/photo-collection', $data);
	}
	// displays larger photos and more descriptive text than folder
	private function showIndex ($data){
		$this->output->cache(10080);
		$this->load->view('header', $data);
		$this->load->view('photo/photo-index', $data);
	}
}