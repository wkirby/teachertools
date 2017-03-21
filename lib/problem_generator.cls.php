<?php

namespace Apsis;

abstract class ProblemGenerator
{
    protected $templates;
    protected $pronouns;
    protected $student;
    protected $studentGender;

    public function __construct($templates = array(), $pronouns = array())
    {
        $this->templates = $templates;
        $this->pronouns = $pronouns;
        return $this;
    }

    public function setStudent($student, $studentGender) {
        $this->student = $student;
        $this->studentGender = $studentGender;
        return $this;
    }

    public function generate($numberOfProblems)
    {
        $problems = array();

        for ($i=1; $i <= $numberOfProblems; $i++) {
            $problems[] = $this->renderTemplate($this->randomTemplate(), $this->generateTemplateVars());
        }

        return $problems;
    }

    protected function randomTemplate()
    {
        return $this->templates[array_rand($this->templates)];
    }

    protected function renderTemplate($str, $vars)
    {
        foreach ($vars as $k => $v) {
            $str = str_replace("{{" . $k . "}}", $v, $str);
        }

        return $this->sentenceCase($str);
    }

    protected function generateTemplateVars()
    {
        return array(
          'student'            => $this->student,
          'student_possessive' => "$this->student's",
        );
    }

    protected function sentenceCase($str)
    {
        $str = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $str);
        return ucfirst($str);
    }

    protected function randomDigits($digits)
    {
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }
}
