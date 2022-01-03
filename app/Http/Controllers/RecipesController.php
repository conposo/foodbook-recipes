<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\RecipeIngredients;
use App\Traits\RecipeIngredients as TraitRecipeIngredients;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Traits\ConsumeInternalService;

class RecipesController extends Controller
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

    public function index()
    {
        $recipes = Recipe::all();
        return $this->successResponse($recipes);
    }

    public function store(Request $request)
    {
        $rules = [
            'steps' => 'required',
        ];
        $this->validate($request, $rules);

        $recipe = Recipe::create($request->all());
        return $this->successResponse($recipe, Response::HTTP_CREATED);
    }

    public function show($recipe_id)
    {

        // $_ingredients = $this->performRequest('GET', 'ingredients');
        // $recipe = Recipe::findOrFail($recipe_id);

        $recipe = Recipe::find($recipe_id);

        
        if( is_null($recipe) )
        {
            // $steps = [ ['step' => '1', 'text' => 'все още няма въведена рецепта'] ];
            $steps = [];
        }
        else $steps = json_decode($recipe->steps, true);
        
        $recipeIngredients = $this->getIngredients($recipe_id);
        $recipeIngredients = $recipeIngredients ? $recipeIngredients: [];
        
        // dd(['steps' => $steps, 'ingredients' => $recipeIngredients]);

        return $this->successResponse(['steps' => $steps, 'ingredients' => $recipeIngredients]);
    }

    public function update(Request $request, $recipe_id)
    {
        // $rules = [
        //     'steps' => 'min:5',
        // ];
        // $this->validate($request, $rules);
        $recipe = Recipe::findOrFail($recipe_id);
        $recipe->fill($request->all());
        // if($recipe->isClean())
        // {
        //     return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        // }
        $recipe->save();
        return $this->successResponse($recipe);
    }

    public function destroy($recipe_id)
    {
        // $recipe = Recipe::findOrFail($recipe_id);
        // if($recipe) $recipe->delete();
        Recipe::destroy($recipe_id);
        return $this->successResponse(['data' => 'deleted']);
    }

    public function all()
    {
        $recipes = Recipe::all();
        return $this->successResponse($recipes);
    }
    
    public function destroyall()
    {        
        $recipe = Recipe::truncate();
        return $this->successResponse($recipe);
    }
}
