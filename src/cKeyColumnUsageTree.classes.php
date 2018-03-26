<?php

namespace rstoetter\ckeycolumnusagetree;

/**
  *
  * ## description
  *
  * The class cKeyColumnUsageTreeNodeData implements the data part of the nodes in trees of the type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree
  *
  * ## Usage:  
  *
  *  ```php
  *
  * $schema_name = 'give me the name of my database';
  * $table_name = 'give me the name of an existing table in the schema';
  *
  * // open the database
  * $mysqli = new mysqli(
  *                  'the database host',
  *                  'the database account name',
  *                  'the password of the database account',
  *                  $schema_name
  *              );
  *
  *
  * // retrieve the key column usage of the database
  * $obj_ac_key_column_usage = new \rstoetter\libsqlphp\cKEY_COLUMN_USAGE( $schema_name, $mysqli );
  *
  * // build the sorted key column usage tree of the database
  * $obj_key_column_usage_tree = new \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree( $obj_ac_key_column_usage );
  *
  * // search for the node associated with the table $table_name
  * $obj_found = $obj_key_column_usage_tree->SearchByKey( $table_name ); 
  *
  * // $obj_found is an object of type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTreeNode or false
  *
  * if ( $obj_found !== false ) {            
  *      
  *     $obj_data = $obj_found->GetData( );    // get the data part of type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTreeNodeData
  *           
  *      echo "\n the node is associated with the table '{$obj_data->m_table_name}' and the unique key of it is '" . $obj_found->GetKey( ) . "'";
  *          
  *  }
  * 
  *
  *  ```
  *
  *
  * @author Rainer Stötter
  * @copyright 2018 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */




class cKeyColumnUsageTreeNodeData {

    /**
      * The version of the class cKeyColumnUsageTreeNodeData
      *
      * @var string $m_version the version of the class cKeyColumnUsageTreeNodeData
      *
      *
      */
      
    public static $m_version = '1.0.0';
    
    /**
      * The name of the table, which is specified by the other member variables
      *
      * @var string $m_table_name the name of the table managed by the class cKeyColumnUsageTreeNodeData
      *
      *
      */
    
    
    public $m_table_name = '';        
    
    /**
      * The tables referenced from $this->m_table_name 
      *
      * @var array $m_a_referenced_tables an array with the tables $this->m_table_name is referencing. The array consists of strings with the table names
      *
      *
      */
    

    public $m_a_referenced_tables = array( );    // as strings 
    
    /**
      * The table objects referenced from $m_table_name
      *
      * @var array $m_a_referenced_table_objects an array with the tables $m_table_name is referencing. The array consists of objects of type cKeyColumnUsageTreeNode
      *
      *
      */    
    
    public $m_a_referenced_table_objects = array( ); // as objects
    
    /**
      * The tables which are referring to $this->m_table_name 
      *
      * @var array $m_a_referring_tables an array with the tables referring to $this->m_table_name. The array consists of strings with the table names
      *
      *
      */
    
    
    public $m_a_referring_tables = array( );    // as strings 
    
    /**
      * The table objects which are referring to $this->m_table_name 
      *
      * @var array $m_a_referring_table_objects an array with the table objects referring to $this->m_table_name. The array consists of objects of the type cKeyColumnUsageTreeNode
      *
      *
      */
    
    
    public $m_a_referring_table_objects = array( ); // as objects
    
    /**
      *
      * The constructor of the class cKeyColumnUsageTreeNodeData
      *
      * @param string $table_name the name of an existing table
      *
      * @return cKeyColumnUsageTreeNodeData a new instance of cKeyColumnUsageTreeNodeData
      *
      */       
    

    function __construct( string $table_name ){
    
        $this->m_table_name = $table_name;
    
    }   // function __construct( )
    
    
    /**
      *
      * The method GetKey( ) creates an unique key out of the member variables
      *
      * @return string a unique key for the tree
      *
      */       
    

    public function GetKey( ) : string {
            
        // easy done as table names are unique in the database/schema
    
        return $this->m_table_name;
    
    }   // function GetKey( )
    
    /**
      *
      * This method adds the table $referenced_table_name to the tables ( not the table objects )  $this->m_table_name is referring to
      *
      * @param string $table_name the name of a table $m_table_name is referencing
      *
      * @return bool true, if $referencing_table_name was not registered already
      *
      */           
    
    
    public function AddReferredTableName( string $referencing_table_name ) : bool { 
    
        if ( trim( $referencing_table_name ) == '' ) {
            debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
            die( "\n AddReferredTableName() mit leerem Tabellennamen" );
        }
        
        if ( is_null( $referencing_table_name ) ) {
            debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
            die( "\n AddReferredTableName() mit null als Tabellennamen" );
        }
        
    
        if ( ! in_array( $referencing_table_name, $this->m_a_referenced_tables ) ) {
            $this->m_a_referenced_tables[] = $referencing_table_name; 
            return true;
        }
        
        return false;
        
    }   // function AddReferredTableName( )
    
