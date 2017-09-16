<?php

namespace QMVC\Base\HTTPContext;

require_once(dirname(__DIR__) . '/Security/Sanitizers.php');

use QMVC\Base\Security\Sanitizers;

final class FileUpload 
{
    private $filePath = null;
    private $fileExtension = null;
    private $fileSize = 0;
    private $fileHash = null;
    private $uploadErrors = [];

    function __construct(string $filePath, string $fileExtension, int $fileSize, array $uploadErrors)
    {
        $this->setFilePath($filePath);
        $this->setFileExtension($fileExtension);
        $this->fileSize = $fileSize;
        $this->uploadErrors = $uploadErrors;
    }

    private function setFilePath(string $filePath)
    {
        $fileHash = sha1_file($filePath);
        if(!$fileHash) 
        {
            array_push($this->uploadErrors, "{$filePath} is not a valid file");
        }
        else
        {
            $this->fileHash = sha1($fileHash);
            $this->filePath = $filePath;
        }
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    private function setFileExtension(string $ext)
    {
        $ext = Sanitizers::stripAllTags($ext);
        $isExtension = preg_match('/\A\.[a-zA-Z0-9]+\z/', $ext);
        if(!$isExtension) array_push($this->uploadErrors, "{$ext} is not a extension");
        else $this->fileExtension = $ext;
    }

    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function getFileHash()
    {
        return $this->fileHash;
    }

    public function getUploadErrors()
    {
        return $this->uploadErrors();
    }
}

?>