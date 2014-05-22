<?php
// SAVE FILE
function saveFile($filename, $filesource) {
	$handle = fopen($filename, "w");
	if (fwrite($handle, $filesource) === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}
	fclose($handle);

	return true;
}

// LOAD FILE
function loadFile($templateFile) {
	$html = '';
	$htmlData = '';
	$temp = file($templateFile);
	foreach($temp as $i => $htmlData) {
		$html .= $htmlData;
	}
	return($html);
}

// do some clean up
// remove triple / double spaces
function clean_data($data) {
	$data = trim($data);

	$data = str_replace("    ", " ", $data);
	$data = str_replace("   ", " ", $data);
	$data = str_replace("  ", " ", $data);

	while ( strpos($data,'  ') !== false ) {
		$data = str_replace('  ', ' ', $data);
	}

	return $data;
}

// convert some characters to correct xml characters
function convert2Xml($data) {
	$data = str_replace("&", "&#38;", $data);

	$data = str_replace("�", "&#8211;", $data);
	$data = str_replace("�", "&#8212;", $data);
	$data = str_replace("�", "&#161;", $data);
	$data = str_replace("�", "&#191;", $data);
	$data = str_replace("�", "&#8220;", $data);
	$data = str_replace("�", "&#8221;", $data);
	$data = str_replace("�", "&#8216;", $data);
	$data = str_replace("�", "&#8217;", $data);
	$data = str_replace("�", "&#171;", $data);
	$data = str_replace("�", "&#187;", $data);
	$data = str_replace("�", "&#162;", $data);
	$data = str_replace("�", "&#169;", $data);
	$data = str_replace("�", "&#247;", $data);
	$data = str_replace(">", "&#62;", $data);
	$data = str_replace("<", "&#60;", $data);
	$data = str_replace("�", "&#181;", $data);
	$data = str_replace("�", "&#183;", $data);
	$data = str_replace("�", "&#182;", $data);
	$data = str_replace("�", "&#177;", $data);
	$data = str_replace("�", "&#8364;", $data);
	$data = str_replace("�", "&#163;", $data);
	$data = str_replace("�", "&#174;", $data);
	$data = str_replace("�", "&#167;", $data);
	$data = str_replace("�", "&#153;", $data);
	$data = str_replace("�", "&#165;", $data);
	$data = str_replace("�", "&#225;", $data);
	$data = str_replace("�", "&#193;", $data);
	$data = str_replace("�", "&#224;", $data);
	$data = str_replace("�", "&#192;", $data);
	$data = str_replace("�", "&#226;", $data);
	$data = str_replace("�", "&#194;", $data);
	$data = str_replace("�", "&#229;", $data);
	$data = str_replace("�", "&#197;", $data);
	$data = str_replace("�", "&#227;", $data);
	$data = str_replace("�", "&#195;", $data);
	$data = str_replace("�", "&#228;", $data);
	$data = str_replace("�", "&#196;", $data);
	$data = str_replace("�", "&#230;", $data);
	$data = str_replace("�", "&#198;", $data);
	$data = str_replace("�", "&#231;", $data);
	$data = str_replace("�", "&#199;", $data);
	$data = str_replace("�", "&#233;", $data);
	$data = str_replace("�", "&#201;", $data);
	$data = str_replace("�", "&#232;", $data);
	$data = str_replace("�", "&#200;", $data);
	$data = str_replace("�", "&#234;", $data);
	$data = str_replace("�", "&#202;", $data);
	$data = str_replace("�", "&#235;", $data);
	$data = str_replace("�", "&#203;", $data);
	$data = str_replace("�", "&#237;", $data);
	$data = str_replace("�", "&#205;", $data);
	$data = str_replace("�", "&#236;", $data);
	$data = str_replace("�", "&#204;", $data);
	$data = str_replace("�", "&#238;", $data);
	$data = str_replace("�", "&#206;", $data);
	$data = str_replace("�", "&#239;", $data);
	$data = str_replace("�", "&#207;", $data);
	$data = str_replace("�", "&#241;", $data);
	$data = str_replace("�", "&#209;", $data);
	$data = str_replace("�", "&#243;", $data);
	$data = str_replace("�", "&#211;", $data);
	$data = str_replace("�", "&#242;", $data);
	$data = str_replace("�", "&#210;", $data);
	$data = str_replace("�", "&#244;", $data);
	$data = str_replace("�", "&#212;", $data);
	$data = str_replace("�", "&#248;", $data);
	$data = str_replace("�", "&#216;", $data);
	$data = str_replace("�", "&#245;", $data);
	$data = str_replace("�", "&#213;", $data);
	$data = str_replace("�", "&#246;", $data);
	$data = str_replace("�", "&#214;", $data);
	$data = str_replace("�", "&#223;", $data);
	$data = str_replace("�", "&#250;", $data);
	$data = str_replace("�", "&#218;", $data);
	$data = str_replace("�", "&#249;", $data);
	$data = str_replace("�", "&#217;", $data);
	$data = str_replace("�", "&#251;", $data);
	$data = str_replace("�", "&#219;", $data);
	$data = str_replace("�", "&#252;", $data);
	$data = str_replace("�", "&#220;", $data);
	$data = str_replace("�", "&#255;", $data);
	$data = str_replace("�", "&#180;", $data);
	$data = str_replace("`", "&#96;", $data);
	$data = str_replace("�", "&#8249;", $data);
	$data = str_replace("�", "&#8250;", $data);

	return $data;
}
?>