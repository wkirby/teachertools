<?php

namespace Apsis;

class AdditionProblemGenerator extends ProblemGenerator
{
  protected $objects;
  protected $subjects;

  protected $digitsA;
  protected $digitsB;

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

  public function setDigits($a, $b)
  {
    $this->digitsA = $a;
    $this->digitsB = $b;

    return $this;
  }

  function generateTemplateVars()
  {
    $subject = $this->subjects[array_rand($this->subjects)];
    $object = $this->objects[array_rand($this->objects)];;

    return array(
      'num_1'    => $this->randomDigits($this->digitsA),
      'num_2'    => $this->randomDigits($this->digitsB),
      'object'   => $object,

      'subject'            => $subject["subject"],
      'subject_subjective' => $subject["pronouns"]["subjective"],
      'subject_objective'  => $subject["pronouns"]["objective"],
      'subject_possessive' => $subject["pronouns"]["possessive"]
    );
  }
}
