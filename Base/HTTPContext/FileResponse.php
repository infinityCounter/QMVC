<?php

namespace QMVC\Base\HTTPContext;

use QMVC\Base\Security\Sanitizers as Sanitizers;
use QMVC\Base\Helpers\Helpers as Helpers;

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

    public function setFile(string $filePath)
    {
        $cleanedPath = Sanitizers::cleanInputStr($filePath);
        if(!file_exists($cleanedPath))
            throw new RuntimeException("File not found at path {$cleanedPath}");
        $this->filePath = $cleanedPath;
    }

    public function setDownloadLimit(float $limit)
    {
        $this->downloadLimit = $limit;
        $this->setIsLimited(($limit > 0));
    }

    private function setIsLimited(boolean $hasLimit)
    {
        $this->hasDownloadLimit = $hasLimit;
    }

    public function getFileSize()
    {
        return Helpers::getRealFileSize($this->filePath);
    }
}