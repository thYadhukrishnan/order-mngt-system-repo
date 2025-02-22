<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
