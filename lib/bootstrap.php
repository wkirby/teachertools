<?php

namespace Apsis;

use Symfony\Component\Yaml\Yaml;

$dir = dirname(__FILE__);
$basedir = dirname($dir);

require_once($basedir . '/vendor/autoload.php');

require_once($basedir . '/lib/worksheet_generator.cls.php');
require_once($basedir . '/lib/problem_generator.cls.php');
require_once($basedir . '/lib/addition_problem_generator.cls.php');
require_once($basedir . '/lib/subtraction_problem_generator.cls.php');
require_once($basedir . '/lib/multiplication_problem_generator.cls.php');

// Fixtures
$subjects = Yaml::parse(file_get_contents($basedir . "/config/subjects.yml"));
$objects = Yaml::parse(file_get_contents($basedir . "/config/objects.yml"));
$pairs = Yaml::parse(file_get_contents($basedir . "/config/noun_pairs.yml"));

// Templates
$addTemplates = Yaml::parse(file_get_contents($basedir . "/config/templates/addition.yml"));
$subTemplates = Yaml::parse(file_get_contents($basedir . "/config/templates/subtraction.yml"));
$mulTemplates = Yaml::parse(file_get_contents($basedir . "/config/templates/multiplication.yml"));
