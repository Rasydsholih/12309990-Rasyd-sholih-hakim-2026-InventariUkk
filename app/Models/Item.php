<?php

namespace App\Models;

use App\Models\categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\lendings;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'total',
        'repair',
        'lending',
    ];

    /**
     * Relationship dengan Category
     */
    public function category()
    {
        return $this->belongsTo(categories::class);
    }

    /**
     * Relationship dengan Lending
     */

}