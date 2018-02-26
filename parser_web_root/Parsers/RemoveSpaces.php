<?php
namespace Parsers;

class RemoveSpaces implements ParserInterface
{
    public function process($str)
    {
        return str_replace(" ", "", $str);
    }
}
