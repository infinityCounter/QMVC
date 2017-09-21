<?php

namespace QMVC\Base\Lib;

class TwigSubresourceExtension extends \Twig_Extension
{
    private $resourceRepoFile = null;
    private $resourceList = [];
    private $strictMode = true;

    function __construct(string $resourceRepoPath = null, $strict = true)
    {
        if(!isset($resourceRepoPath)) 
            throw new \InvalidArgumentException("{$resourceRepoPath} cannot be null");
        if(file_exists($resourceRepoPath) && is_dir($resourceRepoPath))
            throw new \InvalidArgumentException("{$resourceRepoPath} cannot be a directory, must be json file");
        if(file_exists($resourceRepoPath))
        {
            $fileContents = file_get_contents($resourceRepoPath);
            if(!Helpers::isJson($fileContents))
                throw new \InvalidArgumentException("{$resourceRepoPath} must be json file");
            $this->resourceRepoFile = $resourceRepoPath;
            $this->resourceList = json_decode($fileContents, true);
        } 
        else 
        {
            if(!mkdir($resourceRepoPath, 0777, true))
                throw new \InvalidArgumentException("{$resourceRepoPath} could not be created");
            $this->resourceRepoFile = $resourceRepoPath;
        }
        $this->strictMode = $strict;
    }

    public function isResourceInList($resource) 
    {
       // return array_key_exists($)
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('resource')
        ];
    }

}

?>