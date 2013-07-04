<?php global $vigilance; ?>
	<div id="footer">
		<a href="http://www.flickr.com/photos/sharontroy/3938831210/in/photostream/">Header image</a> from Flickr user <a href="http://www.flickr.com/photos/sharontroy/">wonderyort</a>.
	</div><!--end footer-->
</div><!--end wrapper-->
<?php wp_footer(); ?>
<?php
	if ($vigilance->statsCode() != '' ) {
		echo $vigilance->statsCode();
	}
?>
</body>
</html>
