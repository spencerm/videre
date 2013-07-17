    <!-- loads jQuery from Google if available, local copy if not -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url()?>js/libs/jquery-1.7.1.min.js"><\/script>')</script>
    <script defer type="text/javascript" src="<?php echo base_url('site/_js/photo.js')?>"></script>

    <script> // Change UA-XXXXX-X to be your site's ID
    window._gaq = [['_setAccount','UA-11009369-1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
    </script>


    <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->
  
</body>
</html>