<?php
namespace Parsers;

class StripTags implements ParserInterface {
    public function process($str)
    {
        return strip_tags($str);
    }
}
