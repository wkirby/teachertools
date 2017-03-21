<?php

namespace Apsis;

use \Slug\Slugifier;
use \PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\IOFactory;

class WorksheetGenerator
{
  public function __construct(string $name, Array $problems)
  {
    $this->name = $name;
    $this->problems = $problems;
    $this->phpWord  = new PhpWord();
    $this->section  = $this->phpWord->addSection();
    $this->slugifier = new Slugifier();

    $this->bodyFontStyle  = 'comic_sans_body';;
    $this->titleFontStyle = 'comic_sans_title';
    $this->nameFontStyle  = 'comic_sans_name';

    $this->phpWord->addFontStyle($this->bodyFontStyle, array('name' => 'Comic Sans MS', 'size' => 14, 'color' => '#000000', 'bold' => false));
    $this->phpWord->addFontStyle($this->nameFontStyle, array('name' => 'Comic Sans MS', 'size' => 16, 'color' => '#000000', 'bold' => false));
    $this->phpWord->addFontStyle($this->titleFontStyle, array('name' => 'Comic Sans MS', 'size' => 16, 'color' => '#000000', 'bold' => true));
  }

  public function save()
  {
    // Format Header
    $this->section->addText("Name: __________         Date: __________", $this->nameFontStyle);
    $this->section->addTextBreak(2);
    $this->section->addText($this->name, $this->titleFontStyle);
    $this->section->addTextBreak(2);

    // Output Problems
    $i = 1;
    foreach ($this->problems as $problem) {
      $this->section->addText("$i. $problem", $this->bodyFontStyle);
      $this->section->addTextBreak(6);
      $i++;
    }

    // Write File
    $timestamp = date('Ymdhis', time());
    $filename = $this->slugifier->slugify($this->name);

    $this->filename = "$timestamp-{$filename}.rtf";
    $this->tempfile = tempnam(sys_get_temp_dir(), 'phpword');

    $objWriter = IOFactory::createWriter($this->phpWord, 'RTF');
    $objWriter->save($this->tempfile);
  }
}
