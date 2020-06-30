<?php

if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

require_once('classes/CMySQL.php');

$sParam = $GLOBALS['MySQL']->escape($_GET['q']); // escaping external data
if (! $sParam) exit;

switch ($_GET['mode']) {
    case 'xml': // using XML file as source of data
        $aValues = $aIndexes = array();
        $sFileData = file_get_contents('data.xml'); // reading file content
        $oXmlParser = xml_parser_create('UTF-8');
        xml_parse_into_struct($oXmlParser, $sFileData, $aValues, $aIndexes);
        xml_parser_free( $oXmlParser );

        $aTagIndexes = $aIndexes['ITEM'];
        if (count($aTagIndexes) <= 0) exit;
        foreach($aTagIndexes as $iTagIndex) {
            $sValue = $aValues[$iTagIndex]['value'];
            if (strpos($sValue, $sParam) !== false) {
                echo $sValue . "\n";
            }
        }
        break;
    case 'sql': // using database as source of data
        $sRequest = "SELECT `country_name` FROM `s85_countries` WHERE `country_name` LIKE '%{$sParam}%' ORDER BY `country_code`";
        $aItemInfo = $GLOBALS['MySQL']->getAll($sRequest);
        foreach ($aItemInfo as $aValues) {
            echo $aValues['country_name'] . "\n";
        }
        break;
}