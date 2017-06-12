<?php
namespace App\Modules\Users\Traits;

use App\Company;

trait HasClientCompanies
{
    public function clientCompanies()
    {
        return $this->hasMany(Company::class, 'parent_company_id');
    }
}
