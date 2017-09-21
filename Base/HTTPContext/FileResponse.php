<?php

namespace QMVC\Base\HTTPContext;

require_once(dirname(__DIR__) . '/Helpers.php');

use QMVC\Base\Helpers;

final class FileResponse
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
        $this->hasDownloadLimit = ($limit > 0);
    }

    public function getDownloadLimit()
    {
        return $this->downloadLimit;
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