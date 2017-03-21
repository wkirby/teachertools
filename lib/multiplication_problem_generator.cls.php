<?php

namespace Apsis;

class MultiplicationProblemGenerator extends ProblemGenerator
{
  protected $pairs;

  protected $multiplierDigits;
  protected $multiplicandDigits;

  public function setPairs($pairs)
  {
    $this->pairs = $pairs;
    return $this;
  }

  public function setMultiplierDigits($n)
  {
    $this->multiplierDigits = $n;
    return $this;
  }

  public function setMultiplicandDigits($n)
  {
    $this->multiplicandDigits = $n;
    return $this;
  }

  function generateTemplateVars()
  {
    $templateVars = parent::generateTemplateVars();
    $pairs = $this->pairs[array_rand($this->pairs)];

    return array_merge($templateVars, array(
      'multiplier'    => $this->randomDigits($this->multiplierDigits),
      'multiplicand'  => $this->randomDigits($this->multiplicandDigits),
      
      'parent_singular' => $pairs["parent"]["singular"],
      'parent_plural'   => $pairs["parent"]["plural"],
      'child_singular'  => $pairs["child"]["singular"],
      'child_plural'    => $pairs["child"]["plural"],
    ));
  }
}
