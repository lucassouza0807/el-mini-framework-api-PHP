<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* home.html.twig */
class __TwigTemplate_5054e0c26f4bdee543dd7ec6659d2e16 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"pt-BR\">

<head>
    <link href=\"assets/output.css\" rel=\"stylesheet\">
</head>

<header class=\"container relative top-[50px] w-[50vw] h-[300px] bg-red-500 h-[55rem] flex flex-row wrap p-[30px]\">
    <div class=\"bg-indigo-500 w-[70px] h-[70px] text-lg text-white font-bold flex items-center justify-right\">
        ";
        // line 10
        echo twig_escape_filter($this->env, ($context["nome"] ?? null), "html", null, true);
        echo "
    </div>
</header>

<body>

</body>

</html>";
    }

    public function getTemplateName()
    {
        return "home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 10,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home.html.twig", "C:\\Users\\lucas\\Desktop\\php\\Sistema-de-rotas-com-php\\views\\home.html.twig");
    }
}
