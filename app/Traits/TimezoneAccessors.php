<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Helpers\TimezoneHelper;

trait TimezoneAccessors
{
    public function getCreatedAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getUpdatedAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getDeletedAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getGpsUtcTimeAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getStartTimeAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getEndTimeAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getArrivesAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getLeavesAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getArrivedAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getLeftAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getRemindAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getDoneAtAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getDateAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    public function getLastLoginAttribute($value) {
        return $this->parseUtcToUserTimezone($value);
    }

    private function parseUtcToUserTimezone($value) {
        $helper = new TimezoneHelper();
        // All timestamps in db are in UTC(project timezone)
        if ($value) {
            return $helper->convertSystemDateToUserTimezoneDate($value);
        }
    }
}