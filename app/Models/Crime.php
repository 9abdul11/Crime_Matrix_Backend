<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crime extends Model
{
     protected $table = 'crime';    
     use HasFactory;
     protected $fillable = [
          'serial_number',
          // other fillable attributes...
      ];
    
}
