<div class="flex flex-row space-x-5 h-screen overflow-y-hidden overflow-x-scroll">
    <div class="w-96 h-full flex flex-col">
        <div class="text-center py-3">DBML Editor</div>
        <div class="flex-grow">
            <textarea wire:model="dbml" class="w-full h-full resize-none"></textarea>
        </div>
    </div>
    <div class="w-96 h-full flex flex-col">
        <div class="text-center py-3">Token List</div>
        <ul class="list-disc pl-5 space-y-5 overflow-y-scroll">
            @foreach ($tokens as $token)
                <li>
                    @switch (get_class($token))
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent::class)
                            Token "{{ $token->content }}" on line {{ $token->line }} between columns {{ $token->startColumn }} and {{ $token->endColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\LineCommentEvent::class)
                            Line comment "{{ $token->content }}" on line {{ $token->line }} between columns {{ $token->startColumn }} and {{ $token->endColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\WhiteSpaceEvent::class)
                            White space {{ json_encode($token->content) }} between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\StringLiteralEvent::class)
                            String literal {{ json_encode($token->content) }} between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\UnknownEvent::class)
                            Unknown content {{ json_encode($token->content) }} between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\BacktickStringLiteralEvent::class)
                            Backtick string literal {{ json_encode($token->content) }} on between line {{ $token->startLine }}, column {{ $token->startColumn }} and line {{ $token->endLine }}, column {{ $token->endColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Tokenization\Logging\EndOfFileEvent::class)
                            End of file on line {{ $token->line }}, column {{ $token->column }}.
                            @break
                    @endswitch
                </li>
            @endforeach
        </ul>
    </div>
    <div class="w-96 h-full flex flex-col">
        <div class="text-center py-3">Pseudo-highlighted</div>
        <div class="text-0 overflow-y-scroll">
            @foreach ($tokens as $token)
                @switch (get_class($token))
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\TokenEvent::class)
                        <span class="text-blue text-base border">{{ $token->content }}</span>
                        @break
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\LineCommentEvent::class)
                        <span class="text-grey text-base border">//{{ $token->content }}</span>
                        @break
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\WhiteSpaceEvent::class)
                        <span class="whitespace-pre text-base border">{{ $token->content }}</span>
                        @break
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\StringLiteralEvent::class)
                        <span class="whitespace-pre text-green text-base border">&apos;{{ $token->content }}&apos;</span>
                        @break
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\UnknownEvent::class)
                        <span class="text-red text-base border">{{ $token->content }}</span>
                        @break
                    @case(JamesWildDev\DBMLParser\Tokenization\Logging\BacktickStringLiteralEvent::class)
                        <span class="text-purple text-base border">`{{ $token->content }}`</span>
                        @break
                @endswitch
            @endforeach
        </div>
    </div>
</div>
