<?php 
/**
  * basic navigation / bread crumbs for photo app
  * 
  * used in photo-collection, photo-index
  * last updated 4.30.2012
  * 
**/ ?>

<div class="photo_meta">
	<ul class="floated_list"><nav>
		<li><a href="<?php echo base_url() ?>">home</a></li>
		<li>&raquo;</li>
        <li><a href="<?php echo base_url("stories/"); ?>">stories</a></li>
        <li>&raquo;</li>
		<li><a href='<?php echo base_url("photos/") ?>'>photos</a></li>
        <li>&raquo;</li>
	</nav></ul>	
</div>