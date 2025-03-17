<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $link_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct whereLinkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LinkProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LinkProduct extends Model
{
    protected $guarded = ['id'];
}
