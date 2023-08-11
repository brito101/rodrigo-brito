<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'subtitle', 'cover', 'content', 'views', 'status', 'uri'];

    /** Relationships */
    public function categories()
    {
        return $this->hasMany(PortfolioCategoriesPivot::class);
    }

    /** Accessors */
    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 'post':
                return 'Postado';
                break;
            case 'draft':
                return 'Rascunho';
                break;
            case 'trash':
                return 'Lixeira';
                break;
            default:
                return 'Postado';
        }
    }
}
