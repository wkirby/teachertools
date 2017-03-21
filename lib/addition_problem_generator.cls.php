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
    $subject = $this->subjects[array_rand($this->subjects)];
    $object = $this->objects[array_rand($this->objects)];;

    return array(
      'augend' => $this->randomDigits($this->augendDigits),
      'addend' => $this->randomDigits($this->addendDigits),
      'object' => $object,

      'subject'            => $subject["subject"],
      'subject_subjective' => $subject["pronouns"]["subjective"],
      'subject_objective'  => $subject["pronouns"]["objective"],
      'subject_possessive' => $subject["pronouns"]["possessive"]
    );
  }
}