    /**
      *
      * This method adds the table object $obj_node to the table objects, which refer to $this->m_table_name
      *
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $table_name the table object referring to $this->m_table_name
      *
      * @return bool true, if $obj_node was not registered already
      *
      */           
    
    
    public function AddReferringTableObject( \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj_node ) : bool { 

        if ( is_null( $obj_node ) ) {
            debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
            die( "\n AddReferringTableName() mit NULL-Objekt" );
        }
    
        if ( ! in_array( $obj_node->GetData( )->m_table_name, $this->m_a_referring_tables ) ) {
            $this->m_a_referring_tables[] = $obj_node->GetData( )->m_table_name;
            $this->m_a_referring_table_objects[] = $obj_node;
            return true;
        }
        
        return false;
        
    }   // function AddReferringTableObject( )
    
    /**
      *
      * This method returns true, if the table $referring_table_name refers directly $this->m_table_name. There are no other tables referencing $this->m_table_name between $referring_table_name and $this->m_table_name
      *
      * @param string $referring_table_name the table to examine
      *
      * @return bool true, if $referring_table_name references $this->m_table_name directly
      *
      */      
    
    
    public function RefersDirectlyTo( string $referring_table_name ) : bool {
    
        // echo "\n suche $referring_table_name in "; var_dump( $this->m_a_referenced_tables );
    
        return in_array( $referring_table_name, $this->m_a_referenced_tables );
    
    }   // function RefersDirectlyTo( )
    
    /**
      *
      * This method returns true, if the table $referencing_table_name refers directly $this->m_table_name. There are no other tables referencing $m_table_name between $referencing_table_name and $this->m_table_name
      *
      * @param string $referencing_table_name the table to examine
      *
      * @return bool true, if $referencing_table_name references $this->m_table_name directly
      *
      */      
    
    
    public function IsReferredDirectlyBy( string $referencing_table_name ) : bool {
    
        // echo "\n suche $referencing_table_name in "; var_dump( $this->m_a_referenced_tables );
    
        return in_array( $referencing_table_name, $this->m_a_referring_tables );
    
    }   // function IsReferredDirectlyBy( )
    
    /**
      *
      * This method returns true, if the table $this->m_table_name refers directly to any table. 
      *
      * @param bool $ignore_self_references if this parameter is true, then references to $this->m_table_name are ignored. This parameter defaults to false
      *
      * @return bool true, if $this->m_table_name references to any other table directly
      *
      */      
    
    
    
    public function RefersToAnyTable( bool $ignore_self_references = false ) : bool {
    
        if ( ! $ignore_self_references ) {
            return count( $this->m_a_referenced_tables ) > 0;
        }
        
        
        foreach( $this->m_a_referenced_tables as $table_name ) {
        
            if ( $table_name != $this->m_table_name ) {
                return true;
            }
        
        }
        
        return false;
        
        
    
    }   // function RefersToAnyTable( )
    
    /**
      *
      * This method dumps the active node
      *
      * @return string a string describing the active node
      *
      */       
    
    
    public function GetDump( ) : string {
        
        $ret = " {$this->m_table_name} verweist auf folgende Tabellen: ";
        
        $was_here = false;
        foreach( $this->m_a_referenced_tables as $table_name ) {
            if ( $was_here ) $ret .= ',  ';
            $was_here = true;
            
            $ret .= $table_name;
            
        }
        
        $ret .= "\n Auf {$this->m_data->m_table_name} verweisen folgende Tabellen: ";
        
        $was_here = false;
        foreach( $this->m_a_referring_tables as $table_name ) {
            if ( $was_here ) $ret .= ',  ';
            $was_here = true;
            
            $ret .= $table_name;
            
        }
        
        
        return $ret;
        
    }   // function GetDump( )
    
    /**
      *
      * This magical method stringifies the class cKeyColumnUsageTreeNodeData
      *
      * @return string the unique key of the node
      *
      */          
    
    public function __toString( ) : string
    {
        return $this->GetKey( );
    }    

}  // class cKeyColumnUsageTreeNodeData

