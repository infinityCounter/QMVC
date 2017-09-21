<?php

namespace QMVC\Base\HTTPContext;

require_once(dirname(__DIR__) . '/Security/Sanitizers.php');

use QMVC\Base\Security\Sanitizers;

final class FileUpload 
{
    private $filePath = null;
    private $fileMimeType = null;
    private $fileSize = 0;
    private $fileHash = null;
    private $uploadErrors = [];

    function __construct(string $filePath, string $fileMimeType, int $fileSize, array $uploadErrors)
    {
        $this->setFilePath($filePath);
        $this->setMimeType($fileMimeType);
        $this->fileSize = $fileSize;
        $this->uploadErrors = $uploadErrors;
    }

    private function setFilePath(string $filePath)
    {
        if(!file_exists($filePath) && is_uploaded_file($filePath)) 
        {
            array_push($this->uploadErrors, "{$filePath} is not a valid file");
        }
        else
        {
            $this->fileHash = hash('sha256', $filePath);
            $this->filePath = $filePath;
        }
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    private function setMimeType(string $mimeType)
    {
        $this->fileMimeType = $mimeType;
    }

    public function getMimeType()
    {
        return $this->fileMimeType;
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