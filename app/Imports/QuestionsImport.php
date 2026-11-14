<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

 
class QuestionsImport implements WithMultipleSheets
{
    private QuestionsSheetImport $sheet;

    public function __construct(int $subjectId)
    {
        $this->sheet = new QuestionsSheetImport($subjectId);
    }

    public function sheets(): array
    {
        return [0 => $this->sheet];
    }

    public function __get($name)
    {
        return $this->sheet->$name;
    }
}
