<?php

namespace Apsis;

use Symfony\Component\HttpFoundation\Request;

require_once('lib/bootstrap.php');

$request = Request::createFromGlobals()->request;

// ==============================================
// Handle Request
// ==============================================

// Request Vars
$problemSets   = $request->get('problem_set');
$student       = $request->get('subject_name');
$studentGender = $request->get('student_gender');

// Bail Early
if ( empty($problemSets) ) {
  header("HTTP/1.0 400 Bad Request");
  exit();
}

// Set defaults
$student = empty($student) ? "the student" : $student;
$studentGender = empty($studentGender) ? "neutral" : $studentGender;

// ==============================================
// Generators
// ==============================================
$additionGenerator = new AdditionProblemGenerator($addTemplates, $pronouns);
$subtractionGenerator = new SubtractionProblemGenerator($subTemplates, $pronouns);
$multiplicationGenerator = new MultiplicationProblemGenerator($mulTemplates, $pronouns);

// Set all data
$additionGenerator
  ->setStudent($student, $studentGender)
  ->setObjects($objects)
  ->setSubjects($subjects);

$subtractionGenerator
  ->setStudent($student, $studentGender)
  ->setObjects($objects)
  ->setSubjects($subjects);

$multiplicationGenerator
  ->setStudent($student, $studentGender)
  ->setPairs($pairs);

// ==============================================
// Generate Sheet
// ==============================================

// Create Problems
$problems = array();

foreach ($problemSets as $set) {
  switch ($set["type"]) {
    case 'addition':
      $generator = $additionGenerator->setAddendDigits(intval($set["oper_1_digits"]))->setAugendDigits(intval($set["oper_2_digits"]));
      break;
    case 'subtraction':
      $generator = $subtractionGenerator->setMinuendDigits(intval($set["oper_1_digits"]))->setSubtrahendDigits(intval($set["oper_2_digits"]));
      break;
    case 'multiplication':
      $generator = $multiplicationGenerator->setMultiplierDigits(intval($set["oper_1_digits"]))->setMultiplicandDigits(intval($set["oper_2_digits"]));
      break;
    default:
      continue 2; // If it's unhandled, then we should continue to the next set
      break;
  }

  $problems = array_merge($problems, $generator->generate(intval($set["num_problems"])));
}

// Randomize if requested
if ($request->get('randomize')) { shuffle($problems); }

// ==============================================
// Send Response
// ==============================================

$worksheet_generator = new WorksheetGenerator($request->get('worksheet_title'), $problems);
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
