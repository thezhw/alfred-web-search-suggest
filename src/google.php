<?php
use Alfred\Workflows\Workflow;

require_once('vendor/joetannenbaum/alfred-workflow/Workflow.php');
require_once('vendor/joetannenbaum/alfred-workflow/Result.php');
require_once('util/request.php');

const ICON = '63F60794-BB56-4415-9372-BAF974C3A7E1.png';

$wf = new Workflow;

$xml = request('http://google.com/complete/search?output=toolbar&q='.urlencode($query), $opt);
$xml = simplexml_load_string(utf8_encode($xml));

// 添加默认查询
$json = array();
foreach ($xml as $sugg) {
    $data = (string) $sugg->suggestion->attributes()->data;
    array_push($json, $data);
}
array_unshift($json, $query);

foreach ($json as $data) {
    $wf->result()
        ->title($data)
        ->subtitle('Search Google for '.$data)
        ->arg($data)
        ->icon(ICON)
        ->autocomplete($data);
}

echo $wf->output();
