<?php

namespace QMVC\Base\Templating;

use QMVC\Base\Security\Sanitizers as Sanitizers;

class View {

    private static $twig;
    private $templatePath;
    private $injectArgs;

    public static function setTwigEnvironment($twig)
    {
        self::$twig = $twig;
    }

    function __construct(string $templatePath = "", array $templateArgs = [])
    {
        $this->setTemplatePath($templatePath);
        $this->setTempalteArgs($templateArgs);
    }

    public function setTemplatePath(string $templatePath)
    {
        $cleanedPath = Sanitizers::cleanInputStr($templatePath);
        $this->templatePath = $cleanedPath;
    }

    public function setTemplateArgs(array $templateArgs)
    {
        $cleanedArgs = array_map(function($val)
        {
            return Sanitizers::cleanInputStr($val, true, false);
        }, $templateArgs);
        $this->templateArgs = $cleanedArgs;
    }

    public function render()
    {
        return self::$twig->render($this->templatePath, $this->templateArgs);
    }
}

?>