<?php

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('.php_cs')
    ->notName('composer.*')
    ->notName('phpunit.xml*')
    ->notName('*.phar')
    ->notName('*.tpl.php')
    ->exclude('vendor')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->fixers(array('-Psr0Fixer'))
    ->finder($finder)
;