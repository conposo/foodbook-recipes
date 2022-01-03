<?php

namespace App\Http\Controllers;

use App\RecipeIngredients;
use App\Traits\RecipeIngredients as TraitRecipeIngredients;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Traits\ConsumeInternalService;

class RecipeIngredientsController extends Controller
{
    use ApiResponser;
    use ConsumeInternalService;
    use TraitRecipeIngredients;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseUri = config('services.ingredients.base_uri');
    }

    public function index($recipe_id)
    {
        $recipeIngredients = $this->getIngredients($recipe_id);
        // dd((bool)[], $recipe_id, $recipeIngredients);
        // echo '<pre>';
        // var_dump($recipeIngredients->json());
        // echo '</pre>';
        if( $recipeIngredients )
            return $this->successResponse(['ingredients' => $recipeIngredients]);
        else
            return $this->successResponse(['ingredients' => []]);

        // return $this->errorResponse('Recipe hasn\'t Ingredients', 404);
    }

    public function store(Request $request, $recipe_id)
    {
        $rules = [
            'recipe_id' => 'required',
        ];
        $this->validate($request, $rules);

        $recipeIngredients = RecipeIngredients::create($request->all());
        return $this->successResponse($recipeIngredients, Response::HTTP_CREATED);
    }

    public function update(Request $request, $record_id)
    {
        $ingredient = RecipeIngredients::findOrFail($record_id);
        $ingredient->fill([
            'unit' => $request->unit,
            'quantity' => $request->quantity,
        ]);
        $ingredient->save();
        return $this->successResponse($ingredient);
    }

    public function destroy($record_id)
    {
        // $recipeIngredientsIDs = RecipeIngredients::where('recipe_id', $recipe_id)->pluck('id')->toArray();
        RecipeIngredients::destroy($record_id);
        return $this->successResponse(['ingredient resource' => 'deleted']);
    }

    public function destroyRecipeIngredients($recipe_id)
    {
        $recipeIngredientsIDs = RecipeIngredients::where('recipe_id', $recipe_id)->pluck('id')->toArray();
        RecipeIngredients::destroy($recipeIngredientsIDs);
        return $this->successResponse(['ingredient resource' => 'deleted']);
    }


}
