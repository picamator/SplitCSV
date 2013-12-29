<?php
/**
 * =====================================
 *    Example of usage SplitCSV
 * =====================================
 */

// Autoload
require_once ('./src/Autoload.php');

namespace SplitCSV;
use SplitCSV\Rule;

// create File obj
$path               = './tests/data/';
$source_path        = $path.'test-10000-rows-357kb.csv';
$destination_path   = $path.'parts';     

$split  = new File($source_path, $destination_path);

// choose rule
$rule    = new Rule\FileSize(array('size' => '100kb'));

// split file by rule
$result  = $split->splitBy($rule);

echo 'File: "'.$source_path.'" has been successfully splitted by '.$result.' parts. Those files are avalable at location "'.$destination_path.'"';