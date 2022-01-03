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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/recipes', 'RecipesController@index'); // not needed

$router->post('/recipes', 'RecipesController@store');

$router->get('/recipe/{recipe_id}', 'RecipesController@show');
$router->put('/recipe/{recipe_id}', 'RecipesController@update');
$router->delete('/recipe/{recipe_id}', 'RecipesController@destroy');

$router->get('/recipe/{recipe_id}/ingredients', 'RecipeIngredientsController@index');
$router->post('/recipe/{recipe_id}/ingredients', 'RecipeIngredientsController@store');
$router->patch('/ingredient/{record_id}', 'RecipeIngredientsController@update');
$router->delete('/ingredient/{record_id}', 'RecipeIngredientsController@destroy');
$router->delete('/recipe/{recipe_id}/ingredients', 'RecipeIngredientsController@destroyRecipeIngredients'); // not used


// !!!
$router->get('/recipesall', 'RecipesController@all');
$router->delete('/recipesall', 'RecipesController@destroyall');
