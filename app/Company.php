<?php

namespace App;

use Carbon\Carbon;
use App\Services\Facades\MPSBackend;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Company extends Model
{
    use SoftDeletes;

    public $usageCount = null;

    protected $fillable = ['deleted_at', 'name', 'stub', 'image', 'licences', 'licence_start_date', 'licence_end_date', 'licence_status',
        'employee_register_passkey', 'status', 'created_at', 'updated_at'];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'licence_start_date',
        'licence_end_date',
    ];
    
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y h:i A');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
    
    public function getListStatus()
    {
        switch (true) {
            case $this->getOriginal('status') === 'SUSPENDED':
                return 'SUSPENDED';
            case $this->getOriginal('licence_status') === 'PENDING':
                return 'PENDING';
            default:
                return 'ACTIVE';
        }
        // this is unreachable?
        //if ($this->getOriginal('status'))
        //return Carbon::parse($value)->format('d/m/Y');
    }
    
    public function getLicenceStartDateAttribute($value)
    {
        if($value) {
            return Carbon::parse($value)->format('d/m/Y');
        }
    }
    
    public function getLicenceStartDateTimestamp()
    {
        return Carbon::parse($this->getOriginal('licence_start_date'))->getTimestamp();
    }
    
    public function getLicenceEndDateAttribute($value)
    {
        if($value) {
            return Carbon::parse($value)->format('d/m/Y');
        }
    }
        
    public function getLicenceEndDateTimestamp()
    {
        return Carbon::parse($this->getOriginal('licence_end_date'))->getTimestamp();
    }
    
    public function getEmployeeRegisterPasskeyAttribute($value)
    {
        if ($value) {
            return decrypt($this->getOriginal('employee_register_passkey'));
        }
        return '';
    }
    
    public function setEmployeeRegisterPasskeyAttribute($value)
    {
        If ($value) {
            $this->attributes['employee_register_passkey'] = encrypt($value);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyAdmins()
    {
        return $this->hasMany('App\CompanyAdmin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyDomains()
    {
        return $this->hasMany('App\CompanyDomain');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyEmails()
    {
        return $this->hasMany('App\CompanyEmail');
    }
    
    /**
     * Get the licence days left.
     *
     * @return mixed
     */
    public function getLicenceDaysLeft()
    {
        if ($this->getOriginal('licence_end_date')) {
            $end = Carbon::parse($this->getOriginal('licence_end_date'));
            $now = Carbon::now();
            if($end->gte($now)) {
                return $end->diffInDays($now->subDays(2));
            }
            return 0;
        }
        return '';
    }

    /**
     * Get company user count
     *
     * @return int
     */
    public function userCount()
    {
        if(!$this->usageCount) {
            try {
                $this->usageCount = MPSBackend::countUsers($this->stub);
            } catch (\Exception $e) {
                $this->usageCount = 0;
            }
        }

        return $this->usageCount;
    }

    /**
     * Get licence usage percentage
     *
     * @return int
     */
    public function usage()
    {
        return $this->licences ? round($this->userCount() / $this->licences * 100) : 0;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'stub';
    }
}
