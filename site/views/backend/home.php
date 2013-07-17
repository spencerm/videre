<body>
<div id="container" class="photo_index photo">
<div id="masthead" class="big">
    <h1 id="story-title"><?php  echo $page->pretty_name; ?></h1>
	<h3>add new photo collection</h3>
</div>
<div>
	<?php 
	$this->load->helper('form');
	echo form_open('backend/scan_dir');
	echo form_input('dir', 'input new collection');
	echo form_submit('go', 'add new collection');
	echo form_close();
	?>
</div>
</div><!-- /.end container -->
</body>
</html>