/**
  *
  * ## description
  *
  * The class cKeyColumnUsageTreeNode implements a node in trees of the type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree
  * The class manages the data part, which can be retrieved by using the method GetData( )
  *
  * ## Usage:  
  *
  *  ```php
  *
  * $schema_name = 'give me the name of my database';
  * $table_name = 'give me the name of an existing table in the schema';
  *
  * // open the database
  * $mysqli = new mysqli(
  *                  'the database host',
  *                  'the database account name',
  *                  'the password of the database account',
  *                  $schema_name
  *              );
  *
  * // retrieve the key column usage of the database
  * $obj_ac_key_column_usage = new \rstoetter\libsqlphp\cKEY_COLUMN_USAGE( $schema_name, $mysqli );
  *
  * // build the sorted key column usage tree of the database
  * $obj_key_column_usage_tree = new \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree( $obj_ac_key_column_usage );
  *
  * // search for the node associated with the table $table_name
  * $obj_found = $obj_key_column_usage_tree->SearchByKey( $table_name ); 
  *
  * // $obj_found is an object of type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTreeNode or false
  *
  * if ( $obj_found !== false ) {            
  *      
  *     $obj_data = $obj_found->GetData( );    // get the data part of type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTreeNodeData
  *           
  *      echo "\n the node is associated with the table '{$obj_data->m_table_name}' and the unique key of it is '" . $obj_found->GetKey( ) . "'";
  *          
  *  }
  * 
  *
  *  ```
  *
  *
  * @author Rainer Stötter
  * @copyright 2018 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */



class cKeyColumnUsageTreeNode extends \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode {

    /**
      * The version of the class cKeyColumnUsageTreeNode
      *
      * @var string $m_version the version of the class cKeyColumnUsageTreeNode
      *
      *
      */
      
    public static $m_version = '1.0.0';



    /**
      *
      * The constructor of the class cKeyColumnUsageTreeNode
      *
      * @param string $table_name the name of an existing table
      * @param string $referred_table_name the name of a table $table_name is refering to. $referred_table_name will be added to the tables $table_name is referring to. The parameter will be ignored if the parameter is an empty string. The parameter defaults to an empty string. 
      *
      * @return cKeyColumnUsageTreeNode a new instance of cKeyColumnUsageTreeNode
      *
      */       


    function __construct( string $table_name, string $referred_table_name = '' ){
    
            $this->m_table_name = $table_name;
            
            $obj_data = new cKeyColumnUsageTreeNodeData( $table_name );
            
            if ( trim( $referred_table_name ) != '' ) {
                $obj_data->AddReferredTableName( $referred_table_name );
            }
            
            parent::__construct( $obj_data->GetKey( ), $obj_data );
    
    }   // function __construct( )
    
    /**
      *
      * This method dumps the active node
      *
      * @return string a string describing the active node
      *
      */       
    
    
    public function GetDump( ) : string {
        
        return $this->m_data->GetDump( ); 
        
    }   // function GetDump( )
    
    /**
      *
      * This magical method stringifies the class cKeyColumnUsageTreeNode
      *
      * @return string the unique key of the node
      *
      */          
    
    public function __toString( ) : string
    {
        return $this->GetKey( );
    }    
    

}  // class cKeyColumnUsageTreeNode 


/**
  *
  * ## description
  *
  * The class cKeyColumnUsageTree is the main class of the repository rstoetter/ckeycolumnusagetree-php.
  *
  * The class represents a sorted collection of the key column usage of a mysql database. The main purpose of the class
  * cKeyColumnUsageTree is to determine the dependencies of the tables among each other: The class cKeyColumnUsageTree is able
  * to find dependency paths of more than two tables, when another tables are involved. Dependencies which include self referencing 
  * tables are considered, too.
  *
  * The class \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree implements a sorted tree of the key column usage in the databse. The
  * nodes are objects of the type \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTreeNode. The nodes contain a data object of type
  * \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTreeNodeData. The data part can be retrieved from the node with its GetData() method 
  *
  * Only mysql databases are supported at the moment
  *
  * ## Usage:  
  *
  *  ```php
  *
  * $schema_name = 'give me the name of my database';
  * $table_name = 'give me the name of an existing table in the schema';
  *
  * // open the database
  * $mysqli = new mysqli(
  *                  'the database host',
  *                  'the database account name',
  *                  'the password of the database account',
  *                  $schema_name
  *              );
  *
  *
  * // retrieve the key column usage of the database
  * $obj_ac_key_column_usage = new \rstoetter\libsqlphp\cKEY_COLUMN_USAGE( $schema_name, $mysqli );
  *
  * // build the sorted tree
  * $obj_key_column_usage_tree = new \rstoetter\ckeycolumnusagetree\cKeyColumnUsageTree( $obj_ac_key_column_usage );
  *
  * // retrieve an item from the tree
  * $obj_found = $obj_key_column_usage_tree->SearchByKey( $table_name ); 
  *
  * // print the table name of the found item
  * if  ( $obj_found !== false ) {
  *    echo "\n The node is associated with the table " . $obj_found->GetData( )->m_table_name;
  * }
  *
  *
  *  ```
  *
  *
  * @author Rainer Stötter
  * @copyright 2018 Rainer Stötter
  * @license MIT
  * @version =1.0
  *
  */

