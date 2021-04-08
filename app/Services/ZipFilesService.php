<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Class ZipFilesService
 * @package App\Services
 */
final class ZipFilesService
{
	const PATH_FILES = FCPATH . '../writable/uploads/';

	/**
	 * @param array $files
	 * @return string
	 */
	public static function zip(array $files): string
	{
		if (!file_exists(self::PATH_FILES)) {
			mkdir(self::PATH_FILES);
		}

		$fileName = self::PATH_FILES . self::generateFilename();

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

	/**
	 * @return string
	 */
	private static function generateFilename(): string
	{
		return md5(date('dmYHmi')) . ".zip";
	}
}
