<?php
namespace Parsers;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class ParserAgregator
{
    private $availableParsersList;
    private $container;

    public function __construct(ContainerBuilder $container, array $availableParsersList)
    {
        $this->availableParsersList = $availableParsersList;
        $this->container = $container;

    }

    public function process(array $parsersList, string $str)
    {
        foreach ($parsersList as $parser) {
            if(!in_array($parser, $this->availableParsersList)) {
                continue;
            }

            /** @var ParserInterface **/
            $parser = $this->container->get($parser);
            $str = $parser->process($str);
        }

        return $str;
    }
}
