{{-- {{dd($violationData)}} --}}
{{-- <div class="m-b-md" id="notification">
    <i class="fa fa-bell fa-2x"></i>
    <h1 class="m-xs">Настъпи нарушение.</h1>
    <h3 class="font-bold no-margins">

    </h3>
    <small>Ограничение# </small>
</div> --}}

<div class="alert alert-warning alert-dismissable notification text-center center">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    Настъпи нарушение
    <div id="violation_data" data-violation="{{json_encode($violationData)}}"></div>
     <a class="alert-link" id="view_violation_data" href="#">Виж на картата</a>.
</div>