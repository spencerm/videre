<?php 

/**
  * photo-single view
  * displays a single photo
  * 
  * @author		Spencer McCormick
  * @link		http://spencermccormick.com/photos
  * 
**/ 

// access model and retrive all photo info
$photo 	= $this->photomodel->get_photo($data->id,$data->ref);

?>

<section id="photo_single" class="photo">

<div class="photo_meta">
	<nav><ul class="floated_list">
		<li><a href="<?php echo base_url() ?>">home</a></li>
		<li>&raquo;</li>
		<li><a href='<?php echo base_url("photos/") ?>'>photos</a></li>
		<li>&raquo;</li>
		<li><a id='collection' href='<?php echo base_url("photos/folder/".$photo->collection) ?>'><?php echo str_replace('-', ' ', $photo->collection) ?></a></li>
		<li>&raquo;</li>
		<li><a id='next' title="<?php echo $page->next_photo->filename ?>" href='<?php echo $page->url."/".$page->next_photo->id ?>'>next_photo()</a></li>
		<li>&#124;&#124;</li>
		<li><a id='previous' title="<?php echo $page->previous_photo->filename ?>" href="<?php echo $page->url."/".$page->previous_photo->id ?>">previous()</a></li>
	</ul></nav>
    <p class="right">j/k; left/right arrow keys to navigate</p>
</div>

<article id="photo">
<?php

	$size 		= '1180';
	$path 		= "_photos/".$photo->collection."/";
	$photo_path = $path."1180/".$photo->filename.".jpg";
	list($width, $height, $type, $attr) = getimagesize($photo_path);
	echo "\t\t"."<a href='".$page->url."/".$page->next_photo->id."'><img src='".base_url($photo_path)."' width=\"$width\" height=\"$height\" alt=\"$photo->name\" /></a>"."\n";
?>
</article><!-- /.end photo -->

<div class="photo_meta">
	<nav><ul class="floated_list">
		<?php if($photo->name): ?>
			<li><h1>&#8220;<?php echo str_replace('-', ' ',$photo->name) ?>&#8221;</h1></li>
		<?php endif; ?>
		<li><?php echo date("M d 'y, H:i", strtotime($photo->date_taken)) ;?></li>
		<li><ul class="floated_list" id="photo_tags">
			<li>tags:</li>
			<?php	
				foreach($tags as $i => $tag){
					echo "\t\t\t"."<li><a class='color".$i."' href='".base_url("photos/tag/".$tag->slug)."'>".$tag->name."</a></li>"."\n";
				} 
			?>
		</ul></li>
	<li><a href="#btn_comments" id="comments">comments</a></li>
	</ul></nav>
	
	<div id="license">
		<ps><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/StillImage" rel="dct:type">photos</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="www.spencermccormick.com" property="cc:attributionName" rel="cc:attributionURL">spencer</a> are licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons License</a>. Use Them!</p>
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png"/></a>
	</div>
</div><!-- /.end photo_meta -->
</section>

<section>
<div id="comments">
	<div id="disqus_thread"></div>
	<script type="text/javascript">
        var disqus_shortname	= 'spencerm',
			disqus_identifier	= 'spencerphoto<?php echo $photo->id?>',
			disqus_category_id	= '1280051';
    
        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
</div>
</section><!-- /.end comments -->
    
</body>
</html>