<?php
namespace Parsers;

class Htmlspecialchars implements ParserInterface {
    public function process($str)
    {
        return htmlspecialchars($str);
    }
}
