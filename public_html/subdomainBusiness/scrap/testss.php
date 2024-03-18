<?php
$testname = "savings's site test string %$21^%38900%/sd/sw233434/\\ewe" ;
echo '<b>Original String: </b>'.$testname.'<br />' ;
$rawurldecode = rawurldecode($testname) ;

echo '<b>After mysql_real_escape_string: </b>'.mysql_real_escape_string($testname).'<br>' ;

echo '<b>After rawurldecode: </b>'.$rawurldecode.'<br>' ;

echo '<b>After mysql_real_escape_string and rawurldecode: </b>'.mysql_real_escape_string($rawurldecode).'<br>' ;
?>