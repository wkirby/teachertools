<?php

namespace Apsis;

use Symfony\Component\Yaml\Yaml;

require_once('vendor/autoload.php');
require_once('lib/worksheet_generator.cls.php');
require_once('lib/problem_generator.cls.php');
require_once('lib/addition_problem_generator.cls.php');

// Matches pattern of "x {{child}} in {{parent}}" or
// "{{parent}} has x {{child}}"
$noun_pairs = array(
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
  array("parent" => "field", "child" => "cows"),
);

$subjects = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/subjects.yml"));
$objects = Yaml::parse(file_get_contents(dirname(__FILE__) . "/config/objects.yml"));

$addition_templates = array(
  "I have {{num_1}} {{object}}. {{subject}} has {{num_2}} {{object}}. How many {{object}} do we have all together?",
  "{{subject}} has {{num_2}} {{object}}. I give {{subject_objective}} {{num_1}} {{object}}. How many does {{subject_subjective}} have now?"
);

$subtraction_templates = array(
  "{{subject}} has {{num_2}} {{object}}. If {{subject_subjective}} gives me {{num_1}} {{object}}, how many {{object}} does {{subject_subjective}} have left?",
  "I have {{num_2}} {{object}}. {{subject}} takes {{num_1}} {{object}}. How many {{object}} do I have left?",
);

// $multiplication_templates = array(
//   "There are {{num_1}} {{object_1}}. There are {{num_2}} {{object_2}} in each {{object_1}}. How many {{object_2}} are there all together?",
//   "I have {{num_1}} {{object_1}}. Each {{object_1}} has {{num_2}} {{object_2}}. How many {{object_2}} are there in total?",
//   "There are {{num_2}} {{object_1}}. There are {{num_1}} {{object_2}} in each {{object_1}}. How many {{object_2}} are there all together?",
//   "I have {{num_2}} {{object_1}}. Each {{object_1}} has {{num_1}} {{object_2}}. How many {{object_2}} are there in total?",
// );

$additionGenerator = new AdditionProblemGenerator($addition_templates);
$subtractionGenerator = new AdditionProblemGenerator($subtraction_templates);

$additionGenerator
  ->setDigits(2, 3)
  ->setObjects($objects)
  ->setSubjects($subjects);

$subtractionGenerator
  ->setDigits(2, 3)
  ->setObjects($objects)
  ->setSubjects($subjects);

$problems = $additionGenerator->generate(5);
$problems = array_merge($subtractionGenerator->generate(5), $problems);
shuffle($problems);

$worksheet_generator = new WorksheetGenerator($problems);
$worksheet_generator->render();
