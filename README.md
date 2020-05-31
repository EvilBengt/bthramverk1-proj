bthramverk1-proj
================

[![Build Status](https://travis-ci.org/EvilBengt/bthramverk1-proj.svg?branch=master)](https://travis-ci.org/EvilBengt/bthramverk1-proj)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/EvilBengt/bthramverk1-proj/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/EvilBengt/bthramverk1-proj/?branch=master)


About this repo / page
----------------------

### This website

This page is my final project in the course "Webbaserade ramverk och designmönster"
(Web based frameworks and design patterns) on [BTH](https://www.bth.se/) (Blekinge institute of technology).

The source code for the site can be found on [GitHub](https://github.com/EvilBengt/bthramverk1-proj).
The site is built on the [Anax framework](https://github.com/canax) and backed by a MySQL/MariaDB database.

### Who am I?

Anton Johnsson Håkansson, studying Web programming on [BTH](https://www.bth.se/).
Some of my own works and other school projects are available on  [my GitHub](https://github.com/EvilBengt).

### Default accounts

For demonstration purposes, I have added some content and two accounts to the page. The accounts are:

|Email            |Password|
|-----------------|--------|
|alice@example.com|admin   |
|bob@example.com  |admin   |



Checkout and install
--------------------

1. Clone or download from GitHub.
2. Run `make install` in the root folder of the project. (Requires composer to be installed.)
3. Rename the file `/config/database_sample.php` to `/config/database.php`.
4. Enter your own database connection details in the `/config/database.php` file.
5. **EITHER**

   Run `/sql/ddl.sql` to your database (MySQL/MariaDB) to get the needed tables. (schema name is not defined, prepend a `USE` statement to the file or equivalent.)

   **OR**

   Use `/sql/model.mwb` with MySQL Workbench to build the database schema.
