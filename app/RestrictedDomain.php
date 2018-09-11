<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property string $domain
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 */
class RestrictedDomain extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'domain', 'created_at', 'updated_at'];
    
        protected $dates = [
        'created_at',
        'updated_at',
    ];
}
