<?php

require_once '../config.php';
require_once getPath('restricted').'/system/lib-mbyte.php';
require_once getPath('tests').'/files/databases/xmldb.class.php';

$_CONF['path_language'] = getPath('restricted').'/language/';

echo '<pre>';

print_r(MBYTE_languageList('other'));

?>
