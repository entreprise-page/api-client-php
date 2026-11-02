<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__.'/src', __DIR__.'/tests', __DIR__.'/bin'])
    // Généré depuis le swagger et vérifié par GeneratedModelsTest.
    ->exclude(['Model'])
    ->append([__FILE__])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        // Le SDK supporte PHP 7.4 : pas de virgule finale dans les paramètres (PHP 8.0).
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'array_destructuring']],
        // Sans type natif mixed en PHP 7.4, @param mixed est la seule déclaration du type.
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true],
    ])
    ->setFinder($finder)
;
