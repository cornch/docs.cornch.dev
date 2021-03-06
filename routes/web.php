<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', fn () => view('index'));

$router->get('{locale:[\w\-_]+}/{doc:\w+}/{version}/{page:[\w\-_/]+}', ['as' => 'docs.show', function (string $locale, string $doc, string $version, string $page) {
    $docLoader = app(\App\DocLoader::class, [
        'locale' => $locale,
        'doc' => $doc,
        'version' => $version,
        'page' => $page,
    ]);

    return view('docs.show', [
        'title' => $docLoader->getPageTitle(),
        'content' => $docLoader->getPage(),
        'style' => $docLoader->getStyle(),
        'locale' => $locale,
        'doc' => $doc,
        'version' => $version,
        'page' => $page,
    ]);
}]);
