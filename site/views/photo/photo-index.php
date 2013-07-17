<?php 
/**
  * photo-index view
  * displays the photos in an index view with smaller photos
  * 
  * @author		Spencer McCormick
  * @link		http://spencermccormick.com/photos
  * 
**/ ?>

<section id="photo_index" class="photo">

<header id="masthead" class="big">
    <h1 id="story-title"><?php echo $page->pretty_name; ?></h1>
</header>

<?php
	include('photo-basic-nav.php');
?>

<section>
<?php
foreach($page->photos as $i => $photo){
	// format photo info
	$path = "_photos/".$photo->collection."/";
	$photo_path = $path."320/".$photo->filename.".jpg";
	list($width, $height, $type, $attr) = getimagesize($photo_path);
	if(!$photo->name){
		$photo->name = '';
	}
	// key = photo id # in index
	$key = strlen($i+1) < 2 ? ("0" + $i+1) : $i+1;
	// echo out html
	echo "\t\t"."<div class='photo'><a href='".$page->url."/".$photo->id."'>"."\n";
	echo "\t\t\t"."<img src='".base_url($photo_path)."' width=\"$width\" height=\"$height\" alt=\"$photo->name\" />"."\n";
	echo "\t\t\t"."<p>".$key." ".$photo->name."</p>"."\n";
	echo "\t\t"."</a></div>"."\n";
}
?>
</section> <!-- /.end photo block -->

<div id="bottom_nav" class="big">
	<nav>
		<h3>--> <a href="<?php echo base_url(); ?>">you probably shouldn't click here</a> <--</h3>
	</nav>
</div>

</section><!-- /.end container -->


    
</body>
</html>