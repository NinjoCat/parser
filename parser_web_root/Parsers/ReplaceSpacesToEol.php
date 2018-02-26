<?php
namespace Parsers;

class ReplaceSpacesToEol implements ParserInterface
{
    public function process($str)
    {
        return str_replace(' ', PHP_EOL, $str);
    }
}
