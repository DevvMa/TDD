<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price'];

    public function getPriceIdrAttr(){
        return (new CurrencyService())->convert($this->price, 'usd', 'idr');
    }
}
