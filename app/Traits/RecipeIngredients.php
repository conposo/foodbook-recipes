<?php

namespace App\Traits;

trait RecipeIngredients
{
    public function getIngredients($recipe_id)
    {
        $fianlrecipeIngredients = [];

        $recipeIngredients = \App\RecipeIngredients::where('recipe_id', '=', $recipe_id);

        if($recipeIngredients->get()->isNotEmpty())
        {
            $recipeIngredientsIDs = $recipeIngredients->pluck('ingredient_id')->toArray();
            // $recipeIngredients = $recipeIngredients->get()->each->append('bg_name');
            $recipeIngredients = $recipeIngredients->get();
            $ingredients = $this->performRequest('GET', 'getingredients/'.implode(',',$recipeIngredientsIDs));
            $ingredientsCollection = collect(json_decode($ingredients, true)['data'])->toArray();
            // dd($recipeIngredients->toArray());
            foreach($recipeIngredients->toArray() as $ingredient)
            {
                foreach($ingredientsCollection as $id => $bg_name)
                {
                    // var_dump($ingredient['ingredient_id'], $id);
                    if($ingredient['ingredient_id'] == $id)
                        $ingredient['bg_name'] = $ingredientsCollection[$ingredient['ingredient_id']];
                }
                $fianlrecipeIngredients[] = $ingredient;
            }
            // dd($fianlrecipeIngredients);
        }
        else
        {
            $fianlrecipeIngredients = null;
        }

        return $fianlrecipeIngredients;
    }

}