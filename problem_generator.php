<?php

require_once('vendor/autoload.php');
require_once('lib/worksheet_generator.cls.php');

define('NUM_PROBLEMS', 8);

// Dolch Site Nouns. Must be something that can be "taken" or "given".
// Must be pluralized, or weird sentences might be constructed.
$sight_words = array(
  "apples",
  "balls",
  "bears",
  "beds",
  "bells",
  "birds",
  "boats",
  "boxes",
  "cars",
  "cats",
  "chairs",
  "chickens",
  "coats",
  "cows",
  "dogs",
  "dolls",
  "ducks",
  "eggs",
  "fish",
  "flowers",
  "games",
  "horses",
  "kittens",
  "letters",
  "nests",
  "pigs",
  "rabbits",
  "rings",
  "seeds",
  "sheep",
  "shoes",
  "sticks",
  "tables",
  "toys",
  "trees",
  "watches"
);

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

$subjects = array(
  array("subj" => "my uncle",   "obj" => "he",  "possessive" => "his", "pronoun" => "him"),
  array("subj" => "my aunt",    "obj" => "she", "possessive" => "her", "pronoun" => "her"),
  array("subj" => "my dad",     "obj" => "he",  "possessive" => "his", "pronoun" => "him"),
  array("subj" => "my mom",     "obj" => "she", "possessive" => "her", "pronoun" => "her"),
  array("subj" => "my brother", "obj" => "he",  "possessive" => "his", "pronoun" => "him"),
  array("subj" => "my sister",  "obj" => "she", "possessive" => "her", "pronoun" => "her"),
  array("subj" => "my friend",  "obj" => "he",  "possessive" => "his", "pronoun" => "him"),
  array("subj" => "my friend",  "obj" => "she", "possessive" => "her", "pronoun" => "her")
);

$addition_templates = array(
  "I have {{num_1}} {{object}}. {{subject}} has {{num_2}} {{object}}. How many {{object}} do we have all together?",
  "I have {{num_2}} {{object}}. {{subject}} has {{num_1}} {{object}}. How many {{object}} do we have all together?",
  "{{subject}} has {{num_2}} {{object}}. I give {{subj_pro}} {{num_1}} {{object}}. How many more does {{subj_obj}} have now?",
  "{{subject}} has {{num_1}} {{object}}. I give {{subj_pro}} {{num_2}} {{object}}. How many more does {{subj_obj}} have now?"
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


$problems = array();

for ($i=1; $i <= NUM_PROBLEMS; $i++) {
  $tpl = $addition_templates[array_rand($addition_templates, 1)];
  $obj_accessor =  array_rand($sight_words, 1);
  $subj_accessor =  array_rand($subjects, 1);
  $subj = $subjects[$subj_accessor];

  $vars = array(
    'num_1' => rand(100, 999),
    'num_2' => rand(1, 99),
    'object' => $sight_words[$obj_accessor],
    'subject' => $subj["subj"],
    'subj_pro' => $subj["pronoun"],
    'subj_obj' => $subj["obj"],
    'subj_pro' => $subj["possessive"],
  );

  $problems[] = "$i. " . template($tpl, $vars);
}

$worksheet_generator = new \Apsis\WorksheetGenerator($problems);
$worksheet_generator->render();

function template($str, $vars)
{
    foreach ($vars as $k => $v) {
        $str = str_replace("{{" . $k . "}}", $v, $str);
    }

    return upperFirstWord($str);
}

function upperFirstWord($str)
{
    $str = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $str);
    return ucfirst($str);
}
