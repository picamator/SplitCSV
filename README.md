SplitCSV
========

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cbbbaebf-43ce-4795-8a2c-e5aaf82ef902/mini.png)](https://insight.sensiolabs.com/projects/cbbbaebf-43ce-4795-8a2c-e5aaf82ef902)

SplitCSV helps to split comma separated value file (CSV) into chunks by configurable options:

  * Each file's part contains first row from original file (or several one)
  * Every file's part has name as original but with a prefix

Of course it is not possible to implement all varies of algorithms of splitting. 
Therefore SplitCSV presents AbstractRule and RuleInterface to add user rules.

Split Rules
-----------
There are two split rules that is available from box:

  * Split by number of rows
  * Split by file size 

Usage
-----
```php
<?php
namespace SplitCSV;
use SplitCSV\Rule\FileSize;
use SplitCSV\Rule\NumberRow;

// Autoload
require_once ('./src/autoload.php');

// init
$path               = './tests/data/';
$source_path        = $path.'test-10000-rows-357kb.csv';
$destination_path   = $path.'parts';     

$split  = new File($source_path, $destination_path);

// choose rule "FileSize".
$rule   = new FileSize(array('size' => '100kb'));
// example of other rule
// $rule   = new NumberRow(array('number_row' => 10));

// split file by rule
$result  = $split->splitBy($rule);

echo 'File: "' . $source_path . '" has been successfully split by '
    . $result.' parts. Those files are available at location "' 
    . $destination_path . '"';


```

Area of usage
-------------
There are several fields where better have several files instead of one:

  * Project log files to prevent them growing to gigantic size  
  * Reports before sending them off by email
  * Price list from different stores before import them to someone
  * Prepare data for parallel calculation to make possible spread data between servers or processes 

License
-------
BSD-3-Clause
