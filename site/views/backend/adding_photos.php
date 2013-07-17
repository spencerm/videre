<body>
<div id="container" class="photo">
<div id="masthead" class="big">
    <h3 id="story-title"><?php  echo $page->pretty_name; ?></h3>
	<h4>adding photo collection <strong id="photo_dir"><?php echo $page->dir ?></strong></h4>
</div>
<div>
	<?php 
	$this->load->helper('form');
	echo form_open('backend/send');
	foreach($page->photos as $photo){
		$photo = str_replace(".jpg", "", $photo);
		$data = array(
			'name'			=> $photo,
			'value'			=> $photo,
			'checked'		=> TRUE,
			'id'			=> "opt_".$photo
			);
			
		echo "\t\t<li class='photo_filename ".$photo."'>";
		echo "<img src='".base_url("_photos/".$page->dir."/320/".$photo.".jpg")."' width='64px' height='64px'/>";
		echo form_checkbox($data);
		echo form_label($photo, $photo);
		echo "</li>\n";
	}
	echo "<a id='btn_add_photos' href='#'>add photos</a>";
	echo form_close();
	?>
</div>
</div><!-- /.end container -->
</body>
</html>