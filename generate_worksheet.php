<?php

namespace Apsis;

use Symfony\Component\HttpFoundation\Request;

require_once('lib/bootstrap.php');

$request = Request::createFromGlobals();
$problemSets = $request->request->get('problem_set');

// Generators
$additionGenerator = new AdditionProblemGenerator($addTemplates);
$subtractionGenerator = new SubtractionProblemGenerator($subTemplates);
$multiplicationGenerator = new MultiplicationProblemGenerator($mulTemplates);

$additionGenerator->setObjects($objects)->setSubjects($subjects);
$subtractionGenerator->setObjects($objects)->setSubjects($subjects);
$multiplicationGenerator->setPairs($pairs);

$problems = array();

foreach ($problemSets as $set) {
  switch ($set["type"]) {
    case 'addition':
      $generator = $additionGenerator->setAddendDigits($set["oper_1_digits"])->setAugendDigits($set["oper_2_digits"]);
      break;
    case 'subtraction':
      $generator = $subtractionGenerator->setMinuendDigits($set["oper_1_digits"])->setSubtrahendDigits($set["oper_2_digits"]);
      break;
    case 'multiplication':
      $generator = $multiplicationGenerator->setMultiplierDigits($set["oper_1_digits"])->setMultiplicandDigits($set["oper_2_digits"]);
      break;
    default:
      continue 2; // If it's unhandled, then we should continue to the next set
      break;
  }

  $problems = array_merge($problems, $generator->generate($set["num_problems"]));
}

// Randomize if requested
if ($request->request->get('randomize')) { shuffle($problems); }

$worksheet_generator = new WorksheetGenerator($request->request->get('worksheet_title'), $problems);
$worksheet_generator->save();

// Send file to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$worksheet_generator->filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($worksheet_generator->tempfile));
flush();
readfile($worksheet_generator->tempfile);
unlink($worksheet_generator->tempfile); // deletes the temporary file
exit;
