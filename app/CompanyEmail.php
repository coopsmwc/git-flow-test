<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property int $company_id
 * @property string $domain
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 */
class CompanyEmail extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'email', 'description', 'created_at', 'updated_at'];
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
