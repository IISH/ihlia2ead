<?php 

include "_include/_misc.inc.php";

echo date("Y-m-d H:i:s") . "\r\n\r\n";

$targetdir = "target/";
// template van 1 element
$c01_template = loadFile("_design/c01.xml");
// template van de overkoepelende 
$ead_template = loadFile("_design/ead.xml");
// bron database
$csvfile = "source/ihlia.csv";

$row = 1;
$row2 = 1;
$last_lcn = "";
$tot_lcn = "";
$tot_c01 = "";
if (($handle = fopen($csvfile, "r")) !== FALSE) {
	// doorloop alle regels/records
	while (($data = fgetcsv($handle, 0, ',', "\"")) !== FALSE) {
		$num = count($data);

		if ( $row == 1 ) {
			// de eerste regel bevat de column namen
			// onthou de positie
			// dan kunnen we later naar de verschillende kolommen verwijzen
			// door naar een naam te verwijzen ipv. naar een cijfer
			$position = array_flip($data);
		} else {
			$lcn = trim($data[$position["LCN"]]);

			// als huidige lcn anders dan vorige lcn nummer
			// dan beginnen we met een nieuwe lcn
			if ( $last_lcn != $lcn ) {
				// we beginnen met een nieuwe lcn

				// als er een vorige lcn was
				// dan moet deze als eerst bewaard worden
				if ( $last_lcn != '' ) {
					// SAVE LAST LCN
					echo "\r\n";
					save_lcn($targetdir, $last_lcn, $tot_lcn, $tot_c01);
				}
				// START NEW LCN
				$tot_lcn = fill_lcn($ead_template, $data, $position);

				// ADD C01
				$tot_c01 = fill_c01($c01_template, $data, $position);
			} else {
				// bestaande lcn
				// voeg extra c01 toe

				// ADD C01
				$tot_c01 .= fill_c01($c01_template, $data, $position);
			}

			$last_lcn = $lcn;
			$row2++;
		}
		$row++;
	}
	// SAVE LAST LCN (die was nog niet afgesloten)
	echo "\r\n";
	save_lcn($targetdir, $last_lcn, $tot_lcn, $tot_c01);

	// close bron file
	fclose($handle);
}

echo "\r\nEinde";

// bewaar file (lcn file, bevat dus 1 ead + 1 of meerdere c01)
function save_lcn($targetdir, $last_lcn, $ead_template, $c01_template) {
	// combine data
	$filesource = str_replace('{C01}', $c01_template, $ead_template);

	// save file
//	saveFile($targetdir . 'ead_' . $last_lcn . ".xml", $filesource);
	saveFile($targetdir . $last_lcn . ".xml", $filesource);
}

// VUL LCN/EAD
function fill_lcn($ead_template, $data, $position) {
	$retval = $ead_template;

	// plaats waardes in template
	$retval = str_replace('{ARCHNR}', convert2Xml($data[$position["LCN"]]), $retval);
	$retval = str_replace('{AR}', convert2Xml($data[$position["AR"]]), $retval);
	$retval = str_replace('{PE}', convert2Xml($data[$position["PE"]]), $retval);
	$retval = str_replace('{OM}', convert2Xml($data[$position["OM"]]), $retval);
	
	$tmp_bio = $data[$position["BIO"]];
	if ( trim($tmp_bio) != '' ) {
		$tmp_bio = convert2Xml($tmp_bio);
		$tmp_bio = str_replace('{BIO}', $tmp_bio, "  <bioghist encodinganalog=\"545\$a\"> <head>Biografie</head>  <p>{BIO}</p> </bioghist> ");
	}
	$retval = str_replace('{BIO}', $tmp_bio, $retval);

	$tmp_in = $data[$position["IN"]];
	if ( trim($tmp_in) != '' ) {
		$tmp_in = convert2Xml($tmp_in);
		$tmp_in = str_replace('{IN}', $tmp_in, "  <scopecontent> <head>Inhoud</head>  <p>{IN}</p> </scopecontent> ");
	}
	$retval = str_replace('{IN}', $tmp_in, $retval);

	// Naam met comma moet ook op een normale manier geschreven worden
	$nameReverse = trim($data[$position["AR"]]);
	$nameReverse_arr = explode(',', $nameReverse);
	if ( count($nameReverse_arr) > 1 ) {
		$nameReverse_arr = array_reverse($nameReverse_arr);
		$nameReverse = implode(' ', $nameReverse_arr);
	}
	// convert speciale characters naar xml
	$nameReverse = convert2Xml($nameReverse);
	$retval = str_replace('{AR_omdraaien}', $nameReverse, $retval);

	return $retval;
}

