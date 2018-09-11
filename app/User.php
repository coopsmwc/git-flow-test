<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $deleted_at
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $type
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property CompanyAdmin[] $companyAdmins
 */
class User extends Authenticatable
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'type'];
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    /**
     * Scope to filter by sales admin users
     *
     * @param \Illuminate\Database\Query\Builder $query
     */
    public function scopeSalesAdmins($query) {

        $query->where( 'type', '<>', 2 );
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->type == 2;
    }
}
