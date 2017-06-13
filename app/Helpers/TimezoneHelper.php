<?php
namespace App\Helpers;

use Carbon\Carbon;
use Exception;
use Session;

class TimezoneHelper
{
	protected $systemTimezone = null;
	protected $userTimezone = null;

	function __construct()
	{
		$this->systemTimezone = $this->getSystemTimezone();
		$this->userTimezone = $this->getUserTimezone();
	}

    public function convertSystemDateToUserTimezoneDate($date)
    {
        try {
            $systemTimezoneDate = Carbon::createFromFormat('Y-m-d H:i:s', $date, $this->systemTimezone);

            $userTimezoneDate = $this->changeCarbonDatesTimezone($systemTimezoneDate, $this->userTimezone);

            return $userTimezoneDate;

        } catch (Exception $e) {
            return false;        
        }

        return false;
    }

    public function converUserTimezoneDateToSystemDate($date)
    {
        try {
            $userTimezoneDate = $this->createCarbonDateInTimezone($date, $this->userTimezone);

            $systemTimezoneDate = $this->changeCarbonDatesTimezone($userTimezoneDate, $this->systemTimezone);
            
            return $systemTimezoneDate;

        } catch (Exception $e) {
            return false;        
        }

        return false;
    }

    public function getSystemTimezone()
    {
    	return config('app.timezone');
    }

    public function getUserTimezone()
    {
    	return Session::get('system_timezone') !== null ? 
	    	Session::get('system_timezone')['string_format'] : 
	    	$this->getSystemTimezone();
    }

    private function createCarbonDateInTimezone($date, $timezone)
    {
    	return Carbon::createFromFormat('Y-m-d H:i:s', $date, $timezone);
    }

    private function changeCarbonDatesTimezone(Carbon $carbonDate, $timezone)
    {
    	return $carbonDate->setTimezone($timezone);
    }

    /**
     * Works with an integer as well as an array of $workdays
     * 
     * 
     * @param mixed $workDays integer, array
     */
    public function matchSystemTimezoneDateDayOfWeekWithUserTimezoneWorkdays($date, $workDays)
    {
        $dateObj = false;

        try {
            $dateObj = $this->convertSystemDateToUserTimezoneDate($date);
            $dateDayOfWeekNumber = $dateObj->format('N');

            return $dateDayOfWeekNumber == $workDays || in_array($dateDayOfWeekNumber, $workDays);

        } catch (Exception $e) {
            return false;            
        }

        return false;
    }
}