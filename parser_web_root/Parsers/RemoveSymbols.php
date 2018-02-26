<?php
/**
 * Created by PhpStorm.
 * User: ninja
 * Date: 24.02.18
 * Time: 19:35
 */

namespace Parsers;


class RemoveSymbols implements ParserInterface
{
    public function process($str)
    {
        $needle = str_split('[.,/!@#$%&*()]');
        return str_ireplace($needle, "", $str);
    }
}
