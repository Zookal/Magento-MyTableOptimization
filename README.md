Zookal Magento MyTableOptimization
=============================

A Magento extension which executes the MySQL command `OPTIMIZE TABLE`  for MyISAM, InnoDB, and ARCHIVE tables.

Reorganizes the physical storage of table data and associated index data, to reduce storage space and improve I/O efficiency when accessing the table.

[http://dev.mysql.com/doc/refman/5.5/en/optimize-table.html](http://dev.mysql.com/doc/refman/5.5/en/optimize-table.html)

Good to know
------------

During the optimize operations tables are **locked for write**. So optimizing the `core_url_rewrite` with 493,294 rows takes around 30-60s.

How to use
----------

You can run it either via command line or via cron job.

```
$ php tableOpt.php run
```

You must the module active in the backend otherwise it won't do anything. Navigate to
System -> Configuration -> Advanced -> System -> MyTableOptimization [Zookal_TableOpt Module].

The following settings can be found there:

- Set module active
- Set the cron time
- Set which tables to include in the optimization process
- Set which tables to exclude during the optimization process. Note that include overrides the exclude option.
- Set if you want to skip empty tables

On the command line you will have a nice output for each table and its duration.

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
