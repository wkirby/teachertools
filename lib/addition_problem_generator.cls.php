<?php

namespace Apsis;

class AdditionProblemGenerator extends ProblemGenerator
{
  protected $objects;
  protected $subjects;

  protected $numOneMin;
  protected $numOneMax;
  protected $numTwoMin;
  protected $numTwoMax;

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

  public function setRanges($a, $b, $c, $d)
  {
    $this->numOneMin = $a;
    $this->numOneMax = $b;
    $this->numTwoMin = $c;
    $this->numTwoMax = $d;

    return $this;
  }

  function generateTemplateVars()
  {
    $subject = $this->subjects[array_rand($this->subjects)];
    $object = $this->objects[array_rand($this->objects)];;

    return array(
      'num_1'    => rand($this->numOneMin, $this->numOneMax),
      'num_2'    => rand($this->numTwoMin, $this->numTwoMax),
      'object'   => $object,

      'subject'            => $subject["subject"],
      'subject_pronoun'    => $subject["pronouns"]["subjective"],
      'subject_object'     => $subject["pronouns"]["objective"],
      'subject_possessive' => $subject["pronouns"]["possessive"]
    );
  }
}