class cKeyColumnUsageTree extends \rstoetter\cbalancedbinarytree\cBalancedBinaryTree {

    /**
      * The version of the class cKeyColumnUsageTree
      *
      * @var string $m_version the version of the class cKeyColumnUsageTree
      *
      *
      */
      
    public static $m_version = '1.0.0';

    /**
      * An object of the type \rstoetter\libsqlphp\cKEY_COLUMN_USAGE
      *
      * @var \rstoetter\libsqlphp\cKEY_COLUMN_USAGE the key columns found in the database
      *
      *
      */


    protected $m_obj_ac_key_column_usage = null;

    /**
     * Insert a new item into the tree
     * 
     * @param \rstoetter\libsqlphp\cKEY_COLUMN_USAGE_Entry $obj the new item with key column data where we take the data from we need
     *
     */
	public function InsertRelation( \rstoetter\libsqlphp\cKEY_COLUMN_USAGE_Entry $obj ) {

        if ( is_null( $obj->m_TABLE_NAME ) ) {
            die( "\n cKEY_COLUMN_USAGE_Entry mit is_null( m_TABLE_NAME ) " );
        }
	
        $obj_found = $this->SearchByKey( $obj->m_TABLE_NAME );
        if ( $obj_found === false ) {            
        
            // if the referencing table does not exist, then insert it in the tree
        
            $obj_new = new cKeyColumnUsageTreeNode( $obj->m_TABLE_NAME );
            
            if ( ! is_null( $obj->m_REFERENCED_TABLE_NAME ) ) {
                $obj_new->GetData( )->AddReferredTableName( $obj->m_REFERENCED_TABLE_NAME );
            }
            
            $this->InsertNode( $obj_new );
            
		} else {
		
            // if the referencing table does exist, then update its references
		
            if ( ! is_null( $obj->m_REFERENCED_TABLE_NAME ) ) {
                $obj_found->GetData( )->AddReferredTableName( $obj->m_REFERENCED_TABLE_NAME );
            }
		}
		
		// if the target table does not exist, then insert it in the tree
		
		if ( ! is_null( $obj->m_REFERENCED_TABLE_NAME ) ) {
		
            $obj_ref = $this->SearchByKey( $obj->m_REFERENCED_TABLE_NAME );
            if ( $obj_ref === false ) {            
                $obj_new = new cKeyColumnUsageTreeNode( $obj->m_REFERENCED_TABLE_NAME );
                $this->InsertNode( $obj_new );
            }
		}
		
	}  // function InsertRelation( )
	
    /**
      *
      * The constructor of the class cKeyColumnUsageTree
      *
      * @param \rstoetter\libsqlphp\cKEY_COLUMN_USAGE $obj_ac_key_column_usage the key column usage of the database
      *
      * @return cKeyColumnUsageTree a new instance of cKeyColumnUsageTree
      *
      */       
	
	

    function __construct( \rstoetter\libsqlphp\cKEY_COLUMN_USAGE $obj_ac_key_column_usage ){    // cKeyColumnUsageTree
    
        $this->m_obj_ac_key_column_usage = $obj_ac_key_column_usage;
        
        foreach( $this->m_obj_ac_key_column_usage->m_a_entries as $obj ) {
            // echo "\n adding table " . $obj->m_TABLE_NAME;
            $this->InsertRelation( $obj );
        }
        
        $this->RebalanceTree( );
        
        $this->AddObjectAdresses( );
        $this->AddAllReferringTables( );
    
    }   // function __construct( )
    
    
    /**
      *
      * Returns true, if the table with the name $referrer refers directly ( without other tables between ) to the table with the name
      * $referenced_table_name
      *
      * @param string $referrer the source table which could refer to $referenced_table_name
      * @param string $referenced_table_name the target table which could be referred by $referrer
      *
      * @return bool true, if there is a direct referral from $referrer to $referenced_table_name
      *
      */       
    
    
    public function RefersDirectlyTo( string $referrer, string $referenced_table_name ) : bool {
    
        $obj_found = $this->SearchByKey( $referrer );
        if ( $obj_found !== false ) {            
            return in_array( $referenced_table_name, $obj->GetData( )->m_a_referenced_tables );
        }
        
        return false;
        
    
    }   // function RefersDirectlyTo( )
    
