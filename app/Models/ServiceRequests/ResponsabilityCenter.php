<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsabilityCenter extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'status'
    ];

    protected $table = 'doc_responsability_centers';
}
