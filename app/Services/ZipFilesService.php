<?php 

namespace App\Services;

final class ZipFilesService
{
	const PATH_FILES = FCPATH. '../public/files/';
	
    public static function zip(array $files): string 
	{
		if (!file_exists(self::PATH_FILES)) {
			mkdir(self::PATH_FILES);
		}

		$fileName = self::PATH_FILES . date('dmYHmi').".zip";
		
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