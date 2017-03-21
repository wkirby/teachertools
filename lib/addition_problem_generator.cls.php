<?php

namespace Apsis;

class AdditionProblemGenerator extends ProblemGenerator
{
  protected $objects;
  protected $subjects;

  protected $augendDigits;
  protected $addendDigits;

  public function setObjects($objects)
  {
    $this->objects = $objects;
    return $this;
  }

  public function setSubjects($subjects)
  {
    $this->subjects = $subjects;
    return $this;
  }

  public function setAugendDigits($n)
  {
    $this->augendDigits = $n;
    return $this;
  }

  public function setAddendDigits($n)
  {
    $this->addendDigits = $n;
    return $this;
  }

  function generateTemplateVars()
  {
    $templateVars = parent::generateTemplateVars();

    $subject  = $this->subjects[array_rand($this->subjects)];;
    $object   = $this->objects[array_rand($this->objects)];;
    $pronouns = $this->pronouns[$subject["pronouns"]];

    return array_merge($templateVars, array(
      'augend' => $this->randomDigits($this->augendDigits),
      'addend' => $this->randomDigits($this->addendDigits),
      'object'     => $object,

      'subject'            => $subject["subject"],
      'subject_subjective' => $pronouns["subjective"],
      'subject_objective'  => $pronouns["objective"],
      'subject_possessive' => $pronouns["possessive"]
    ));
  }
}
