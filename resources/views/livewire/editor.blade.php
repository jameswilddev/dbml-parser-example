<div class="flex flex-row space-x-5 h-screen overflow-y-hidden overflow-x-auto">
    <div class="w-96 h-full flex flex-col flex-shrink-0">
        <div class="text-center py-3">DBML Editor</div>
        <div class="flex-grow">
            <textarea wire:model="dbml" class="w-full h-full resize-none"></textarea>
        </div>
    </div>
    <div class="w-96 h-full flex flex-col flex-shrink-0">
        <div class="text-center py-3">Token List</div>
        <ul class="list-disc pl-5 space-y-5 overflow-y-auto flex-grow">
            @foreach ($tokens as $token)
                <li>
                    @switch (get_class($token))
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent::class)
                            @switch ($token->type)
                                @case(JamesWildDev\DBMLParser\Tokenization\TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER)
                                    Token "{{ $token->content }}" between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                                    @break
                                @case(JamesWildDev\DBMLParser\Tokenization\TokenType::LINE_COMMENT)
                                    Line comment "{{ $token->content }}" between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                                    @break
                                @case(JamesWildDev\DBMLParser\Tokenization\TokenType::WHITE_SPACE)
                                    White space {{ json_encode($token->content) }} between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                                    @break
                                @case(JamesWildDev\DBMLParser\Tokenization\TokenType::STRING_LITERAL)
                                    String literal {{ json_encode($token->content) }} between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                                    @break
                                @case(JamesWildDev\DBMLParser\Tokenization\TokenType::UNKNOWN)
                                    Unknown content {{ json_encode($token->content) }} between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                                    @break
                                @case(JamesWildDev\DBMLParser\Tokenization\TokenType::BACKTICK_STRING_LITERAL)
                                    Backtick string literal {{ json_encode($token->content) }} on between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                                    @break
                            @endswitch
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent::class)
                            End of file on line {{ $token->line }}, column {{ $token->column }}.
                            @break
                    @endswitch
                </li>
            @endforeach
        </ul>
    </div>
    <div class="w-96 h-full flex flex-col flex-shrink-0">
        <div class="text-center py-3">Highlighted</div>
        <div class="text-0 overflow-y-auto flex-grow">
            @foreach ($tokens as $token)
                @switch (get_class($token))
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent::class)
                        @switch ($token->type)
                            @case(JamesWildDev\DBMLParser\Tokenization\TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER)
                                <span class="text-blue text-base border">{{ $token->raw }}</span>
                                @break
                            @case(JamesWildDev\DBMLParser\Tokenization\TokenType::LINE_COMMENT)
                                <span class="text-grey text-base border">{{ $token->raw }}</span>
                                @break
                            @case(JamesWildDev\DBMLParser\Tokenization\TokenType::WHITE_SPACE)
                                <span class="whitespace-pre text-base border">{{ $token->raw }}</span>
                                @break
                            @case(JamesWildDev\DBMLParser\Tokenization\TokenType::STRING_LITERAL)
                                <span class="whitespace-pre text-green text-base border">{{ $token->raw }}</span>
                                @break
                            @case(JamesWildDev\DBMLParser\Tokenization\TokenType::UNKNOWN)
                                <span class="text-red text-base border">{{ $token->raw }}</span>
                                @break
                            @case(JamesWildDev\DBMLParser\Tokenization\TokenType::BACKTICK_STRING_LITERAL)
                                <span class="text-purple text-base border">{{ $token->raw }}</span>
                                @break
                        @endswitch
                        @break
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent::class)
                        End of file on line {{ $token->line }}, column {{ $token->column }}.
                        @break
                @endswitch
            @endforeach
        </div>
    </div>
</div>
