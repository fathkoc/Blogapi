<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['name'];

    /**
     * Kategoriye ait bloglar ile ilişkisi (Bir kategori birden fazla bloga sahip olabilir)
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
