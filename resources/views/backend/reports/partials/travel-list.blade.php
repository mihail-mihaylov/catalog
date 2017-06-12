<div LANG="en-US" TEXT="#000000" DIR="LTR">
    <TABLE WIDTH=643 CELLPADDING=2 CELLSPACING=0 STYLE="page-break-before: always; margin: auto;">
    <COL WIDTH=50>
    <COL WIDTH=8>
    <COL WIDTH=2>
    <COL WIDTH=9>
    <COL WIDTH=38>
    <COL WIDTH=13>
    <COL WIDTH=39>
    <COL WIDTH=14>
    <COL WIDTH=38>
    <COL WIDTH=74>
    <COL WIDTH=20>
    <COL WIDTH=14>
    <COL WIDTH=8>
    <COL WIDTH=2>
    <COL WIDTH=19>
    <COL WIDTH=63>
    <COL WIDTH=26>
    <COL WIDTH=56>
    <COL WIDTH=74>
    <TBODY>
        <TR>
            <TD WIDTH=50 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in"><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.company') }}</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=266 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 15pt">{{ (isset($companyName)) ? $companyName : "......................................" }}</FONT></P>
            </TD>
            <TD COLSPAN=6 WIDTH=146 VALIGN=TOP STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.allowed_exit') }}</FONT></P>
            </TD>
            <TD COLSPAN=3 WIDTH=164 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">...........................................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD WIDTH=50 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in"><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.address') }}</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=266 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">....................................................</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=RIGHT STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.signature') }}, {{ trans('travelList.seal') }})</B></I></FONT></P>
            </TD>
        </TR>
        <TR>
            <TD WIDTH=50 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in"><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.phone') }}</FONT></P>
            </TD>
            <TD COLSPAN=5 WIDTH=85 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in"><FONT SIZE=2 STYLE="font-size: 11pt">...............</FONT></P>
            </TD>
            <TD WIDTH=39 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in"><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.fax') }}</FONT></P>
            </TD>
            <TD COLSPAN=3 WIDTH=134 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in"><FONT SIZE=2 STYLE="font-size: 11pt">................</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><BR></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=19 WIDTH=639 HEIGHT=48 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER><FONT SIZE=3 STYLE="font-size: 13pt"><B>{{ strtoupper(trans('travelList.travel_list')) }}</B></FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=9 WIDTH=242 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=RIGHT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.series') }}</FONT></P>
            </TD>
            <TD WIDTH=74 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT> <FONT SIZE=2 STYLE="font-size: 11pt">.................</FONT></P>
            </TD>
            <TD WIDTH=20 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=RIGHT>{{ trans('travelList.number') }}</P>
            </TD>
            <TD COLSPAN=8 WIDTH=290 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT> <FONT SIZE=2 STYLE="font-size: 11pt">...............</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=4 WIDTH=80 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.car') }}:</FONT></P>
            </TD>
            <TD COLSPAN=13 WIDTH=416 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT>
                <FONT SIZE=2 STYLE="font-size: 15pt">
                    {{-- {{dd($trackedObject->brand->translation->first())}} --}}
                {{ isset($trackedObject) ? $trackedObject->brand->translation->first()->name . " " . $trackedObject->model->translation->first()->name : ""}}</FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=134 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT>
                <FONT SIZE=2 STYLE="font-size: 15pt">
                {{ isset($trackedObject) ? $trackedObject->identification_number : ""}}</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=17 WIDTH=500 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.brand') }}, {{ trans('travelList.model') }})</B></I></FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=134 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.registration') }}</B></I></FONT><FONT FACE="Liberation Serif, Times New Roman, serif"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>{{ trans('travelList.number') }}</B></I></FONT></FONT><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>)</B></I></FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=3 WIDTH=68 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.driver') }} I:</FONT></P>
            </TD>
            <TD COLSPAN=16 WIDTH=567 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT>
                <FONT SIZE=2 STYLE="font-size: 11pt">.........................................................................................................................................................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=3 WIDTH=68 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western"><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.driver') }} II:</FONT></P>
            </TD>
            <TD COLSPAN=16 WIDTH=567 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT>
                <FONT SIZE=2 STYLE="font-size: 11pt">.........................................................................................................................................................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=5 WIDTH=122 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.attendants') }}: 1.</FONT></P>
            </TD>
            <TD COLSPAN=7 WIDTH=236 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">.............................................................</FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=14 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=RIGHT><FONT SIZE=2 STYLE="font-size: 11pt">2.</FONT></P>
            </TD>
            <TD COLSPAN=5 WIDTH=254 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">...................................................................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=5 WIDTH=122 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.issued_travel_list') }}:</FONT></P>
            </TD>
            <TD COLSPAN=10 WIDTH=278 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT>
                <FONT SIZE=2 STYLE="font-size: 11pt">.......................................................................</FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=93 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT>  <FONT SIZE=2 STYLE="font-size: 11pt">(......................)</FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=134 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT> <FONT SIZE=2 STYLE="font-size: 11pt">.............................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=5 WIDTH=122 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><BR>
                </P>
            </TD>
            <TD COLSPAN=10 WIDTH=278 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.first_name') }}, {{ trans('travelList.middle_name') }}, {{ trans('travelList.last_name') }})</B></I></FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=93 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.date') }})</B></I></FONT></P>
            </TD>
            <TD COLSPAN=2 WIDTH=134 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.seal') }})</B></I></FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=10 WIDTH=320 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.time_exit_garage') }} ({{ trans('travelList.date') }}, {{ trans('travelList.hour') }}, {{ trans('travelList.minutes') }}):</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">.....................................................................................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=10 WIDTH=320 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.time_entry_garage') }} ({{ trans('travelList.date') }}, {{ trans('travelList.hour') }}, {{ trans('travelList.minutes') }}):</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">.....................................................................................</FONT></P>
            </TD>
        </TR>
    </TBODY>
    <TBODY>
        <TR>
            <TD COLSPAN=10 WIDTH=320 HEIGHT=17 STYLE="border-top: 1px solid #000000; border-bottom: none; border-left: none; border-right: none; padding-top: 0.02in; padding-bottom: 0in; padding-left: 0in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.car_technically_correct') }}.</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border-top: 1px solid #000000; border-bottom: none; border-left: 1px solid #000000; border-right: none; padding-top: 0.02in; padding-bottom: 0in; padding-left: 0.02in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.took_car_technically_correct') }}.</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=3 WIDTH=68 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.mechanic') }}:</FONT></P>
            </TD>
            <TD COLSPAN=7 WIDTH=249 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">................................................./.............</FONT></P>
            </TD>
            <TD COLSPAN=3 WIDTH=50 STYLE="border-top: none; border-bottom: none; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.04in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.driver') }}:</FONT></P>
            </TD>
            <TD COLSPAN=6 WIDTH=260 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">...................................................../.............</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=3 WIDTH=68 HEIGHT=17 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0in; padding-bottom: 0.02in; padding-left: 0in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><BR></P>
            </TD>
            <TD COLSPAN=7 WIDTH=249 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0in; padding-bottom: 0.02in; padding-left: 0in; padding-right: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.last_name') }}, {{ trans('travelList.seal') }})</B></I></FONT></P>
            </TD>
            <TD COLSPAN=3 WIDTH=50 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.02in; padding-left: 0.02in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><BR>
                </P>
            </TD>
            <TD COLSPAN=6 WIDTH=260 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0in; padding-bottom: 0.02in; padding-left: 0in; padding-right: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.last_name') }}, {{ trans('travelList.seal') }})</B></I></FONT></P>
            </TD>
        </TR>
    </TBODY>
    <TBODY>
        <TR>
            <TD ROWSPAN=2 COLSPAN=10 WIDTH=320 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.alcohol') }}. </FONT></P>
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.general_health_condition_good') }}.</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border-top: 1px solid #000000; border-bottom: none; border-left: 1px solid #000000; border-right: none; padding-top: 0.02in; padding-bottom: 0in; padding-left: 0.02in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.driver_fit_to_drive') }}.</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=6 WIDTH=146 STYLE="border-top: none; border-bottom: none; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0in; padding-left: 0.04in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.complete_check') }}:</FONT></P>
            </TD>
            <TD COLSPAN=3 WIDTH=164 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">.........................../..............</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=10 WIDTH=320 HEIGHT=16 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><BR></P>
            </TD>
            <TD COLSPAN=6 WIDTH=146 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0.04in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><BR></P>
            </TD>
            <TD COLSPAN=3 WIDTH=164 STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0in; padding-bottom: 0.04in; padding-left: 0in; padding-right: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.last_name') }}, {{ trans('travelList.seal') }})</B></I></FONT></P>
            </TD>
        </TR>
    </TBODY>
    <TBODY>
        <TR>
            <TD COLSPAN=10 WIDTH=320 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.odometer') }}:</FONT></P>
            </TD>
            <TD COLSPAN=9 WIDTH=314 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><BR></P>
            </TD>
        </TR>
        <TR STYLE="border-top: none; border-bottom: 1px solid #000000; border-left: none; border-right: none; padding-top: 0in; padding-bottom: 0.02in; padding-left: 0in; padding-right: 0in; height: 15px; font-size: 11pt">
            <TD STYLE="font-size: 10pt; font-family: 'Roboto', 'Noto', sans-serif;">
                <P><FONT>{{ trans('travelList.initial') }}:</FONT></P>
            </TD>
            <TD STYLE="font-size: 10pt; font-family: 'Roboto', 'Noto', sans-serif;">
                <P><FONT>{{ isset($trips) && ! $trips->isEmpty() ?
                    ($firstMileage = is_array($trips->first()) ? $trips->first()['gpsEvents']->first()
                    ->mileage : $trips->first()
                    ->gpsEvents->first()
                    ->mileage) : "................................................" }}</FONT></P>
            </TD>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <TD STYLE="font-size: 10pt; font-family: 'Roboto', 'Noto', sans-serif;">
                <P><FONT>{{ trans('travelList.end') }}:</FONT></P>
            </TD>
            <TD STYLE="font-size: 10pt; font-family: 'Roboto', 'Noto', sans-serif;">
                <P>
                <FONT>{{ isset($trips) && ! $trips->isEmpty() ?
                    ($lastMileage = is_array($trips->first()) ? $trips->last()['gpsEvents']->last()->mileage : $trips->last()->gpsEvents->last()->mileage) : "................................................" }}</FONT></P>
            </TD>
            <td></td>
            <td></td>
            <td></td>
            <TD STYLE="font-size: 10pt; font-family: 'Roboto', 'Noto', sans-serif;">
                <P><FONT>{{ trans('travelList.total') }}:</FONT></P>
            </TD>
            <TD>
                <P>

                <FONT>{{ (isset($firstMileage) && isset($lastMileage)) ? ($lastMileage - $firstMileage) : ".................................." }}</FONT>
                @if( isset($trips) && ! $trips->isEmpty())
                <font>({{ (is_array($trips->last())) ?
                    $trips->last()['tripData']->gpsEvents->last()->mileage - $firstMileage:
                    $trips->last()->gpsEvents->last()->mileage - $firstMileage }})</font>
                @endif    
            </P>
            </TD>
        </TR>
    </TBODY>
    <TBODY>
        <TR>
            <TD COLSPAN=8 WIDTH=200 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">{{ trans('travelList.received_checked_travel_list') }}:</FONT></P>
            </TD>
            <TD COLSPAN=11 WIDTH=434 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT><FONT SIZE=2 STYLE="font-size: 11pt">.........................................................................../ .................. / ..................</FONT></P>
            </TD>
        </TR>
        <TR>
            <TD COLSPAN=8 WIDTH=200 HEIGHT=17 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0in"><BR></P>
            </TD>
            <TD COLSPAN=9 WIDTH=296 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"> <FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.first_name') }}, {{ trans('travelList.last_name') }})</B></I></FONT></P>
            </TD>
            <TD WIDTH=56 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.date') }})</B></I></FONT></P>
            </TD>
            <TD WIDTH=74 STYLE="border: none; padding: 0in">
                <P CLASS="western" ALIGN=CENTER STYLE="margin-top: 0in"><FONT SIZE=2 STYLE="font-size: 9pt"><I><B>({{ trans('travelList.seal') }})</B></I></FONT></P>
            </TD>
        </TR>
    </TBODY>
</TABLE>
<P CLASS="western" ALIGN=LEFT STYLE="margin-top: 0.04in; margin-bottom: 0.04in; font-weight: normal; line-height: 100%">
<BR><BR>
</P>
</div>
