<?php
/**
 * =====================================
 *    Example of usage SplitCSV
 * =====================================
 */

namespace SplitCSV;
use SplitCSV\Rule;

// Autoload
require_once ('./src/Autoload.php');

// create File obj
$path               = './tests/data/';
$source_path        = $path.'test-10000-rows-357kb.csv';
$destination_path   = $path.'parts';     

$split  = new File($source_path, $destination_path);

// choose rule "FileSize".
$rule   = new Rule\FileSize(array('size' => '100kb'));
// example of other rule
// $rule   = new Rule\NumberRow(array('number_row' => 10);

// split file by rule
$result  = $split->splitBy($rule);

echo 'File: "'.$source_path.'" has been successfully splitted by '.$result.' parts. Those files are avalable at location "'.$destination_path.'"';