<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'cover', 'status'];

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
