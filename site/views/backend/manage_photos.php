<body>
<div id="container" class="photo backend">
<div id="masthead" class="big">
	<h4>managing photo collection <strong id="photo_dir"><?php echo $page->pretty_name ?></strong></h4>
</div>

<div class="block" id="photos">

    <?php
	$this->load->helper('form');
	$page_tags = array();
	
    foreach($photos as $i => $photo){
		
        $path = "_photos/".$photo->collection."/";
        $photo_path = $path."320/".$photo->filename.".jpg";
        list($width, $height, $type, $attr) = getimagesize($photo_path);
		$tags = $this->Photomodel->get_photo_tags($photo->id);
		
        echo "\t"."<li class='photo'>"."\n";
        echo "\t\t"."<img src='".base_url($photo_path)."' width=\"$width\" height=\"$height\" alt=\"$photo->name\" class='left' />"."\n";
        echo "\t\t"."<ul class='form'>".form_open('backend/')."\n";
        echo "\t\t\t"."<li class='id'>".$photo->id."</li>"."\n";
        echo "\t\t\t"."<li>"."title: ".form_input('name', $photo->name)."</li>"."\n";
        echo "\t\t\t"."<li>"."date: ".form_input('date', $photo->date_taken)."</li>"."\n";
        echo "\t\t\t"."<li>"."<button name='update_photo' type='button' class='update_photo'>update</button>"."</li>"."\n";
		echo "\t\t\t"."<li>"."enter new tag: ".form_input('new_tag','enter new tag')."<button name='add_tag' type='button' class='add_tag'>add</button>"."</li>"."\n";
        echo "\t\t\t"."<li><ul class='floated_list'>"."\n";
        foreach($tags as $i => $tag){
            echo "\t\t\t\t"."<li>".$tag->name.": ".form_checkbox($tag->name,$tag->id,TRUE)."</li>"."\n";
        }
        echo "\t\t\t"."</ul></li>"."\n";
        echo "\t\t\t"."<li>"."<button name='delete_photo' type='button' class='delete_photo'>delete photo</button>"."</li>"."\n";
		echo "\t\t".form_close()."</ul>"."\n";
        echo "\t"."</li>"."\n";
    }
    ?>
    
</div> <!-- /.end photo block -->
</div><!-- /.end container -->
</body>
</html>