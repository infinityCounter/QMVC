<?php

namespace QMVC\Base\Templating;

require_once(dirname(__DIR__) . '/AppConfig.php');
require_once(dirname(__DIR__) . '/Security/Sanitizers.php');

use QMVC\Base\AppConfig;
use QMVC\Base\Security\Sanitizers;

class View {

    private static $twig;
    private $templateName;
    private $injectArgs;

    function __construct(string $templateName = "", array $templateArgs = [])
    {
        $this->setTemplate($templateName);
        $this->setTemplateArgs($templateArgs);
    }

    public function setTemplate(string $templateName)
    {
        $cleanedName = filter_var($templateName, FILTER_SANITIZE_STRING);
        $this->templateName = $cleanedName;
    }

    public function setTemplateArgs(array $templateArgs)
    {
        $this->templateArgs = $templateArgs;
    }

    public function render()
    {
        return AppConfig::getTwigEnvironment()->render($this->templateName, $this->templateArgs);
    }
}

?>