<?php

namespace Apsis;

abstract class ProblemGenerator
{
    private $templates;
    abstract public function generateTemplateVars();

    public function __construct(array $templates = array())
    {
        $this->templates = $templates;
        return $this;
    }

    public function generate(int $numberOfProblems)
    {
        $problems = array();

        for ($i=1; $i <= $numberOfProblems; $i++) {
            $problems[] = $this->renderTemplate($this->randomTemplate(), $this->generateTemplateVars());
        }

        return $problems;
    }

    public function randomTemplate()
    {
        return $this->templates[array_rand($this->templates)];
    }

    public function renderTemplate($str, $vars)
    {
        foreach ($vars as $k => $v) {
            $str = str_replace("{{" . $k . "}}", $v, $str);
        }

        return $this->sentenceCase($str);
    }

    public function sentenceCase($str)
    {
        $str = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $str);
        return ucfirst($str);
    }

    public function randomDigits($digits)
    {
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
}
