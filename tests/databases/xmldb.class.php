<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | xmldb.class.php                                                           |
// |                                                                           |
// | Geeklog functions to interact with XML stub database for PHPunit          |
// +---------------------------------------------------------------------------+                                                    |
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Sean Clark       - smclark89 AT gmail DOT com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

class Xmldb {
    
    private $xml;
    
    /**
    * Constructor, requires config.php for paths
    *
    */    
    function xmldb() {
        require_once 'config.php';
    }
    
    /**
    * Retrieves configuration values from XML db
    *
    * @param    string  $db      XML database to retrieved CONF values from, defaults to default.xml
    * @return   array   $CONF   Array of CONF values
    *
    */
    
    function getCONF($db = 'default.xml') {
        $CONF = array();
        $xml = $this->loadDb($db);
        $values = $xml->xpath('/geeklog/gl_conf_values');
        foreach($values as $value) {
            // Some values are not portable, in the future may be easier to use install utility.
            // Meanwhile, use switch statements to overwrite necessary config values now.
            switch((string) $value->name) {
                case 'rdf_file':
                    $CONF[(string) $value->name] = getPath('public').'/backend/geeklog.rss/';
                    break;
                case 'path_html':
                    $CONF[(string) $value->name] = getPath('public').'/';
                    break;
                case 'path_log':
                    $CONF[(string) $value->name] = getPath('root').'/logs/';
                    break;
                case 'path_language':
                    $CONF[(string) $value->name] = getPath('root').'/language/';
                    break;
                case 'backup_path':
                    $CONF[(string) $value->name] = getPath('root').'/backups/';
                    break;
                case 'path_data':
                    $CONF[(string) $value->name] = getPath('root').'/data/';
                    break;
                case 'path_images':
                    $CONF[(string) $value->name] = getPath('public').'/images/';
                    break;
                case 'path_pear':
                    $CONF[(string) $value->name] = getPath('root').'/system/pear/';
                    break;
                case 'path_themes':
                    $CONF[(string) $value->name] = getPath('public').'/layout/';
                    break;
                default:                
                    $CONF[(string) $value->name] = unserialize((string) $value->value);
            }
        }
        return $CONF;
    }
    
    /**
    * Loads XML db using simpleXML_load_file
    *
    * @param    string  $db      XML database to retrieved CONF values from, defaults to default.xml
    * @return   array   $xml    database in simpleXMl form
    *
    */
    function loadDb($db = 'default.xml') {
        $xml = simplexml_load_file(getPath('tests').'/databases/'.$db) or die ('Unable to load XML file '.$db);
        return $xml;
    }
    
}

?>

