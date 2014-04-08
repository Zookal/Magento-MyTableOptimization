Zookal Magento MyTableOptimization
=============================

A Magento extension which executes the MySQL command `OPTIMIZE TABLE`  for MyISAM, InnoDB, and ARCHIVE tables.

Reorganizes the physical storage of table data and associated index data, to reduce storage space and improve I/O efficiency when accessing the table.

[http://dev.mysql.com/doc/refman/5.5/en/optimize-table.html](http://dev.mysql.com/doc/refman/5.5/en/optimize-table.html)

Good to know
------------

During the optimize operations tables are **locked for write**. So optimizing the `core_url_rewrite` with 493,294 rows takes around 30-60s.

About
-----

- Extension Key: Zookal_TableOpt
- Version: 1.0.0
- It's unit tested! :-) @todo
- It runs on production!

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------

Copyright (c) Zookal Pty Ltd, Sydney Australia

Author
------

[Cyrill Schumacher](https://github.com/SchumacherFM) - [My pgp public key](http://www.schumacher.fm/cyrill.asc) - [On keybase.io](https://keybase.io/cyrill)

Made in Sydney, Australia :-)
