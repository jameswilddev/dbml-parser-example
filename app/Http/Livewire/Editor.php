<?php

namespace App\Http\Livewire;

use Livewire\Component;
use JamesWildDev\DBMLParser\Parsing\Logging\LogParserTarget;
use JamesWildDev\DBMLParser\Parsing\Parser;
use JamesWildDev\DBMLParser\Tokenization\Logging\LogTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\MultiTokenizerTarget;
use JamesWildDev\DBMLParser\Tokenization\Tokenizer;

class Editor extends Component
{
    /**
     * The raw DBML entered by the user.
     */
    public string $dbml = 'paste dbml here';

    public function render()
    {
        $logParserTarget = new LogParserTarget();
        $parser = new Parser($logParserTarget);
        $logTokenizerTarget = new LogTokenizerTarget();
        $multiTokenizerTarget = new MultiTokenizerTarget([$parser, $logTokenizerTarget]);
        $tokenizer = new Tokenizer($multiTokenizerTarget);

        foreach (mb_str_split($this->dbml) as $character) {
            $tokenizer->character($character);
        }
        $tokenizer->endOfFile();

        return view('livewire.editor', [
            'tokens' => $logTokenizerTarget->events,
            'statements' => $logParserTarget->events,
        ]);
    }
}
