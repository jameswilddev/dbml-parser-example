<?php

namespace App\Http\Livewire;

use Livewire\Component;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Tokenizer;

class Editor extends Component
{
    /**
     * The raw DBML entered by the user.
     */
    public string $dbml = 'paste dbml here';

    public function render()
    {
        $logTokenizerTarget = new LogTokenizerTarget();
        $tokenizer = new Tokenizer($logTokenizerTarget);

        foreach (mb_str_split($this->dbml) as $character) {
            $tokenizer->character($character);
        }
        $tokenizer->endOfFile();

        return view('livewire.editor', [
            'tokens' => $logTokenizerTarget->events,
        ]);
    }
}
