<?php
/**
 * Created by PhpStorm.
 * User: Isigar
 * Date: 6/19/2018
 * Time: 12:00 PM
 */

namespace Relisoft\Uploader\Helper;

use Nette\Tokenizer\Tokenizer;
use Tracy\Debugger;

class Parser
{
    const T_AT = 1;
    const T_WHITESPACE = 2;
    const T_STRING = 3;

    const SPLIT_CHAR = "%";

    /**
     * @var Tokenizer
     */
    private $tokenizer;

    /**
     * @var
     */
    private $stream;

    public function __construct()
    {
        $this->tokenizer = new Tokenizer([
            self::T_AT => self::SPLIT_CHAR,
            self::T_WHITESPACE => '\s+',
            self::T_STRING => '\w+'
        ]);
    }

    public function parse($input)
    {
        $this->stream = $this->tokenizer->tokenize($input);
        $result = [];
        while ($this->stream->nextToken()) {
            if ($this->stream->isCurrent(self::T_AT)) {
                $result[] = $this->parseAnnotation();
            }
        }

        return $result;
    }


    protected function parseAnnotation()
    {
        $name = $this->stream->joinUntil(self::T_AT);
        $this->stream->nextUntil(self::T_STRING);
        $content = $this->stream->joinUntil(self::T_AT);
        return $name;
    }

}