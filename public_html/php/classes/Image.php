<?php
require_once dirname(__FILE__) .'/../../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;


 class Image {
    /* uploads the image to cloud storage (Cloudinary)*/
    public function upload_image($image, $name, $directory) {
		Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dhzn9musm',
                'api_key' => '364195656183668',
                'api_secret' => 'djFdPLL9D2O2lxNxApJNBxVY1iY'
            ],

            'url' => [
                'secure' => true
            ]
        ]);

        $data =  (new UploadApi())->upload(
            $image,
            [
                'folder' => $directory,
                'public_id' => $name,
                'overwrite' => true,
            ],
        );

        return $data;
	}
}