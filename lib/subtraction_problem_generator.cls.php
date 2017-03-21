<?php

namespace Apsis;

class SubtractionProblemGenerator extends AdditionProblemGenerator
{
  protected $minuendDigits;
  protected $subtrahendDigits;

  public function setMinuendDigits($n)
  {
    $this->minuendDigits = $n;
    return $this;
  }

  public function setSubtrahendDigits($n)
  {
    $this->subtrahendDigits = $n;
    return $this;
  }

  function generateTemplateVars()
  {
    $subject = $this->subjects[array_rand($this->subjects)];
    $object = $this->objects[array_rand($this->objects)];;

    return array(
      'minuend'    => $this->randomDigits($this->minuendDigits),
      'subtrahend' => $this->randomDigits($this->subtrahendDigits),
      'object'     => $object,

      'subject'            => $subject["subject"],
      'subject_subjective' => $subject["pronouns"]["subjective"],
      'subject_objective'  => $subject["pronouns"]["objective"],
      'subject_possessive' => $subject["pronouns"]["possessive"]
    );
  }
}
