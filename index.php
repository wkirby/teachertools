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
  "I have {{num_2}} {{object}}. {{subject}} has {{num_1}} {{object}}. How many {{object}} do we have all together?",
  "{{subject}} has {{num_2}} {{object}}. I give {{subject_pronoun}} {{num_1}} {{object}}. How many does {{subject_object}} have now?",
  "{{subject}} has {{num_1}} {{object}}. I give {{subject_pronoun}} {{num_2}} {{object}}. How many does {{subject_object}} have now?"
);

$subtraction_templates = array(
  "{{subject}} has {{num_1}} {{object}}. If {{subject}} gives me {{num_2}} {{object}}, how many {{object}} does he have left?",
  "{{subject}} has {{num_2}} {{object}}. If {{subject}} gives me {{num_1}} {{object}}, how many {{object}} does he have left?",
  "I have {{num_1}} {{object}}. {{subject}} takes {{num_2}} {{object}}. How many {{object}} do I have left?",
  "I have {{num_2}} {{object}}. {{subject}} takes {{num_1}} {{object}}. How many {{object}} do I have left?",
);

$multiplication_templates = array(
  "There are {{num_1}} {{object_1}}. There are {{num_2}} {{object_2}} in each {{object_1}}. How many {{object_2}} are there all together?",
  "I have {{num_1}} {{object_1}}. Each {{object_1}} has {{num_2}} {{object_2}}. How many {{object_2}} are there in total?",
  "There are {{num_2}} {{object_1}}. There are {{num_1}} {{object_2}} in each {{object_1}}. How many {{object_2}} are there all together?",
  "I have {{num_2}} {{object_1}}. Each {{object_1}} has {{num_1}} {{object_2}}. How many {{object_2}} are there in total?",
);

$generator = new AdditionProblemGenerator($addition_templates);

$generator
  ->setRanges(1, 100, 1, 999)
  ->setObjects($objects)
  ->setSubjects($subjects);

$problems = $generator->generate(5);

$worksheet_generator = new WorksheetGenerator($problems);
$worksheet_generator->render();
