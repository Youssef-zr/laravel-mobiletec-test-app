<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'categories';
    public $fillable = ['nom', 'parent_id'];

    /**
     * Get the parent that owns the Category
     *
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get all of the childrens for the Category
     *
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
    /**
     * Get all of the news for the Category
     *
     */
    public function news()
    {
        return $this->hasMany(News::class, 'categorie', 'id');
    }

    /**
     * Get all of the news  not active for the Category
     *
     */
    public function notExpiredNews()
    {
        return $this->news()->where('date_expiration', '>', Carbon::now());
    }
}
