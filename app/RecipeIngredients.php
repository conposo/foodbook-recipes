<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Excludable;

class RecipeIngredients extends Model
{
    use Excludable;

    public function getBgNameAttribute()
    {
        return $this->attributes['bg_name'];
    }

    // protected $appends = ['bg_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'unit',
        'quantity',
    ];
}
