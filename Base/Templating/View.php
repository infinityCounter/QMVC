<?php

namespace QMVC\Base\Templating;

use QMVC\Base\Security\Sanitizers as Sanitizers;

class View {

    private static $twig;
    private $templateName;
    private $injectArgs;

    public static function setTwigEnvironment($twig)
    {
        self::$twig = $twig;
    }

    function __construct(string $templateName = "", array $templateArgs = [])
    {
        $this->setTemplate($templateName);
        $this->setTempalteArgs($templateArgs);
    }

    public function setTemplate(string $templateName)
    {
        $cleanedName = filter_var($templateName, FILTER_SANITIZE_STRING);
        $this->templateName = $cleanedName;
    }

    public function setTemplateArgs(array $templateArgs)
    {
        $this->templateArgs = $cleanedArgs;
    }

    public function render()
    {
        return self::$twig->render($this->templateName, $this->templateArgs);
    }
}

?>