// VUL C01
function fill_c01($c01_template, $data, $position) {
	$retval = "";

	// DOORLOOP DE 12 MP KOLOMMEN
	// PER KOLOM KOMT ER DUS EEN C01 DEEL
	for ( $i = 1; $i <= 12; $i++ ) {

		// CONTROLEER OF MPx NIET LEEG IS
		$value_mp_field = convert2Xml($data[$position["MP".$i]]);
		if ( $value_mp_field != '' ) {

			// waarde moet altijd eindigen met een punt
			if ( substr($value_mp_field, -1) != '.' ) {
				$value_mp_field .= '.';
			}

			// fix unitdate tags
			$value_mp_field = addUnitDateTag($value_mp_field);

			// voeg nu ook een extra spatie toe, value eindigt dus altijd met een spatie, niet meer trimmen
			if ( substr($value_mp_field, -1) != ' ' ) {
				$value_mp_field .= ' ';
			}

			// pak c01 template
			$tmp = $c01_template;

			// vul de berekende waardes in de template
			$tmp = str_replace('{DO#}', convert2Xml($data[$position["DO"]]), $tmp);
			$tmp = str_replace('{MP#}', $i, $tmp);
			$tmp = str_replace('{value_MP#}', $value_mp_field, $tmp);

			$retval .= $tmp;
		}
	}

	return $retval;
}

// repareer unitdate
// oftewel zorg ervoor dat jaartallen omcirkeld worden door <unitdate>
function addUnitDateTag($value) {
	$retval = $value;

	// zorgt ervoor dat al aangepaste/gevonden jaartallen bij de volgende opdracht niet weer worden aangepast
	$not = '[^>\-]';

	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

	// 'vervang door' waarde
	$replacement = ' <unitdate>${1}-${2}. </unitdate>';

	// zoek naar: XXXX-XXXX (commentaar versimpeld)
	$pattern = '/' . $not . '([1-2][0-9][0-9][0-9])[[:space:]]?\-[[:space:]]?([1-2][0-9][0-9][0-9])/';
	$retval = preg_replace($pattern, $replacement, $retval);

	// zoek naar: XXXX-XX (commentaar versimpeld)
	$pattern = '/' . $not . '([1-2][0-9][0-9][0-9])[[:space:]]?\-[[:space:]]?([0-9][0-9])/';
	$retval = preg_replace($pattern, $replacement, $retval);

	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

	// 'vervang door' waarde
	$replacement = ' <unitdate>${1}. </unitdate>';

	// zoek naar: XXXX/XX/XX (commentaar versimpeld)
	$pattern = '/' . $not . '([1-2][0-9][0-9][0-9]\/[0-9][0-9]\/[0-9][0-9])/i';
	$retval = preg_replace($pattern, $replacement, $retval);

	// zoek naar: XXXX/XX (commentaar versimpeld)
	$pattern = '/' . $not . '([1-2][0-9][0-9][0-9]\/[0-9][0-9])/';
	$retval = preg_replace($pattern, $replacement, $retval);

	// zoek naar: 1XXX (commentaar versimpeld)
	$pattern = '/' . $not . '(1[5-9][0-9][0-9])/';
	$retval = preg_replace($pattern, $replacement, $retval);

	// zoek naar: 2XXX (commentaar versimpeld)
	$pattern = '/' . $not . '(2[0-1][0-9][0-9])/';
	$retval = preg_replace($pattern, $replacement, $retval);

	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

	// check if string ends with </unitdate>.
	$end_part = "</unitdate>.";
	if ( substr($retval, -strlen($end_part)) == $end_part ) {
		// strip last dot
		$retval = substr($retval, 0, strlen($retval)-1) . " ";

		// place dot before the last [space]<unitdate>
		$pos = strrpos($retval, " <unitdate>");
		if ( $pos !== false ) {
			// place dot before last [space]<unitdate>
			$retval = substr($retval, 0, $pos) . "." . substr($retval, -(strlen($retval) - $pos));

			// fix double dot probleem
			$retval = str_replace('.. <unitdate>', '. <unitdate>', $retval);
		}
	}

	// + + + + + + + + + + + + + + + + + + + + + + + + + + + + + +

	if ( $value != $retval ) {
		echo "+" . $value . "+\r\n";
		echo "+" . $retval . "+\r\n";
		echo "\r\n";
	}

	return $retval;
}
?>