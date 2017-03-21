<?php

namespace Apsis;

class MultiplicationProblemGenerator extends ProblemGenerator
{
  protected $pairs;

  protected $digitsA;
  protected $digitsB;

  public function setPairs($pairs)
  {
    $this->pairs = $pairs;
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
    $pairs = $this->pairs[array_rand($this->pairs)];

    return array(
      'num_1'  => $this->randomDigits($this->digitsA),
      'num_2'  => $this->randomDigits($this->digitsB),
      'parent_singular' => $pairs["parent"]["singular"],
      'parent_plural'   => $pairs["parent"]["plural"],
      'child_singular'  => $pairs["child"]["singular"],
      'child_plural'    => $pairs["child"]["plural"],
    );
  }
}
