<?php
$dir = new DirectoryIterator(dirname(__FILE__));
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
    	// echo '<pre>';
     //    print_r($fileinfo->getFilename());
     //    echo '</pre>';
    	$filename = $fileinfo->getFilename();
    	if( strtolower(substr($filename, strrpos($filename, '.') + 1)) == 'php'){			
//     		$sfile = file_get_contents($filename); // loads file to string
// $html = new DOMDocument; // is object class DOMDocument
// $html->loadHTML($sfile); // loads html
// $nodelist = $html->getElementsByTagName('a'); // nodes
// foreach ($nodelist as $node) {
//   echo $node->nodeValue, "<br />\n"; }
			$file_handle = fopen($filename, "r");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   // echo file_get_contents($line);
   $html = new DOMDocument;
   $html->loadHTML($line); // loads html
$nodelist = $html->getElementsByTagName('a'); // nodes
foreach ($nodelist as $node) {
  echo $node->nodeValue, "<br />\n"; }

}
fclose($file_handle);
			// $html = file_get_contents($filename);
			// $dom = new DOMDocument;
			// $dom->loadHTML($html);
			// foreach ($dom->getElementsByTagName('a') as $node) {
			//     echo $dom->saveHtml($node), PHP_EOL;
			// }    		

//  			foreach (glob("*.php") as $filename) { 
// 			$file = fopen ($filename, "r");
// 			// echo '<a href=''>$filename</a></br>';
//  				$result = sscanf($file, "<a href='%[^']'>%[^<]</a>", $href, $text);

// var_dump($result, $href, $text);

// 			}
			// if (!$file) {
			//     echo "<p>Unable to open remote file.\n";
			//     exit;
			// }
			// while (!feof ($file)) {
			//     $line = fgets ($file, 1024);			    			   			    
			//     if (preg_match ("@\<title\>(.*)\</title\>@i", $line, $out)) {
			//         $title = $out[1];
			//         echo $title;
			//         break;
			//     }
			// }
			// fclose($file);
    	}
    	        
    }
}
?>