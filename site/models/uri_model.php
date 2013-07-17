<?php

/**
  * uri_model 
  * contains URI logic
  * 
  * @author		Spencer McCormick
  * @link		http://spencermccormick.com/photos
  * 
**/ 

class Uri_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $uri_part_two 	= $this->uri->segment(1, 0);
		$uri_part_three = $this->uri->segment(2, 0);
		$single_photo 	= urldecode($this->uri->segment(3, 0));
    }

	function get_current_page()
	{
		if($single_photo)
		{
			$data['type']	= 'single';
			$data['id']		= $single_photo;
			$data['ref']	= $uri_part_three;
			$this->db->from('videre_pages')->where('page_type', $data['type'])->where('page_url',$data['ref']);
			$data['page'] 	= $this->db->get()->row();
			return $data;
		}


		elseif ($uri_part_two === 'tag' && $uri_part_three) 
		{

			$data['type'] 	= 'tag';
			$data['ref']	= $uri_part_three;
			$this->db->from('videre_pages')->where('page_type', $data['type'])->where('page_url',$data['ref']);
			$data['page'] 	= $this->db->get()->row();
			return $data;
		}

		elseif ($uri_part_two === 'folder' && $uri_part_three) 
		{
			$data['type'] 	= 'folder';
			$data['ref']	= $uri_part_three;
			$this->db->from('videre_pages')->where('page_type', $data['type'])->where('page_url',$data['ref']);
			$data['page'] 	= $this->db->get()->row();
			return $data;
		}

		elseif ($uri_part_two && !$uri_part_three) {
			$data['type'] 	= 'page';
			$data['ref']	= $uri_part_two;
			$this->db->from('videre_pages')->where('page_type', $data['type'])->where('page_url',$data['ref']);
			$data['page'] 	= $this->db->get()->row();
			return $data;
		}

		elseif (!$uri_part_two) {
			$data['type'] = 'index';
			$this->db->from('videre_pages')->where('page_url',$data['type']);
			$data['page'] 	= $this->db->get()->row();
			return $data;
		}

		else
		{
			$data['type'] = '404';
			$this->db->from('videre_pages')->where('page_url',$data['type']);
			$data['page'] 	= $this->db->get()->row();
			return $data;
		}

	}
}