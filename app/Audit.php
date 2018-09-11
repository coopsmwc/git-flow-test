<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 * @property User $user
 */
class Audit extends Model
{
    protected $table = 'audit';
    
    /**
     * @var array
     */
    protected $fillable = ['type', 'user_id', 'company_id', 'details', 'created_at', 'updated_at'];
    
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