    /**
      *
      * Returns true, if the table with the name $referrer refers directly ( without other tables between ) to the table with the name
      * $referred_table_name
      *
      * @param string $referred_table_name the target table which could be referred by $referrer
      * @param string $referrer the source table which could refer to $referenced_table_name      
      *
      * @return bool true, if there is a direct referral from $referrer to $referred_table_name
      *
      */       
    
    
    public function IsReferredDirectlyBy( string $referred_table_name, string $referrer ) : bool {
    
        $obj_found = $this->SearchByKey( $referrer );
        if ( $obj_found !== false ) {            
            return in_array( $referred_table_name, $obj->GetData( )->m_a_referenced_tables );
        }
        
        return false;
        
    
    }   // function IsReferredDirectlyBy( )
    
    
    /**
      *
      * Scan the tree beginning with $tree and update the array with the with referring tables of all nodes found in the tree
      *
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode|null $tree the tree to traverse
      *
      */       
    
    protected function _AddAllReferringTables( $tree )
    {
    
        if ( is_null( $tree ) ) { return ; }
        
        //
 
        $this->_AddAllReferringTables( $tree->GetLeft( ) ); 
        
        //
        
        // echo "\n adding object addresses for " . $tree->GetData( )->m_table_name ;
        
        $obj_data = $tree->GetData( );  
        
        foreach( $obj_data-> m_a_referenced_tables as $referencing_table_name ){
        
            $obj_found = $this->SearchByKey( $referencing_table_name );
            
            if ( $obj_found === false ) {
                debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) ;
                die( "\n _AddAllReferringTables() could not find '{$referencing_table_name}'" );
            }
            
            $obj_found->GetData( )-> m_a_referring_table_objects[] = $tree;
            $obj_found->GetData( )-> m_a_referring_tables[] = $obj_data->m_table_name;
        }
        
        //
        
