<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $filePath = storage_path('seeders'.DIRECTORY_SEPARATOR.'questions.xlsx');

        if (! file_exists($filePath)) {
            dd("File not found: $filePath");
        }

        $spreadsheet = IOFactory::load($filePath);

        $worksheet = $spreadsheet->getActiveSheet();

        $dataToInsert = $worksheet->toArray();

        array_shift($dataToInsert);

        foreach ($dataToInsert as $row) {
            $question = Question::create([
                'question' => $row[0] ?? null,
                'answer' => $row[5] ?? null,
                'reference' => $row[6] ?? null,
                'type' => strtolower($row[7]),
                'rank' => $row[8] ?? null,
                'status' => 1,
            ]);

            $options = [];
            if (! empty($row[1])) {
                $options[] = ['option' => $row[1] ?? null, 'is_correct' => $row[5] == $row[1] ? 1 : 0];
            }
            if (! empty($row[2])) {
                $options[] = ['option' => $row[2] ?? null, 'is_correct' => $row[5] == $row[2] ? 1 : 0];
            }
            if (! empty($row[3])) {
                $options[] = ['option' => $row[3] ?? null, 'is_correct' => $row[5] == $row[3] ? 1 : 0];
            }
            if (! empty($row[4])) {
                $options[] = ['option' => $row[4] ?? null, 'is_correct' => $row[5] == $row[4] ? 1 : 0];
            }

            $question->options()->createMany($options);
        }
    }
}
