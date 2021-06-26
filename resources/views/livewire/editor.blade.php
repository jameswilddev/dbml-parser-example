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
    <div class="w-96 h-full flex flex-col flex-shrink-0">
        <div class="text-center py-3">Statements</div>
        <ul class="list-disc pl-5 space-y-5 overflow-y-auto flex-grow">
            @foreach ($statements as $statement)
                <li>
                    @switch (get_class($statement))
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\TableEvent::class)
                            Table &quot;{{ $statement->name }}&quot;, named between line {{ $statement->nameStartLine }}, column {{ $statement->nameStartColumn }} and line {{ $statement->nameEndLine }}, column {{ $statement->nameEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\TableAliasEvent::class)
                            Table &quot;{{ $statement->tableName }}&quot; aliased as &quot;{{ $statement->name }}&quot; between line {{ $statement->nameStartLine }}, column {{ $statement->nameStartColumn }} and line {{ $statement->nameEndLine }}, column {{ $statement->nameEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\TableNoteEvent::class)
                            Note &quot;{{ $statement->content }}&quot; added to table &quot;{{ $statement->tableName }}&quot; between line {{ $statement->contentStartLine }}, column {{ $statement->contentStartColumn }} and line {{ $statement->contentEndLine }}, column {{ $statement->contentEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnEvent::class)
                            Column &quot;{{ $statement->name }}&quot;, named between line {{ $statement->nameStartLine }}, column {{ $statement->nameStartColumn }} and line {{ $statement->nameEndLine }}, column {{ $statement->nameEndColumn }}, of type &quot;{{ $statement->type }}&quot;, @if ($statement->size === null)<span>without a size</span>@else<span>with size &quot;{{ $statement->size }}&quot;</span>@endif added to table &quot;{{ $statement->tableName }}&quot;.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnNoteEvent::class)
                            Note &quot;{{ $statement->content }}&quot; added to column &quot;{{ $statement->columnName }}&quot; of table &quot;{{ $statement->tableName }}&quot; between line {{ $statement->contentStartLine }}, column {{ $statement->contentStartColumn }} and line {{ $statement->contentEndLine }}, column {{ $statement->contentEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnPrimaryKeyEvent::class)
                            Column &quot;{{ $statement->columnName }}&quot; of table &quot;{{ $statement->tableName }}&quot; is a primary key.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnIncrementEvent::class)
                            Column &quot;{{ $statement->columnName }}&quot; of table &quot;{{ $statement->tableName }}&quot; is an increment column.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnNotNullEvent::class)
                            Column &quot;{{ $statement->columnName }}&quot; of table &quot;{{ $statement->tableName }}&quot; cannot be null.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnConstantDefaultEvent::class)
                            Column &quot;{{ $statement->columnName }}&quot; of table &quot;{{ $statement->tableName }}&quot; has a constant default of &quot;{{ $statement->content }}&quot; between line {{ $statement->contentStartLine }}, column {{ $statement->contentStartColumn }} and line {{ $statement->contentEndLine }}, column {{ $statement->contentEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\ColumnCalculatedDefaultEvent::class)
                            Column &quot;{{ $statement->columnName }}&quot; of table &quot;{{ $statement->tableName }}&quot; has a calculated default of &quot;{{ $statement->content }}&quot; between line {{ $statement->contentStartLine }}, column {{ $statement->contentStartColumn }} and line {{ $statement->contentEndLine }}, column {{ $statement->contentEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\RefEvent::class)
                            Table &quot;{{ $statement->firstTableNameOrAlias }}&quot; (line {{ $statement->firstTableNameOrAliasStartLine }}, column {{ $statement->firstTableNameOrAliasStartColumn }} to line {{ $statement->firstTableNameOrAliasEndLine }}, column {{ $statement->firstTableNameOrAliasEndColumn }}), column &quot;{{ $statement->firstColumnName }}&quot; (line {{ $statement->firstColumnNameStartLine }}, column {{ $statement->firstColumnNameStartColumn }} to line {{ $statement->firstColumnNameEndLine }}, column {{ $statement->firstColumnNameEndColumn }}) has a
                            @switch ($statement->operator)
                                @case(JamesWildDev\DBMLParser\Parsing\RefOperator::MANY_TO_ONE)
                                    many-to-one
                                    @break
                                @case(JamesWildDev\DBMLParser\Parsing\RefOperator::ONE_TO_MANY)
                                    one-to-many
                                    @break
                                @case(JamesWildDev\DBMLParser\Parsing\RefOperator::MANY_TO_MANY)
                                    many-to-many
                                    @break
                            @endswitch
                            relationship with table &quot;{{ $statement->secondTableNameOrAlias }}&quot; (line {{ $statement->secondTableNameOrAliasStartLine }}, column {{ $statement->secondTableNameOrAliasStartColumn }} to line {{ $statement->secondTableNameOrAliasEndLine }}, column {{ $statement->secondTableNameOrAliasEndColumn }}), column &quot;{{ $statement->secondColumnName }}&quot; (line {{ $statement->secondColumnNameStartLine }}, column {{ $statement->secondColumnNameStartColumn }} to line {{ $statement->secondColumnNameEndLine }}, column {{ $statement->secondColumnNameEndColumn }}).
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\IndexEvent::class)
                            Table &quot;{{ $statement->tableName }}&quot; has @if ($statement->unique)<span>a unique</span>@else<span>a non-unique</span>@endif index including the following columns:
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th colspan="2">Start</th>
                                        <th colspan="2">End</th>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <th>Line</th>
                                        <th>Column</th>
                                        <th>Line</ht>
                                        <th>Column</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($statement->columns as $column)
                                        <tr>
                                            <td>{{ $column['name'] }}</td>
                                            <td>{{ $column['nameStartLine'] }}</td>
                                            <td>{{ $column['nameStartColumn'] }}</td>
                                            <td>{{ $column['nameEndLine'] }}</td>
                                            <td>{{ $column['nameEndColumn'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\EnumEvent::class)
                            Enum &quot;{{ $statement->name }}&quot;, named between line {{ $statement->nameStartLine }}, column {{ $statement->nameStartColumn }} and line {{ $statement->nameEndLine }}, column {{ $statement->nameEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\EnumValueEvent::class)
                            Value &quot;{{ $statement->name }}&quot;, named between line {{ $statement->nameStartLine }}, column {{ $statement->nameStartColumn }} and line {{ $statement->nameEndLine }}, column {{ $statement->nameEndColumn }} added to enum &quot;{{ $statement->enumName }}&quot;.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\EnumValueNoteEvent::class)
                            Note &quot;{{ $statement->content }}&quot; added to value &quot;{{ $statement->name }}&quot; of enum &quot;{{ $statement->enumName }}&quot; between line {{ $statement->contentStartLine }}, column {{ $statement->contentStartColumn }} and line {{ $statement->contentEndLine }}, column {{ $statement->contentEndColumn }}.
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\UnknownEvent::class)
                            Unknown; tokens are:
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th colspan="2">Start</th>
                                        <th colspan="2">End</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <th>Line</th>
                                        <th>Column</th>
                                        <th>Line</ht>
                                        <th>Column</th>
                                        <th>Content</th>
                                        <th>Raw</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($statement->tokenEvents as $tokenEvent)
                                        <tr>
                                            <td>
                                                @switch ($tokenEvent->type)
                                                    @case (JamesWildDev\DBMLParser\Tokenization\TokenType::KEYWORD_SYMBOL_OR_IDENTIFIER)
                                                        Keyword symbol or identifier
                                                        @break
                                                    @case (JamesWildDev\DBMLParser\Tokenization\TokenType::STRING_LITERAL)
                                                        String literal
                                                        @break
                                                    @case (JamesWildDev\DBMLParser\Tokenization\TokenType::BACKTICK_STRING_LITERAL)
                                                        Backtick string literal
                                                        @break
                                                    @case (JamesWildDev\DBMLParser\Tokenization\TokenType::WHITE_SPACE)
                                                        White space
                                                        @break
                                                    @case (JamesWildDev\DBMLParser\Tokenization\TokenType::LINE_COMMENT)
                                                        Line comment
                                                        @break
                                                    @case (JamesWildDev\DBMLParser\Tokenization\TokenType::UNKNOWN)
                                                        Unknown
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $tokenEvent->startLine }}</td>
                                            <td>{{ $tokenEvent->startColumn }}</td>
                                            <td>{{ $tokenEvent->endLine }}</td>
                                            <td>{{ $tokenEvent->endColumn }}</td>
                                            <td>{{ $tokenEvent->content }}</td>
                                            <td><pre>{{ $tokenEvent->raw }}</pre></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @break
                        @case(JamesWildDev\DBMLParser\Parsing\Logging\EndOfFileEvent::class)
                            End of file.  This was @if ($statement->expected)<span class="text-green">expected</span>@else<span class="text-red">unexpected</span>@endif.
                            @break
                    @endswitch
                </li>
            @endforeach
        </ul>
    </div>
</div>
