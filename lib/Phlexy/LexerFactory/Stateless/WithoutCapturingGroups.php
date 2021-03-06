<?php

namespace Phlexy\LexerFactory\Stateless;

use Phlexy\Lexer;

class WithoutCapturingGroups implements \Phlexy\LexerFactory {
    protected $dataGen;

    public function __construct(\Phlexy\LexerDataGenerator $dataGen) {
        $this->dataGen = $dataGen;
    }

    public function createLexer(array $lexerDefinition, string $additionalModifiers = ''): Lexer {
        $regexes = array_keys($lexerDefinition);

        $compiledRegex = $this->dataGen->getCompiledRegex($regexes, $additionalModifiers);
        $offsetToLengthMap = $this->dataGen->getOffsetToLengthMap($regexes);
        $offsetToTokenMap = array_combine(array_keys($offsetToLengthMap), $lexerDefinition);

        return new \Phlexy\Lexer\Stateless\WithoutCapturingGroups(
            $compiledRegex, $offsetToTokenMap
        );
    }
}