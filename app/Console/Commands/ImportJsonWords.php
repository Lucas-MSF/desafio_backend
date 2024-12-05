<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Word;

class ImportJsonWords extends Command
{
    protected $signature = 'import:json-words';

    protected $description = 'Download and import words from JSON file into database.';

    public function handle()
    {
        $url = 'https://raw.githubusercontent.com/dwyl/english-words/master/words_dictionary.json';
        $response = Http::get($url);

        if ($response->successful()) {
            $words = $response->json();
            try {
                $totalWords = count($words);
                $this->output->progressStart($totalWords);

                $batchSize = 5000;
                $wordBatch = [];
                $counter = 0;

                foreach ($words as $word => $value) {
                    $wordBatch[] = ['word' => $word];

                    if (count($wordBatch) >= $batchSize) {
                        Word::insert($wordBatch);
                        $this->output->progressAdvance(count($wordBatch));
                        $wordBatch = [];
                    }
                    $counter++;
                }

                if (!empty($wordBatch)) {
                    Word::insert($wordBatch);
                    $this->output->progressAdvance(count($wordBatch));
                }

                $this->output->progressFinish();
            } catch (\Exception $e) {
                $this->error('Error importing words: ' . $e->getMessage());
            }
        }
    }
}
