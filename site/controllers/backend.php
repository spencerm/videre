<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/backend
	 */
	public function index()
	{
		$data['page']->description = 'backend admin';
		$data['page']->pretty_name = 'backend admin';
		$data['page']->type = 'backend';
		$data['page']->name = 'backend';
					
		$this->load->view('backend/header', $data);
		$this->load->view('backend/home', $data);
	}
	public function manage_photos($collection)
	{
		$this->load->model('Photomodel');
		$data['photos'] = $this->Photomodel->get_photos_by_collection($collection);
		
		$data['page']->description = $collection.' admin';
		$data['page']->pretty_name = $collection;
		$data['page']->type = 'backend';
		$data['page']->name = 'backend';
					
		$this->load->view('backend/header', $data);
		$this->load->view('backend/manage_photos', $data);
	}
	public function scan_dir()
	{
		$data['page']->description = 'backend admin';
		$data['page']->pretty_name = 'backend admin';
		$data['page']->type = 'backend';
		$data['page']->name = 'backend';
		$data['page']->dir = $this->input->post('dir');
		$data['page']->photo_path = "_photos/".$this->input->post('dir');
		
		// define photo directory path
		$photo_dir = "_photos/".$this->input->post('dir')."/1180/";
		$filenames = scandir($photo_dir);
		
		// iterate over every jpg in directory 
		foreach($filenames as $key => $filename ){
			$info = pathinfo($filename);
			if(array_key_exists('extension', $info)) {
				if (strtolower($info['extension'])=="jpg"){
					$data['page']->photos[$key] = $filename;
				}
			}
		}
		$this->load->view('backend/header', $data);
		$this->load->view('backend/adding_photos', $data);
	}	
	
	public function delete_collection($collection)
	{
		$this->load->model('Photomodel');
		$photos = $this->Photomodel->get_photos_by_collection($collection);
		foreach ($photos as $key => $photo) {
			$this->Photomodel->delete_photo($photo);
		}
		$this->load->view('backend/header');
		$this->load->view('backend/home');
	}
	// ajax access 
	public function ajax_remove_tag($id)
	{
		$this->load->model('Photomodel');
		$this->Photomodel->remove_tag($id);
	}
	public function ajax_add_tag()
	{
		$tag->photo_id = $this->input->post('photo_id');
		$tag->slug = str_replace(" ", "-", trim($this->input->post('tag')));
		$tag->slug = preg_replace("/[^a-zA-Z0-9-]/", "", $tag->slug);
		$tag->name = str_replace("-", " ", trim($this->input->post('tag')));
		$this->load->model('Photomodel');
		$this->Photomodel->add_tag($tag);
	}
	public function ajax_update_photo()
	{
		$photo->id			= $this->input->post('id');
		$photo->name		= $this->input->post('name');
		$photo->date_taken	= $this->input->post('date');
		$this->load->model('Photomodel');
		$this->Photomodel->update_photo($photo);
	}
	public function ajax_delete_photo()
	{
		$photo->id		= $this->input->post('id');
		$photo->name	= $this->input->post('name');
		$this->load->model('Photomodel');
		$this->Photomodel->update_photo($photo);
	}
	public function delete_tag($tag)
	{
		$this->load->model('Photomodel');
		$this->Photomodel->delete_tag($tag);
	}
	// add single photo from frontend, with file
	public function ajax_add_photo()
	{
		// load jpg meta data reading classes
		include_once("PHP_JPEG_Metadata_Toolkit_1.12/JPEG.php");
		include_once("PHP_JPEG_Metadata_Toolkit_1.12/EXIF.php");
		include_once("PHP_JPEG_Metadata_Toolkit_1.12/XMP.php");

		$filename = $this->input->post('filename');
		$photo_dir = $this->input->post('dir');
		$photo_path = "_photos/".$photo_dir."/1180/".$filename.".jpg";
		
		$jpeg_header = get_jpeg_header_data($photo_path );

		if($jpeg_header != false){
			$xmp = get_XMP_text($jpeg_header);
			$xmpArray = read_XMP_array_from_text($xmp);
			
			$name = substr($this->input->post('filename'),3);
			if(!$name){
				$name = 0;
			} else {
				$name = str_replace('-', ' ',$name);
			}
			$rating = $xmpArray[0]['children'][0]['children'][0]['attributes']['xmp:Rating'];
			if(!$rating){
				$rating = 0;
			}
			$date_taken = $xmpArray[0]['children'][0]['children'][0]['attributes']['xmp:CreateDate'];
			if(!$date_taken){
				$date_taken = 0;
			}
			
			
			$tags = array();
			$pretagged = false; 
			// iterate through array to find tags; grab tags
			foreach($xmpArray[0]['children'][0]['children'][0]['children'] as $entry){
				if($entry['tag'] == 'dc:subject'){
					foreach($entry['children'][0]['children'] as $key => $value){
						$slug = str_replace(" ", "-", trim($value['value']));
						$slug = preg_replace("/[^a-zA-Z0-9-]/", "", $slug);
						$tags[$key] = array('slug'=>$slug,'name'=>$value['value']);
						echo "backend found tag: ".$tags[$key]['name']." \n";
						//	 photo is pretagged
						if($slug == $photo_dir){
							$pretagged = true;
						}
						
					}
					break;
				}
			}	
				// tag all photos not tagged with collection name
			if(!$pretagged){
				$tag['slug'] = preg_replace("/[^a-zA-Z0-9-]/", "", $photo_dir);
				$tag['name'] = str_replace("-", " ", trim($photo_dir));
				array_push($tags,$tag);
				echo "backend added tag: ".$tag['name']." \n ";
			}
			
			$data['photo']->name 			= $name;
			$data['photo']->collection 		= $photo_dir;
			$data['photo']->order 			= $this->input->post('order');
			$data['photo']->filename		= $this->input->post('filename');
			$data['photo']->rating			= $rating;
			$data['photo']->date_taken 		= $date_taken;
			$data['photo']->description		= 'description';
			$data['photo']->location		= 'location';
			$data['photo']->tags			= $tags;
			$this->load->model('Photomodel');
			$this->Photomodel->add_photo($data['photo']);			
		}
	}
	
	/**
	 * Memory usage greater than 50mb for 5000 x 3000 image
	 * Doesn't work :(
	 * 
	 */
	public function adding_photos($new_collection)
	{
		$data['page']->description = 'backend admin';
		$data['page']->pretty_name = 'backend admin';
		$data['page']->type = 'backend';
		
		// define photo directory path
		$photo_path = "_photos/".$new_collection."/";
		$photo_dir = $new_collection;
		$filenames = scandir($photo_dir);
		
		// check & create directories 
		if(!is_dir($photo_dir."/".'320')){
			mkdir($photo_dir."/".'320');
		} if(!is_dir($photo_dir."/".'480')){
			mkdir($photo_dir."/".'480');
		} if(!is_dir($photo_dir."/".'960')){
			mkdir($photo_dir."/".'960');
		} if(!is_dir($photo_dir."/".'1180')){
			mkdir($photo_dir."/".'1180');
		} 

		// load jpg meta data reading classes
		include_once("PHP_JPEG_Metadata_Toolkit_1.12/JPEG.php");
		include_once("PHP_JPEG_Metadata_Toolkit_1.12/EXIF.php");
		include_once("PHP_JPEG_Metadata_Toolkit_1.12/XMP.php");
		// load code igniter image resizing 
		$config['image_library'] = 'GD2';
		$config['maintain_ratio'] = TRUE;
		$this->load->library('image_lib'); 
		
		// iterate over every jpg in directory 
		foreach($filenames as $key => $filename ){
			$info = pathinfo($filename);
			if (strtolower($info['extension'])=="jpg"){
				$config['source_image']	= $photo_path.$filename;
				$config['width']	= 1180;
				$config['new_image'] = $photo_path.'1180/';
				$this->image_lib->initialize($config); 
				if ( ! $this->image_lib->resize()){
					echo $this->image_lib->display_errors('<p>'.$filename." 1180 ", '</p>');
				}	
				$config['source_image']	= $photo_path.'1180/'.$filename;
				$config['width']	= 960;
				$config['new_image'] = $photo_path.'960/';
				$this->image_lib->initialize($config); 
				if ( ! $this->image_lib->resize()){
					echo $this->image_lib->display_errors('<p>'.$filename." 960 ", '</p>');
				}	
				$config['source_image']	= $photo_path.'960/'.$filename;
				$config['width']	= 480;
				$config['new_image'] = $photo_path.'480/';
				$this->image_lib->initialize($config); 
				if ( ! $this->image_lib->resize()){
					echo $this->image_lib->display_errors('<p>'.$filename." 480 ", '</p>');
				}
				$config['source_image']	= $photo_path.'480/'.$filename;
				$config['width']	= 320;
				$config['height']	= 600;
				$config['new_image'] = $photo_path.'320/';
				$this->image_lib->initialize($config); 
				if ( ! $this->image_lib->resize()){
					echo $this->image_lib->display_errors('<p>'.$filename." 320 ", '</p>');
				}						
				
				//  First try to get the rating from the EXIF data, this is where it is stored by Windows Vista
				$exif = get_EXIF_JPEG( $photo_path.$filename );
				$rating = null;
		//					$rating = $exif[0][18246]['Data'][0];
				
				$jpeg_header = get_jpeg_header_data($photo_path.$filename );
				//  If no rating was found in the EXIF data, it may be in the Adobe format xmp section
				if ($rating == null){
					if($jpeg_header != false){
						$xmp = get_XMP_text($jpeg_header);
						$xmpArray = read_XMP_array_from_text($xmp);
			//			print_r($xmpArray);
						$data['photo']->name = $filename;
						$data['photo']->collection = $photo_dir;
						$data['photo']->order = $this->input->post('order');
						$data['photo']->path = $photo_path.$filename;
						$data['photo']->rating = $xmpArray[0]['children'][0]['children'][0]['attributes']['xmp:Rating'];
						$data['photo']->date_taken = $xmpArray[0]['children'][0]['children'][0]['attributes']['xmp:CreateDate'];
						$data['photo']->description = 'description';
					$data['photo']->location = 'location';
						$tags = $xmpArray[0]['children'][0]['children'][0]['children'];
						foreach($tags as $i => $entry){
							if($entry['tag'] == 'dc:subject'){
								echo "tagged: ";
								foreach($entry['children'][0]['children'] as $j => $value){
									$data['photo']->tags[$j] = $value['value']; 
									echo $data['photo']->tags[$j];
								}
								break;
								echo "\n";
							}
						}
						$this->load->model('Photomodel');
						$this->Photomodel->add_photo($data['photo']);
					}
				}
			}
		}
		
		$this->load->view('header', $data);
		$this->load->view('backend', $data);
		$this->load->view('footer', $data);	
	}
}