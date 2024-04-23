<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public $table =  'news';
    public $fillable = ['titre', 'contenu', 'categorie', 'date_debut', 'date_expiration'];

    protected $casts = [
        'date_expiration' => 'datetime:Y-m-d H:i:s',
        'date_debut' => 'datetime:Y-m-d H:i:s',
    ];

    // change date_expiration to carbon format
    public function getDateExpirationAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value) : null;
    }

    // change date_debut to carbon format
    public function getDateDebutAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value) : null;
    }

    /**
     * Get the category associated with the News
     *
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'categorie');
    }
}
