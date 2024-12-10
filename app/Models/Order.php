<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotlaAtributes()
    {
        return $this->orderItems->sum(function (OrderItem $item) {
            return $item->price * $item->quantity;
        });
    }
}
