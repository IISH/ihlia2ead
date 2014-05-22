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

	$data = str_replace("–", "&#8211;", $data);
	$data = str_replace("—", "&#8212;", $data);
	$data = str_replace("¡", "&#161;", $data);
	$data = str_replace("¿", "&#191;", $data);
	$data = str_replace("“", "&#8220;", $data);
	$data = str_replace("”", "&#8221;", $data);
	$data = str_replace("‘", "&#8216;", $data);
	$data = str_replace("’", "&#8217;", $data);
	$data = str_replace("«", "&#171;", $data);
	$data = str_replace("»", "&#187;", $data);
	$data = str_replace("¢", "&#162;", $data);
	$data = str_replace("©", "&#169;", $data);
	$data = str_replace("÷", "&#247;", $data);
	$data = str_replace(">", "&#62;", $data);
	$data = str_replace("<", "&#60;", $data);
	$data = str_replace("µ", "&#181;", $data);
	$data = str_replace("·", "&#183;", $data);
	$data = str_replace("¶", "&#182;", $data);
	$data = str_replace("±", "&#177;", $data);
	$data = str_replace("€", "&#8364;", $data);
	$data = str_replace("£", "&#163;", $data);
	$data = str_replace("®", "&#174;", $data);
	$data = str_replace("§", "&#167;", $data);
	$data = str_replace("™", "&#153;", $data);
	$data = str_replace("¥", "&#165;", $data);
	$data = str_replace("á", "&#225;", $data);
	$data = str_replace("Á", "&#193;", $data);
	$data = str_replace("à", "&#224;", $data);
	$data = str_replace("À", "&#192;", $data);
	$data = str_replace("â", "&#226;", $data);
	$data = str_replace("Â", "&#194;", $data);
	$data = str_replace("å", "&#229;", $data);
	$data = str_replace("Å", "&#197;", $data);
	$data = str_replace("ã", "&#227;", $data);
	$data = str_replace("Ã", "&#195;", $data);
	$data = str_replace("ä", "&#228;", $data);
	$data = str_replace("Ä", "&#196;", $data);
	$data = str_replace("æ", "&#230;", $data);
	$data = str_replace("Æ", "&#198;", $data);
	$data = str_replace("ç", "&#231;", $data);
	$data = str_replace("Ç", "&#199;", $data);
	$data = str_replace("é", "&#233;", $data);
	$data = str_replace("É", "&#201;", $data);
	$data = str_replace("è", "&#232;", $data);
	$data = str_replace("È", "&#200;", $data);
	$data = str_replace("ê", "&#234;", $data);
	$data = str_replace("Ê", "&#202;", $data);
	$data = str_replace("ë", "&#235;", $data);
	$data = str_replace("Ë", "&#203;", $data);
	$data = str_replace("í", "&#237;", $data);
	$data = str_replace("Í", "&#205;", $data);
	$data = str_replace("ì", "&#236;", $data);
	$data = str_replace("Ì", "&#204;", $data);
	$data = str_replace("î", "&#238;", $data);
	$data = str_replace("Î", "&#206;", $data);
	$data = str_replace("ï", "&#239;", $data);
	$data = str_replace("Ï", "&#207;", $data);
	$data = str_replace("ñ", "&#241;", $data);
	$data = str_replace("Ñ", "&#209;", $data);
	$data = str_replace("ó", "&#243;", $data);
	$data = str_replace("Ó", "&#211;", $data);
	$data = str_replace("ò", "&#242;", $data);
	$data = str_replace("Ò", "&#210;", $data);
	$data = str_replace("ô", "&#244;", $data);
	$data = str_replace("Ô", "&#212;", $data);
	$data = str_replace("ø", "&#248;", $data);
	$data = str_replace("Ø", "&#216;", $data);
	$data = str_replace("õ", "&#245;", $data);
	$data = str_replace("Õ", "&#213;", $data);
	$data = str_replace("ö", "&#246;", $data);
	$data = str_replace("Ö", "&#214;", $data);
	$data = str_replace("ß", "&#223;", $data);
	$data = str_replace("ú", "&#250;", $data);
	$data = str_replace("Ú", "&#218;", $data);
	$data = str_replace("ù", "&#249;", $data);
	$data = str_replace("Ù", "&#217;", $data);
	$data = str_replace("û", "&#251;", $data);
	$data = str_replace("Û", "&#219;", $data);
	$data = str_replace("ü", "&#252;", $data);
	$data = str_replace("Ü", "&#220;", $data);
	$data = str_replace("ÿ", "&#255;", $data);
	$data = str_replace("´", "&#180;", $data);
	$data = str_replace("`", "&#96;", $data);
	$data = str_replace("‹", "&#8249;", $data);
	$data = str_replace("›", "&#8250;", $data);

	return $data;
}
?>