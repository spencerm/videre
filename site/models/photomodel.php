<?php

/**
  * photos controller
  * displays photo collections with medium photos
  * 
  * @author		Spencer McCormick
  * @link		http://spencermccormick.com/photos
  * 
**/ 

class Photomodel extends CI_Model {

	// photo-index
	function get_folders()
    {
        $this->db->from('videre_photos');
		return $this->db->get()->result();
    }

	// photo-folder
	function get_photos_by_folder($folder)
    {
        $this->db->from('videre_photos')->where('photo_folder', $folder);
		return $this->db->get()->result();
    }
	function get_photos_by_tag($tag)
    {
    	$this->db->from('videre_pages')->where('uri', $tag);
    	$query = $this->db->get()->row()->photo_id();
        $this->db->select('*')->from('videre_relations')->where('page_id', $query);
		$this->db->join('videre_photos', 'videre_photos.photo_id = videre_relations.photo_id')->order_by('rating','desc');
		return $this->db->get()->result();
    }
	/**
	  * 
	  * 
	**/
	function get_photo($id, $ref)
	{
		$photo->current 	= $this->get_photo_by_id($id);
		$photo->tags 		= $this->get_photo_tags($id);
		$photo->previous 	= $this->get_previous_photo($id, $ref);
		$photo->next		= $this->get_next_photo($id, $ref);

		/*
		switch ($type) {
			case 'folder':
				$photo->previous 	= $this->get_previous_photo_in_folder($ref, $id);
				$photo->next		= $this->get_next_photo_in_folder($ref, $id);
				break;
			case 'tag':
				$photo->previous 	= $this->get_previous_photo_by_tag($ref, $id);
				$photo->next		= $this->get_next_photo_by_tag($ref, $id);
				break;
			case 'page':
				$photo->previous 	= $this->get_previous_photo_in_page($ref, $id);
				$photo->next		= $this->get_next_photo_in_page($ref, $id);
				break;
			default:
				echo "error not proper photo type"	
				break;
		}
		*/
	}
	/**
	  * 
	  * 
	**/
	function get_photo_by_id($id)
	{
		$this->db->from('videre_photos')->where('photo_id', $id);
		return $this->db->get()->row();
	}
	function get_photo_tags($id)
    {
        $this->db->select('*')->from('videre_realtions')->where('photo_id', $id);
        $this->db->join('videre_photos', 'videre_photos.id = videre_relations.id');
		return $this->db->get()->result();
    }
		/*
	function get_previous_photo_by_tag($ref, $id)
    {
		$this->db->from('videre_tags')->where('slug', $ref)->where('photo_id <', $id)->order_by('photo_id', 'desc')->limit(1);
		$query = $this->db->get()->row();
		if(isset($query->photo_id)){
			return $this->get_photo_by_id($query->photo_id);
		} else {
			$this->db->select_max('photo_id')->from('videre_tags')->where('slug', $ref);
			return $this->get_photo_by_id($this->db->get()->row()->photo_id);
		}
	}
	function get_next_photo_by_tag($ref, $id)
    {
		$this->db->from('videre_tags')->where('slug', $ref)->where('photo_id >', $id)->order_by('photo_id', 'asc')->limit(1);
		$query = $this->db->get()->row();
		if(isset($query->photo_id)){
			return $this->get_photo_by_id($query->photo_id);
		} else {
			$this->db->select_min('photo_id')->from('videre_tags')->where('slug', $ref);
			return $this->get_photo_by_id($this->db->get()->row()->photo_id);
		}
    }
	function get_previous_photo_in_folder($ref, $id)
    {
		$this->db->from('videre_photos')->where('photo_folder', $ref)->where('photo_id <',$id)->limit(1);
		$query = $this->db->get()->row();
		if(isset($query->photo_id)){
			return $query;
		} else {
			$this->db->select_max('photo_id')->from('videre_photos')->where('photo_folder', $ref);
			return $this->get_photo_by_id($this->db->get()->row()->photo_id);
		}
	}
	function get_next_photo_in_folder($ref, $id)
    {
		$this->db->from('videre_photos')->where('photo_folder', $ref)->where('photo_id >', $id)->limit(1);
		$query = $this->db->get()->row();
		if(isset($query->photo_id)){
			return $query;
		} else {
			$this->db->select_min('photo_id')->from('videre_photos')->where('photo_folder', $ref);
			return $this->get_photo_by_id($this->db->get()->row()->photo_id);
		}
    }
*/
    function get_previous_photo($id, $ref)
    {
		$this->db->from('videre_relations')->where('page_id', $ref)->order_by('order')->where('photo_id <',$id)->limit(1);
		$query = $this->db->get()->row();
		if(isset($query->photo_id)){
			return $query;
		} else {
			$this->db->select_max('order')->from('videre_relations')->where('page_id', $ref);
			return $this->get_photo_by_id($this->db->get()->row()->photo_id);
		}
	}
	function get_next_photo($id, $ref)
    {
		$this->db->from('videre_relations')->where('page_id', $ref)->order_by('order')->where('photo_id >', $id)->limit(1);
		$query = $this->db->get()->row();
		if(isset($query->photo_id)){
			return $query;
		} else {
			$this->db->select_min('order')->from('videre_relations')->where('page_id', $ref);
			return $this->get_photo_by_id($this->db->get()->row()->photo_id);
		}
    }
	// backend
	function remove_tag($id)
    {
			$this->db->where('photo_id', $id);
			$this->db->delete('videre_tags');
	}
	function add_tag($tag)
	{
			$this->db->insert('videre_tags', $tag);
	}
	function update_photo($photo)
    {
		$data = array(
				'photo_name'			=>		$photo->name,
				'photo_date_taken'	=>		$photo->date_taken
			);
		$this->db->where('photo_id', $photo->photo_id);
		$this->db->update('videre_photos', $data);
	}	
	function delete_photo($photo)
    {
		$this->db->where('photo_id', $photo->photo_id);
		$this->db->delete('videre_photos');
		
		$this->db->where('photo_id', $photo->photo_id);
		$this->db->delete('videre_tags');
	}
    function add_photo($photo)
    {
		$data = array(
			'photo_name'			=>		$photo->name,
			'photo_folder'			=>		$photo->folder,
			'photo_filename'		=>		$photo->filename,
			'photo_description'		=> 		$photo->description,
			'photo_rating'			=> 		$photo->rating,
			'photo_date_taken'		=> 		$photo->date_taken
		);
		$this->db->insert('videre_photos', $data);
        
			// add tags to videre_tags table
		$this->db->from('videre_photos')->where('photo_folder', $photo->folder)->where('photo_filename', $photo->filename);
		$photo_id = $this->db->get()->row();
		
		foreach($photo->tags as $tag){
			$tag['photo_id'] = $photo_id->photo_id;
			$this->add_tag($tag);
		}

		
    }

}