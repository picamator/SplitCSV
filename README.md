SplitCSV
========

Objective
---------
SplitCSV helps to split comma separated value file (CSV) into chunks by configurable options:

  * Each file's part contains first row from original file (or several one)
  * Split avaliable by rows number or maximum file size
  * Every file's part has name as original but with a prefix

Area of usage
-------------
There are several problems where it is useful to have several files instead of one:

  * Project log files to prevent them growing to gigantic size  
  * Reports before sending them off by email
  * Price list from different stores before import them to someone
  * Prepare data for parallel calculation to make possible spread data between servers or processes 