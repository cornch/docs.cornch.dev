<?php

$finder = PhpCsFixer\Finder::create()->in('app');

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'random_api_migration' => true,
        'void_return' => true,
        'concat_space' => ['spacing' => 'one'],
        'no_spaces_after_function_name' => false,
        'no_space_around_double_colon' => false,
    ])
    ->setFinder($finder);
