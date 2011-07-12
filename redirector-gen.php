<?
/*


*Very basic* script to convert csv input like:
http://oldomain.com/old-page.php,newpage.com

double check all results first. 
this is only meant to be quick and small.
no error checking etc is done.
no user input - just edit the source code.

 */


function strip_domain($s) {
	global $olddomain; // eh.
	$s = str_replace($olddomain . '/',$olddomain,$s); // could cause bug if you have http://olddomain.com/olddomain/test.htm 
	$s = str_replace('http://www.' . $olddomain,'',$s);
	$s = str_replace('http://' . $olddomain,'',$s);
	return $s;
}
$olddomain = 'oldsite.com'; //no www, no http. eg just example.com

$data = '
	http://oldsite.com/foo-stuff.htm,http://newsite.com/foo/
	http://oldsite.com/foobarrrrr-stuff.htm,http://newsite.com/foobarrr/
	http://oldsite.com/order-page.htm,http://newsite.com/shopping/

	'; // csv. each line should be "oldurl,newurl". 

$data = (explode("\n",trim($data)));

foreach($data as $d) {
	$d = explode(',',trim($d));
	$old = strip_domain( trim($d[0]) );
	$new = trim($d[1]);

	if ($old!='' && $new != '') {
		$output.="\n      " . 'RewriteRule ^' .$old . '$ ' . $new . ' [R=301,L]';
	}

}


echo "<textarea style='width:100%;height:500px'><IfModule mod_rewrite.c>
  RewriteEngine on
  RewriteBase /
	$output

</ifModule>
	</textarea>

	(edit rewritebase / to whatever subfolder your site is in)";
