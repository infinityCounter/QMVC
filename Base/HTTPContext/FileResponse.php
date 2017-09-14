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
    
    function __construct(string $filePath, float $downloadLimit)
    {
        $this->setFile($filePath);
        $this->setDownloadLimit($downloadLimit);
    }

    public function setFilePath(string $filePath)
    {
        $this->filePath = $cleanedPath;
    }

    public function getFilePath()
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

    private function setIsLimited(boolean $hasLimit)
    {
        $this->hasDownloadLimit = $hasLimit;
    }

    public function isLimited()
    {
        return $this->hasDownloadLimited;
    }

    public function getFileSize()
    {
        return Helpers::getRealFileSize($this->filePath);
    }
}