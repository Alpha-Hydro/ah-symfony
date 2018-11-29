<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 30.11.2018
 * Time: 1:52
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageImpl implements UploadImageService
{
    /**
     * @param UploadedFile $file
     * @param string $uploadPath
     * @return string
     */
    public function upload(UploadedFile $file, string $uploadPath): string
    {
        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
        $file->move(
            $uploadPath,
            $fileName
        );

        return $fileName;
    }


    /**
     * @return string
     */
    public function generateUniqueFileName(): string
    {
        return md5(uniqid());
    }
}