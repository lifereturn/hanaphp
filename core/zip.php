<?php

class zip
{
	
	public static function unzip($args){
	
		$sorce = $args->from;
		$dest = $args->to;

		$zip=zip_open($sorce);
		
		while($zip_entry=zip_read($zip))
		{
			$zdir=dirname(zip_entry_name($zip_entry));
			$zname=zip_entry_name($zip_entry);

			if(!zip_entry_open($zip,$zip_entry,"r")){
				return FALSE;
			}
			if(!is_dir($zdir)) mkdirr($zdir,0777){
				return FALSE;
			}

			$zip_fs=zip_entry_filesize($zip_entry);
			if(empty($zip_fs)) continue;

			$zz = zip_entry_read($zip_entry,$zip_fs);

			$z = fopen($zname,"w");
			fwrite($z,$zz);
			fclose($z);
			zip_entry_close($zip_entry);

		}
		zip_close($zip);

	}
	
	
}
?>
