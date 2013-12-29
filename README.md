SplitCSV
========

Objective
---------
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

Area of usage
-------------
There are several fields where better have several files instead of one:

  * Project log files to prevent them growing to gigantic size  
  * Reports before sending them off by email
  * Price list from different stores before import them to someone
  * Prepare data for parallel calculation to make possible spread data between servers or processes 