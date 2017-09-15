<?php

namespace QMVC\Base\HTTPContext;

require_once('../Helpers.php');

use QMVC\Base\Helpers;

class FileUpload 
{
    private $filePath;
    private $fileExtension;
    private $fileSize;
    private $fileHash;

    function __construct(string $filePath, string $fileExtension, int $fileSize)
    {
        $this->setFilePath($filePath);
        $this->setFileExtension($fileExtension);
        $this->setFileSize($fileSize);
    }

    private function setFilePath(string $filePath)
    {
        $fileHash = sha1(sha1_file($filePath));
        if(!$fileHash) throw new InvalidArgumentException("{$filePath} is not a valid file");
        $this->fileHash = $fileHash;
        $this->filePath = $filePath;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    private function setFileExtension(string $ext)
    {
        $ext = Helpers::stripAllTags($ext);
        $isExtension = preg_match('/\A\.[a-zA-Z0-9]+\z/', $ext);
        if(!$isExtension) throw new InvalidArgumentException("{$ext} is not a extension");
        $this->fileExtension = $ext;
    }

    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    private function setFileSize(int $fileSize)
    {
        $this->fileSize = $fileSize;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function getFileHash()
    {
        return $this->fileHash;
    }
}

?>