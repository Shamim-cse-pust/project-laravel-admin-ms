<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'link_products');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