        $this->_AddAllReferringTables( $tree->GetRight( ) ); 
        
    }   // function _AddAllReferringTables( )    
    
    /**
      *
      * Scan the whole tree beginning with $tree and update the array with the with referring tables of all nodes found in the tree
      *
      */       

    
    protected function AddAllReferringTables( ) {
    
        $tree = $this->m_root;
    
        if ($tree !== null) {
        
            $this->_AddAllReferringTables( $tree );
 
        } else {
            die( "\n cannot add referring object addresses - tree is null" );
        }
        
        // die( "\n fertig mit object addresses" );
        
    }   // function AddAllReferringTables( )
    
    
    /**
      *
      * Scan the tree beginning with $tree and update the array with the with referenced table objects of all nodes found in the tree
      *
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode|null $tree the tree to traverse
      *
      */       
     
     
    protected function _AddObjectAdresses( $tree )
    {
    
        if ( is_null( $tree ) ) { return ; }
        
        //
 
        $this->_AddObjectAdresses( $tree->GetLeft( ) ); 
        
        //
        
        // echo "\n adding object addresses for " . $tree->GetData( )->m_table_name ;
        
        $obj_data = $tree->GetData( );  
        
        foreach( $obj_data-> m_a_referenced_tables as $referencing_table_name ){
        
            $obj_found = $this->SearchByKey( $referencing_table_name );
            
            if ( $obj_found === false ) {
                debug_print_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ) ;
                die( "\n _AddObjectAdresses() could not find '{$referencing_table_name}'" );
            }
            
            $obj_data-> m_a_referenced_table_objects[] = $obj_found;
            
        }
        
        //
        
        $this->_AddObjectAdresses( $tree->GetRight( ) ); 
        
    }   // function _AddObjectAdresses( )
    

    /**
      *
      * Scan the whole tree and update the array with the with referenced table objects of all nodes found in the tree
      *
      */       
    
    
    protected function AddObjectAdresses( ) {
    
        $tree = $this->m_root;
    
        if ($tree !== null) {
        
            $this->_AddObjectAdresses( $tree );
 
        } else {
            die( "\n cannot add object addresses" );
        }
        
        // die( "\n fertig mit object addresses" );
        
    }

    
    
    private function PathIsPart( $a_path_1, $a_path_2 ) : bool {
    
        if ( count( $a_path_1 ) != count( $a_path_2 ) ) {
            return false;
        }
        
        for ( $i = 0; $i < count( $a_path_1 ); $i++ ) {
            if ( $a_path_1[ $i ] != $a_path_2[ $i ])return false;
        
        }
    
        return true;
    
    }   // function PathIsPart( )
    
    private function PathRegistered( array & $a_path_cmp, array & $a_paths ) : bool {
    
        foreach ( $a_paths as $a_path ) {
        
            if ( $this->PathIsPart( $a_path, $a_path_cmp ) ) return true;
        
        }
    
        return false;
        
    }   // function PathRegistered( )
    
    private function IsPathPart( $a_path_part, $a_path_long ) : bool {
    
        // existiert der Teilpfad in $a_path_part im Pfad $a_path_long ?
        
        if ( count( $a_path_part ) > count( $a_path_long ) ) {
            return false;
        }
        
        $found = true;
        
        for ( $i = 0; $i < count( $a_path_long ) - count( $a_path_part ) + 1 ; $i++ ) {
        
            $found = true;
            for ( $j = 0; $j < count( $a_path_part ); $j++ ) {
                if ( $a_path_long[ $i + $j ] != $a_path_part[ $j ]) {
                    $found = false;
                    break;
                }
            }        
        }

        return $found;
    
    }   // function IsPathPart( )
    

    private function PathPartRegistered( array & $a_path_part, array & $a_paths ) : bool {
    
        foreach ( $a_paths as $a_path ) {
        
            if ( $this->IsPathPart( $a_path_part, $a_path ) ) return true;
        
        }
    
        return false;
        
    }   // function PathPartRegistered( )
    

    /**
      *
      * Returns true, if the table with the name $obj->m_table_name is depending on the table with the name $referencing_table_name
      *
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj the table which could depend on $referencing_table_name
      * @param string $referencing_table_name the target table which could be referred by $obj->m_table_name
      * @param int $level the actual recursion level
      * @param array $a_act_path the actual dependency path
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode|null $obj_recursive defaults to null. Is used, when we meet self-referencig tables
      *
      * @return bool true, if the table with the name $obj->m_table_name is depending on the table with the name $referencing_table_name. In this case contains $a_act_path the whole dependency path
      *
      */       
    
    
    protected function _DependsOn( 
            \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj, 
            string $referencing_table_name, 
            int & $level,       
            array & $a_act_path,
            \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj_recursive = null
            ) : bool {
            
        if ( is_null( $obj ) ) {
            die( "\n _DependsOn: Object is null!" );
        }                
        
        // echo "\n _DependsOn with " . $obj->GetData( )->m_table_name . "  -> $referencing_table_name  " ;
    
        if ( ! count( $obj->GetData( )->m_a_referenced_tables )  ) {
            
            if ( $referencing_table_name == $obj->GetData( )->m_table_name ) {                
                return true;
            }
            array_pop( $a_act_path );
            return false;
        }
        
            
        if ( $level == 0 ) {
            $a_act_path[] = $obj->GetData( )->m_table_name;
        }
        

        foreach(  $obj->GetData( )->m_a_referenced_table_objects as $obj_referrer ) {
            
            $a_act_path[] = $obj_referrer->GetData( )->m_table_name;
            
            if ( $obj_referrer->GetData( )->m_table_name == $obj->GetData( )->m_table_name ) {   // recursive table
                if ( $obj_recursive != $obj_referrer ) {
                    // Pfad zur rekursiven Tabelle
                    
                    $obj_recursive = $obj_referrer;                    
                    
                    if (  $this->_DependsOn( 
                            $obj_referrer, 
                            $referencing_table_name,
                            $level,                    
                            $a_act_path,
                            $obj_recursive
                            ) ) {
                            
                        return true;
                    }
                    
                }
                
                $obj_recursive = null;
                
                continue;                
            }            

            // echo "\n" . $obj->GetData( )->m_a_referenced_tables[ $i ] . " refers to ? " . $referencing_table_name . " level = $level" ;
            
            // echo "\n rufe nun _DependsOn mit " . $obj->GetData( )->m_a_referenced_table_objects[ $i ]->GetData()->m_table_name;
            // echo "\ letztes Objekt war " . $obj->GetData( )->m_table_name;
            
            $level++;
            
            if (  $this->_DependsOn( 
                    $obj_referrer, 
                    $referencing_table_name,
                    $level,                    
                    $a_act_path
                    ) ) {
                    
                return true;
            }

        }
        
        array_pop( $a_act_path );
        
        return false;
    
    
    }   // function _DependsOn( )
    
    /**
      *
      * Returns true, if the table with the name $referrer refers to the table with the name $referred_table_name
      *
      * @param string $referrer the name of the the table which could refer to $referred_table_name
      * @param string $referred_table_name the name of the the table which could be referred by $referrer
      * @param bool $recursive is false by default. If $recursive is true, then not merely a direct relation between the two tables will be checked but all paths examined, whether there is a dependency over more than one table
      *
      * @return bool true, if the table with the name $referrer refers to the table with the name $referred_table_name
      *
      */       
    
    
    public function DependsOn( 
                        string $referrer, 
                        string $referred_table_name, 
                        bool $recursive = false
                        ) : bool {
    
        // wether the table $referrer depends on the table $table_name
        // if $recursive == false, then we check, whether $table_name refers to $table_name directly
        // if $recursive == true, then we check, whether $table_name or refers to $table_name - maybe there are some tables between
        // $referrer and $table_name
        
        // ini_set('xdebug.max_nesting_level', 4096 );
        
        // echo "\n verweist $referred_table_name auf $referrer ?";
        
        $ret = false;
        
        $obj_found = $this->SearchByKey( $referrer );
        
        $level = 0;
        
        if ( $obj_found !== false ) {
        
            if ( ! $recursive ) {
                // $a_path = array( $referrer, $referred_table_name );
                return in_array( $referrer, $obj_found->GetData( )->m_a_referenced_tables );
            } else {                        
                $a_path = array( );
                return $this->_DependsOn( $obj_found, $referred_table_name, $level, $a_path );
            }
        
        }
        
        return $ret;
        
    }   // function DependsOn( )
    
    /**
      *
      * Returns true, if the table with the name $referrer refers to the table with the name $referred_table_name
      *
      * @param string $referrer the name of the the table which could refer to $referred_table_name
      * @param string $referred_table_name the name of the the table which could be referred by $referrer
      * @param bool $recursive is false by default. If $recursive is true, then not merely a direct relation between the two tables will be checked but all paths examined, whether there is a dependency over more than one table
      * @param int $level the recursion level we found the dependency path
      * @param array $a_path the dependency path
      *
      * @return bool true, if the table with the name $referrer refers to the table with the name $referred_table_name. In this case $level and $a_act_path will hold valid data
      *
      */       
    
    
        public function DependsOnExt( 
                    string $referrer, 
                    string $referred_table_name, 
                    bool $recursive = false, 
                    int &$level, 
                    array & $a_path 
                    ) : bool {
    
        // wether the table $referrer depends on the table $table_name
        // if $recursive == false, then we check, whether $table_name refers to $table_name directly
        // if $recursive == true, then we check, whether $referrer refers to $table_name indirectly - maybe there are some tables between
        // $referrer and $table_name
        // $a_paths is an array with arrays as elements, which describe the paths from $referrer to $referred_table_name
        
        // ini_set('xdebug.max_nesting_level', 4096 );
        
        // echo "\n verweist $referred_table_name auf $referrer ?";
        
        $ret = false;
        
        $obj_found = $this->SearchByKey( $referrer );
        
        $level = 0;                
        
        if ( $obj_found !== false ) {
        
            if ( ! $recursive ) {
                $a_path = array( $referrer, $referred_table_name );
                return in_array( $referrer, $obj_found->GetData( )->m_a_referenced_tables );
            } else {        
                $a_path = array( );
                return $this->_DependsOn( $obj_found, $referred_table_name, $level, $a_path );
            }
        
        }
        
        return $ret;
        
    }   // function DependsOnExt( )
    
    /**
      *
      * Collects all dependencies found in the tree starting with $tree from the tables found, which refer to $target_table_name.
      * The search paths can be found in the array $a_dependency_paths
      *
      * @param array $a_dependency_paths an array with all table dependecies found in the searched subtree. The array consists of arrays with table names ( the first table name is the source table name and the last table name is the target table name between source and target table there are aybe other tables)
      * @param string $target_table_name the target table which could be referred by lots of dependency paths
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode|null $tree the subtree to traverse for dependencies
      
      * @param bool $add_table_recursions if true, then self referencing tables will be considered, too
      * @param array $a_path the actual dependency path
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode|null $obj_recursive defaults to null. Is used, when we meet self-referencig tables
      *
      */       
    
    
    protected function _CollectAllDependencyPaths( 
                            array & $a_dependency_paths, 
                            string $target_table_name, 
                            $tree,  
                            bool $add_table_recursions,
                            array $a_path = array( ), 
                            \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj_recursive = null
                            ) {
    
    
        if ( $tree == null ) {                    
            die( "_CollectAllDependencyPaths : tree is null" );
            array_pop( $a_path );
            return;
        }
        
        $a_path[] = $tree->GetData( )->m_table_name;
        
        if ( count( $a_path ) > 1 ) {
            if ( ! count( $tree->GetData( )->m_a_referring_table_objects ) ) {
                $a_path_rev = array_reverse( $a_path ); // wir gingen ja rückwärts vor
                $a_dependency_paths[ ] = $a_path_rev ;                            
                
                return;
            }
        }

        
        foreach( $tree->GetData( )->m_a_referring_table_objects as $obj_referrer ) {
        
            if ( $obj_referrer->GetData( )->m_table_name == $tree->GetData( )->m_table_name ) {   // recursive table
                if ( $add_table_recursions && ( $obj_recursive != $obj_referrer ) ) {
                    // Pfad zur rekursiven Tabelle
                    
                    if ( count( $a_path ) > 1 ) {
                        $a_path_rev = array_reverse( $a_path ); // wir gingen ja rückwärts vor
                        $a_dependency_paths[ ] = $a_path_rev ;                            
                    }
                    
                    $this->_CollectAllDependencyPaths( $a_dependency_paths, $target_table_name, $obj_referrer, $add_table_recursions, $a_path, $obj_referrer  );                              
                    
                }
                
                $obj_recursive = null;
                
                continue;                
            }
        
            // search the left sub-tree
            $this->_CollectAllDependencyPaths( $a_dependency_paths, $target_table_name, $obj_referrer, $add_table_recursions, $a_path  );            
            
        }
        
    
    }   // function _CollectAllDependencyPaths( )
    
    /**
      *
      * Collects all dependencies found in the whole tree from the tables found, which refer to $target_table_name.
      *
      * @param array $a_dependency_paths an array with all table dependecies found in the tree. The array consists of arrays with table names ( the first table name is the source table name and the last table name is the target table name between source and target table there are aybe other tables)
      * @param string $target_table_name the target table which could be referred by lots of dependency paths
      * @param bool $add_table_recursions if true, then self referencing tables will be considered, too. It defaults to true
      *
      */       
    
    
    
    public function CollectAllDependencyPaths( array & $a_dependeny_paths, string $target_table_name, bool $add_table_recursions = true ) {
    
        // search for all dependencies - not only the tables referencing $target_table_name by REFERENCED_COLUMN_NAME but
        // also tables which are dependant from the referencing tables
        // returns an array with elements of type cTableDependency
    
        $a_dependeny_paths = array( );
        
        $obj_found = $this->SearchByKey( $target_table_name );
        
        if ( $obj_found !== false ) {            
            $this->_CollectAllDependencyPaths( $a_dependeny_paths, $target_table_name, $obj_found, $add_table_recursions  );        
        } else {
            die( "\n CollectAllDependencyPaths with unknown target table '$target_table_name'" );
        }
        
    }   // function CollectAllDependencyPaths( )
    
    /**
      *
      * Returns true, if $obj is a table which is referencing itself
      *
      * @param  \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj the node to examine
      * @param bool $add_table_recursions if true, then self referencing tables will be considered, too. It defaults to true
      *
      * @return bool true, if the table represented by $obj is self-referencing
      */       
    
    
    protected function _IsSelfReferencingTable( \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode $obj ) : bool {
    
            return in_array( $obj->GetData( )->m_table_name, $obj->GetData( )->m_a_referenced_tables );
            
    }   // function _IsSelfReferencingTable( )    
    
    /**
      *
      * Returns true, if $obj is a table which is referencing itself
      *
      * @param  string $table_name the name of the table to examine
      *
      * @return bool true, if the table $table_name is self-referencing
      *
      */       
    
    
    
    public function IsSelfReferencingTable( string $table_name ) : bool {
    
        $obj_found = $this->SearchByKey( $table_name );
        
        if ( $obj_found !== false ) {            
            return $this->IsSelfReferencingTable( $obj_found );
        } else {
            die( "\n IsSelfReferencingTable with unknown target table '$table_name'" );
        }
        
    }   // function IsSelfReferencingTable( )    
    
    
    /**
      *
      * Collects the names of all self-referencing tables found in the tree starting with $tree into the array $a_table_names
      *
      * @param array $a_table_names an array with the names of all self-referencing tables found in the subtree  $tree
      * @param \rstoetter\cbalancedbinarytree\cBalancedBinaryTreeNode|null $tree the subtree to traverse for self-referencing tables
      *
      */       
    
    
    protected function _CollectAllSelfReferencingTables( array & $a_table_names, $tree  ) {
    
        if ( is_null( $tree ) ) { return ; }
        
        //
 
        $this->_CollectAllSelfReferencingTables( $a_table_names, $tree->GetLeft( ) ); 
        
        //
        
        if ( $this->_IsSelfReferencingTable( $tree ) ) {
        
            $a_table_names[] = $tree->GetData( )->m_table_name;  
            
        }
        
        //
        
        $this->_CollectAllSelfReferencingTables( $a_table_names, $tree->GetRight( ) );     
        
    }   // function _CollectAllSelfReferencingTables( )  
    
    /**
      *
      * Collects the names of all self-referencing tables found in the tree into the array $a_table_names
      *
      * @param array $a_table_names an array with the names of all self-referencing tables found in the tree
      *
      */       
    
    
    public function CollectAllSelfReferencingTables( array & $a_table_names ) {

        
        $a_table_names = array( );
        
        $this->_CollectAllSelfReferencingTables( $a_table_names, $this->m_root );
    
        
    }   // function CollectAllSelfReferencingTables( )    


}   // class cKeyColumnUsageTree

?>