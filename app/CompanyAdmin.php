<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $deleted_at
 * @property string $first_name
 * @property string $last_name
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 * @property User $user
 */
class CompanyAdmin extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'company_id', 'deleted_at', 'name', 'notes', 'status', 'created_at', 'updated_at'];
    
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
