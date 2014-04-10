Zookal Magento MyTableOptimization
==================================

A Magento MySQL extension which reorganizes the physical storage of table data and associated index data, to reduce storage space and improve I/O efficiency
 when accessing the table.

Defragmented tables: Random insertions into or deletions from a secondary index can cause the index to become fragmented. Fragmentation means
that the physical ordering of the index pages on the disk is not close to the index ordering of the records on the pages,
or that there are many unused pages in the 64-page blocks that were allocated to the index.

- [http://dev.mysql.com/doc/refman/5.5/en/optimize-table.html](http://dev.mysql.com/doc/refman/5.5/en/optimize-table.html)
- [http://dev.mysql.com/doc/refman/5.5/en/innodb-file-defragmenting.html](http://dev.mysql.com/doc/refman/5.5/en/innodb-file-defragmenting.html)


Good to know
------------

During the optimize operations tables are **locked for write**. So optimizing the `core_url_rewrite` with 493,294 rows takes around 30-60s and during that time a deadlock can occur.

The module runs `ALTER TABLE tbl_name ENGINE=INNODB` for all InnoDB tables and `OPTIMIZE TABLE` for MyISAM tables.

This module is different from the `n98-magerun db:maintain:check-tables` which only does check and repair operations for MyISAM tables. Magento consists mostly of InnoDB tables.

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

![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")


On the command line you will have a nice output for each table and its duration.

```
$ php tableOpt.php run
12 Tables
+ catalog_category_entity innodb 0.3309s
+ catalog_category_entity_datetime innodb 0.0190s
+ catalog_category_entity_text innodb 0.6804s
+ catalog_category_entity_varchar innodb 1.4638s
+ catalog_category_flat_store_1 innodb 0.4938s
+ catalog_category_product innodb 0.5248s
+ catalog_category_product_index innodb 1.4009s
+ catalog_product_entity innodb 1.8653s
+ catalog_product_entity_int innodb 12.3820s
+ catalog_product_entity_text innodb 2.2643s
+ catalog_product_entity_varchar innodb 22.3988s
+ catalogsearch_fulltext myisam 0.0833s
Total duration: 43.9071 seconds
Tables optimized
```

This module cannot be speed up by hhvm.

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
