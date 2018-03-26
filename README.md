# the repository ckeycolumnusagetree-php

## description  

The class cKeyColumnUsageTree is the main class of the repository \\rstoetter\\ckeycolumnusagetree-php.

The class cKeyColumnUsageTree represents a sorted collection of the key column usage of a mysql database. The main purpose of the class
cKeyColumnUsageTree is to determine the dependencies of the tables among each other: The class cKeyColumnUsageTree is able
to find dependency paths of more than two tables, when another tables are involved. Dependencies which include self referencing 
tables are considered, too.

Only mysql databases are supported at the moment

## helper classes

There are some helper classes, which are significantly involved in adding functionality to the class cKeyColumnUsageTree:

* The class cKeyColumnUsageTreeNode represents a single node in trees of the type \\rstoetter\\ckeycolumnusagetree\\cKeyColumnUsageTree. The class manages the data part, which can be retrieved by using the method GetData( )

* The class cKeyColumnUsageTreeNodeData implements the data part of the nodes in trees of the type \\rstoetter\\ckeycolumnusagetree\\cKeyColumnUsageTree

You will need PHP 7 or later to use this repository

## usage

An usage example would be:

```php

   $schema_name = 'give me the name of my database';
   $table_name = 'give me the name of an existing table in the schema';
  
   // open the database
   $mysqli = new mysqli(
                    'the database host',
                    'the database account name',
                    'the password of the database account',
                    $schema_name
                );
  
  
   // retrieve the key column usage information from the database
   $obj_ac_key_column_usage = new \rstoetter\libsqlphp\cKEY_COLUMN_USAGE( $schema_name, $mysqli );
  
   // build the sorted tree
   $obj_key_column_usage_tree = new \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree( $obj_ac_key_column_usage );
  
   // search for an item in the tree
   $obj_found = $obj_key_column_usage_tree->SearchByKey( $table_name ); 

   if ( $obj_found !== false ) {
        echo "\n the found node is associated with the table " . $obj_found->GetData( )->m_table_name;
   }


```


## Installation

This project assumes you have composer installed. Simply add:

"require" : {

    "rstoetter/ckeycolumnusagetree-php" : ">=1.0.0"

}

to your composer.json, and then you can simply install with:

composer install

## Namespace

Use the namespace \rstoetter\ckeycolumnusagetree in order to access the classes provided by the repository ckeycolumnusagetree-php

## More information

See the [project wiki of ckeycolumnusagetree-php](https://github.com/rstoetter/ckeycolumnusagetree-php/wiki) for more technical informations.


