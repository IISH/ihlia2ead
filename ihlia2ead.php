<?php
echo "Start downloading ihlia2ead tool... \r\n\r\n";
file_put_contents("ihlia2ead.tar.gz", fopen('https://bamboo.socialhistoryservices.org/browse/IHLIA2EAD-PRODUCTION/latestSuccessful/artifact/JOB1/1.0/ihlia2ead.tar.gz', 'r'));
echo "Finished downloading ihlia2ead tool... \r\n\r\n";

if (file_exists('./ihlia2ead.tar.gz')) {
	echo "Start extracting ihlia2ead tool... \r\n\r\n";
	$p = new PharData('./ihlia2ead.tar.gz');
	$p->decompress();
	
	$phar = new PharData('./ihlia2ead.tar');
	$phar->extractTo('./');
	echo "Finished extracting ihlia2ead tool... \r\n\r\n";
	
	echo "Successfully downloaded and extracted ihlia2ead tool! \r\nPlease place the 'ihlia.csv' file in the 'source' folder and run execute.php";
}
else {
	echo "No file was downloaded!";
}