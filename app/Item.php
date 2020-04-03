<?php
declare(strict_types = 1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = true;
    protected $guarded = [];
}
