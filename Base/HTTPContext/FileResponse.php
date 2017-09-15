<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\AppConfig;
use QMVC\Base\Security\Sanitizers;
use QMVC\Base\Helpers;

class FileResponse
{
    private $filePath;
    private $downloadLimit;
    private $hasDownloadLimit = false;
    
    function __construct(string $filePath, float $downloadLimit = null)
    {
        $this->setFilePath($filePath);
        if(isset($downloadLimit))
            $this->setDownloadLimit($downloadLimit);
        else 
            $this->setDownloadLimit(0);
    }

    public function setFilePath(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getFileName()
    {
        return basename($this->filePath);
    }

    public function setDownloadLimit(float $limit)
    {
        $this->downloadLimit = $limit;
        $this->setIsLimited(($limit > 0));
    }

    public function getDownloadLimit()
    {
        return $this->downloadLimit;
    }

    private function setIsLimited(bool $hasLimit)
    {
        $this->hasDownloadLimit = $hasLimit;
    }

    public function isLimited()
    {
        return $this->hasDownloadLimit;
    }

    public function getFileSize()
    {
        return Helpers::getRealFileSize($this->filePath);
    }
}