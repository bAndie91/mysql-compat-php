# mysql-compat
This collection of functions provides the same prototyped functions as deprecated `mysql_*` ones, but calls `mysqli_*` internally.
So you can migrate your legacy code to php 7 by just rewrite function names from `mysql_*` to `mysql_compat_*`.
