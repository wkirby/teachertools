<?php

namespace Apsis;

use \PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\IOFactory;

class WorksheetGenerator
{
  public function __construct(Array $problems)
  {
    $this->problems = $problems;
    $this->phpWord  = new PhpWord();
    $this->section  = $this->phpWord->addSection();

    $this->bodyFontStyle  = 'comic_sans_body';;
    $this->titleFontStyle = 'comic_sans_title';
    $this->nameFontStyle  = 'comic_sans_name';

    $this->phpWord->addFontStyle($this->bodyFontStyle, array('name' => 'Comic Sans MS', 'size' => 14, 'color' => '#000000', 'bold' => false));
    $this->phpWord->addFontStyle($this->nameFontStyle, array('name' => 'Comic Sans MS', 'size' => 16, 'color' => '#000000', 'bold' => false));
    $this->phpWord->addFontStyle($this->titleFontStyle, array('name' => 'Comic Sans MS', 'size' => 16, 'color' => '#000000', 'bold' => true));
  }

  public function render()
  {
    // Format Header
    $this->section->addText("Name: __________         Date: __________", $this->nameFontStyle);
    $this->section->addTextBreak(2);
    $this->section->addText("Page Header", $this->titleFontStyle);
    $this->section->addTextBreak(2);

    // Output Problems
    $i = 1;
    foreach ($this->problems as $problem) {
      $this->section->addText("$i. $problem", $this->bodyFontStyle);
      $this->section->addTextBreak(6);
      $i++;
    }

    // Write File
    $timestamp = time();
    $objWriter = IOFactory::createWriter($this->phpWord, 'RTF');
    $objWriter->save("output/output-$timestamp.rtf");
  }
}
