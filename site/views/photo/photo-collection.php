<?php 
/**
  * photo-collection view
  * displays photo collections with medium photos and descriptive text
  * 
  * @author		Spencer McCormick
  * @link		http://spencermccormick.com/photos
  * 
**/ ?>

<section id="photo_collection" class="photo">

<header id="masthead" class="huge">
	<hgrougp>
	    <h1 id="story-title"><?php echo $page->pretty_name; ?></h1>
	    <h4 id=""><?php  
	    if(isset($page->description) echo $page->description; ?>
		?></h4>
	</hgrougp>
</header>

<?php
	include('photo-basic-nav.php');
?>

<div>
<?php
foreach($page->photos as $i => $photo){
	// format photo info
	$path = "_photos/".$photo->collection."/";
	$photo_path = $path."720/".$photo->filename.".jpg";
	list($width, $height, $type, $attr) = getimagesize($photo_path);
	if(!$photo->name){
		$photo->name = '';
	}
	// key = photo id in the collection
	$key = strlen($i+1) < 2 ? ("0" + $i+1) : $i+1;

	if($page->type == 'folder'){
		echo "\t\t"."<li class='photo block'><a href='/photos/collection/".$photo->collection."'>"."\n";
	} else {	
		echo "\t\t"."<li class='photo block'><a href='/photos/collection/".$photo->collection."/".$photo->id."'>"."\n";
	}
	echo "\t\t\t"."<img src='".base_url($photo_path)."' width=\"$width\" height=\"$height\" alt=\"$photo->name\" />"."\n";
	if($page->type == 'folder'){
		echo "\t\t"."<h2>".$photo->collection."</h2>"."\n";
	} else {	
		echo "\t\t"."<h2>".$photo->name."</h2>"."\n";
	}
	echo "\t\t"."</a></li>"."\n";
}
?>
</div> <!-- /.end photo block -->

<div id="bottom_nav" class="big">
	<nav>
		<h3>--> <a href="http://www.youtube.com/watch?v=hPzNl6NKAG0">you probably shouldn't click here</a> <--</h3>
	</nav>
</div>

</div><!-- /.end container -->
    
</body>
</html>