<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<title>Spencer McCormick | <?php echo $page->pretty_name; ?></title>
	<!-- meta --> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta name="description" content="<?php echo $page->description; ?>" />
	<meta name="keywords" content="spencer, mccormick, storytelling, story, interactive" />
	<meta name="viewport" content="width=100%;  initial-scale=1; maximum-scale=1; minimum-scale=1;  user-scalable=no;"/>
	<!-- logo & rss --> 
	<link rel="icon" href="" type="image/x-icon" />
	<link rel="alternate" type="application/rss+xml" title="Spencer McCormick RSS Feed" href="" />
	<link rel="alternate" type="application/atom+xml" title="Spencer McCormick Atom Feed" href="" />
	<!-- css --> 
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Acme|Coming+Soon' rel='stylesheet' type='text/css'>
 	<link rel="stylesheet" type="text/css" media="all" href='<?php echo base_url("site/_css/style.css")?>'/>
 	<link rel="stylesheet" type="text/css" media="all" href='<?php echo base_url("site/_css/".$page->type.".css") ?>'/>
	<?php // write bg image if it exists
		$bg = "site/_images/bgs/".$page->name.".jpg";
		if(is_file($bg)) echo "<style type='text/css'> body{background:url(".base_url($bg).") no-repeat right bottom;background-attachment:fixed; background-size:auto;}</style>";
	?> 
	<!-- js --> 
	<?php 
	$js = "site/_js/".$page->type.".js";
	if(is_file($js)){	?>
	<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA3XibwpnmiMXw_bRooiBQORTQuQlc5JxUO8EHxCPGXsKlYL82ghRl1xmDx0Re7sKoBSX8fZalpQtvTA"></script>
	<script type="text/javascript">
		google.load("jquery", "1.4.3");
	</script>
	<script type="text/javascript" src="<?php echo base_url($js);?>"></script>
	<?php } ?> 
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-11009369-1']);
		_gaq.push(['_trackPageview']);
	      
		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<body>