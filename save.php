<?php

$searchedTerm = $argv[1];
$outputDir = isset($argv[2]) ? $argv[2] : './'.$searchedTerm.'/';


$url = "http://emp3world.ch/r.php?phrase=".urlencode($searchedTerm)."&submit=Search";
echo "\nRequeting ".$url;
$cnt = file_get_contents($url);

preg_match_all('!"([^"]+\.mp3)"!is', $cnt, $matches);
$results = $matches[1];
$nbResults = count($results);
echo "\n".$nbResults." files found";

if( ! file_exists($outputDir))
{
    mkdir($outputDir);
}

foreach($results as $k=>$url)
{
    $cmd = 'wget -qnc '.escapeshellarg('--directory-prefix='.$outputDir).' '.escapeshellarg($url).' > /dev/null';
    echo "\n".($k+1)."/".$nbResults.' - '.$cmd;
    exec($cmd);
}

