<?php 

namespace App\Services;

final class ZipFilesService
{
    
    public static function zip(array $files): string 
	{
		$fileName = 'public/assets/files/'.date('dmYHmi').".zip";
        $zip = new \ZipArchive();
        $fileZipped = $zip->open($fileName, \ZIPARCHIVE::CREATE);

        if ($fileZipped) {
			
			foreach ($files['tmp_name'] as $key => $item) {
				$zip->addFromString($files['name'][$key], file_get_contents($item));
			}

			$zip->close();
			
            return $fileName;
		} 
		
		return "";
	}
}