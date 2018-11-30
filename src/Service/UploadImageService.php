<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 30.11.2018
 * Time: 1:50
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadImageService
{
    public function upload(UploadedFile $file, string $uploadPath);

    public function delete(string $filePath);

    public function generateUniqueFileName();

}