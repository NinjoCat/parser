<?php
namespace Parsers;

class ToNumber implements ParserInterface
{
    public function process ($str)
    {
        if (!preg_match_all('|\d+|', $str, $matches)) {
            return 0;
        } else {
            return $matches[0][0];
        }
    }
}
