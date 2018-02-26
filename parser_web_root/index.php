<?php
require __DIR__ . "/vendor/autoload.php";

use Parsers\ParserAgregator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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

$data = json_decode(file_get_contents('php://input'), true);
if(!isset($data['job']['text']) || !isset($data['job']['methods'])) {
    header( 'HTTP/1.1 400 BAD REQUEST' );
}

$text = $data['job']['text'];
$methods = $data['job']['methods'];
$txt = $parser->process($methods,  $text);
echo json_encode(['text' => $txt]);