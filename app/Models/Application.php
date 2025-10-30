<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'position',
        'link',
        'contact',
        'applied_date',
        'interview_date',
        'salary',
        'feedback',
        'status_id',
        'company_id',
        'city_id',
        'modality_id',
        'contract_id',
        'category_id',
    ];

    protected $casts = [
        'applied_date' => 'date',
        'interview_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function modality(): BelongsTo
    {
        return $this->belongsTo(Modalities::class, 'modality_id', 'id');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
