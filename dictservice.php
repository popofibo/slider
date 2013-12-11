<?php

/*
	Copyright (C) 2011 Nitin Pathak (www.popofibo.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once('nusoap/lib/nusoap.php');
$client = new nusoap_client('http://services.aonaware.com/DictService/DictService.asmx?wsdl', 'wsdl');
$var = $_GET['word'];
$err = $client->getError();
if ($err) {
print("Error while calling the client");
}
$param = array('word' => $var);
$result = $client->call('Define', array('parameters' => $param), '', '', false, true);
if ($client->fault) {
print("Client Error");
} else {
$err = $client->getError();
if ($err) {
print("Client 2 Error");
} else {
$index = 0;
$return = '<meanings>';

foreach($result as $key=>$value) {
	foreach($value['Definitions']['Definition'] as $defin) {
		if ($defin['Dictionary']['Id'] == 'gcide') {
			$return = $return . '<meaning>' . $defin['WordDefinition'] . '</meaning>';
		}
	}
}
$return = $return . '</meanings>';

print_r($return);
}
}
?>