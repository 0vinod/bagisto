<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

 
class QuestionsSheetImport implements ToCollection, WithHeadingRow
{
    public int $imported = 0;
    public int $skipped = 0;
    public array $errors = [];

    public function __construct(private int $subjectId) {}

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $line = $i + 2; // heading is row 1
            $row  = $row->toArray();

            $question = $this->pick($row, ['question']);
            if ($question === null || $question === '') {
                continue; // blank row
            }

            $options = [
                $this->pick($row, ['option_a']),
                $this->pick($row, ['option_b']),
                $this->pick($row, ['option_c']),
                $this->pick($row, ['option_d']),
            ];

            $hasOptions = count(array_filter(
                $options,
                fn($option) => $option !== null && $option !== ''
            )) > 0;

        if (!$hasOptions) {
            $options = [];
        }

            // if (in_array(null, $options, true) || in_array('', $options, true)) {
            //     $this->errors[] = "Row $line: all 4 options are required.";
            //     continue;
            // }

            $answer = $this->parseAnswer($this->pick($row, ['correct_answer', 'answer']));
            if ($answer === null) {
                $this->errors[] = "Row $line: correct answer must be A, B, C, D (or 1-4).";
                
                logger("Import row $line: Invalid answer", [
                'raw_answer' => $answer,
                'row' => $row,
            ]);

                continue;
            }

            if (Question::where('subject_id', $this->subjectId)->where('question', $question)->exists()) {
                $this->skipped++;
                continue;
            }

            Question::create([
                'subject_id'  => $this->subjectId,
                'topic'       => $this->pick($row, ['theorist_topic', 'topic']),
                'question'    => $question,
                'options'     => $options,
                'answer'      => $answer,
                'explanation' => $this->pick($row, ['key_concept', 'explanation']),
            ]);
            $this->imported++;
        }
    }

    /** Find the first cell whose heading starts with / contains one of the given keys. */
    private function pick(array $row, array $keys): ?string
    {
        foreach ($keys as $key) {
            foreach ($row as $heading => $value) {
                $heading = (string) $heading;
                if ($heading === $key || str_starts_with($heading, $key) || ($key === 'explanation' && str_contains($heading, 'explanation'))) {
                    return $value === null ? null : trim((string) $value);
                }
            }
        }
        return null;
    }


 

    /** "B", "b", "B) Lev Vygotsky" => 1 ; "3" => 2 (1-based in files) ; returns 0-based index. */
    private function parseAnswer(?string $raw): ?int
    {
        if ($raw === null || $raw === '') return null;

        if (preg_match('/^([A-Da-d])(?![A-Za-z])/', $raw, $m)) {
            return ord(strtoupper($m[1])) - ord('A');
        }
        if (ctype_digit($raw) && (int) $raw >= 1 && (int) $raw <= 4) {
            return (int) $raw - 1;
        }
        return null;
    }
}
