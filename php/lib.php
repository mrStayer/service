<?
function find($needle, $target, $comment)
{
	for ($i=0, $imax=count($target); $i<$imax; $i++)
	{
		// if ($needle === $target[$i]
	}
}

function printA($array,$comment)
{	
	if ($comment) 
	{
		echo "<h3>$comment</h3>";
	}
	echo "<pre>";	print_r($array);	echo "</pre>";
}
?>