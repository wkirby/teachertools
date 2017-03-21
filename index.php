<?php

namespace Apsis;

use Symfony\Component\Yaml\Yaml;

require_once('vendor/autoload.php');
require_once('lib/worksheet_generator.cls.php');
require_once('lib/problem_generator.cls.php');
require_once('lib/addition_problem_generator.cls.php');
require_once('lib/subtraction_problem_generator.cls.php');
require_once('lib/multiplication_problem_generator.cls.php');

// Fixtures
$subjects = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/subjects.yml"));
$objects = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/objects.yml"));
$pairs = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/noun_pairs.yml"));

// Templates
$addTemplates = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/templates/addition.yml"));
$subTemplates = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/templates/subtraction.yml"));
$mulTemplates = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/templates/multiplication.yml"));

// Generators
$additionGenerator = new AdditionProblemGenerator($addTemplates);
$subtractionGenerator = new SubtractionProblemGenerator($subTemplates);
$multiplicationGenerator = new MultiplicationProblemGenerator($mulTemplates);

$additionGenerator
  ->setAddendDigits(2)
  ->setAugendDigits(3)
  ->setObjects($objects)
  ->setSubjects($subjects);

$subtractionGenerator
  ->setMinuendDigits(3)
  ->setSubtrahendDigits(2)
  ->setObjects($objects)
  ->setSubjects($subjects);

$multiplicationGenerator
  ->setMultiplicandDigits(3)
  ->setMultiplierDigits(2)
  ->setPairs($pairs);

$problems = $multiplicationGenerator->generate(5);
// $problems = array_merge($subtractionGenerator->generate(5), $problems);
// $problems = array_merge($subtractionGenerator->generate(5), $problems);
shuffle($problems);

$worksheet_generator = new WorksheetGenerator($problems);
$worksheet_generator->render();
