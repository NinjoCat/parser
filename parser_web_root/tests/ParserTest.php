<?php

namespace test;

use Parsers\ParserAgregator;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testRemoveSpacesTest()
    {
        $container = new ContainerBuilder();

        $container->register('stripTags', \Parsers\StripTags::class);
        $container->register('removeSpaces', \Parsers\RemoveSpaces::class);
        $container->register('replaceSpacesToEol', \Parsers\ReplaceSpacesToEol::class);
        $container->register('htmlspecialchars', \Parsers\Htmlspecialchars::class);
        $container->register('removeSymbols', \Parsers\RemoveSymbols::class);
        $container->register('toNumber', \Parsers\ToNumber::class);

        $parser = new ParserAgregator($container,
            [
                "stripTags",
                "removeSpaces",
                "replaceSpacesToEol",
                "htmlspecialchars",
                "removeSymbols",
                "toNumber"
            ]
        );
        $text = "Привет, мне на <a href=\"test@test.ru\">test@test.ru</a> пришло приглашение встретиться, попить кофе с <strong>10%</strong> содержанием молока за <i>$5</i>, пойдем вместе!";
        $txt = $parser->process(["stripTags", "removeSpaces", "replaceSpacesToEol", "htmlspecialchars", "removeSymbols", "toNumber"],  $text);
        $this->assertEquals(10, $txt);
    }
}