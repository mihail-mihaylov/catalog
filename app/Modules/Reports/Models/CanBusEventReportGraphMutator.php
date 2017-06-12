<?php

namespace App\Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Reports\Models\CanBusEvent;
use App\Traits\HasDetailedCanBusInformation;
use App\Traits\HasDoorsCanBusInformation;
use App\Traits\HasGeneralCanBusInformation;
use App\Traits\HasLightsCanBusInformation;
use App\Traits\HasTachographCanBusInformation;

class CanBusEventReportGraphMutator extends CanBusEvent
{
    use HasGeneralCanBusInformation,
        HasTachographCanBusInformation,
        HasDetailedCanBusInformation,
        HasLightsCanBusInformation,
        HasDoorsCanBusInformation;
}
