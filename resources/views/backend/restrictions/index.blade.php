@extends('backend.wrapper')

@section('page_title')
    {{ trans_choice('restrictions.restriction', 2) }} / {{ trans_choice('violations.violation', 2) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tabs-container restrictions_violations_container">
                <ul class="nav nav-tabs">
                    <li class="active restrictions_limits">
                        <a data-toggle="tab" href="#restrictions">
                            <i class="glyphicon glyphicon-minus-sign"></i>
                            {{trans_choice('restrictions.restriction', 2)}}
                        </a>
                    </li>
                    <li class="restrictions_limits">
                        <a data-toggle="tab" href="#violations">
                            <i class="fa fa-warning"></i>
                            {{trans_choice('violations.violation', 2)}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="restrictions" class="tab-pane active">
                        <div class="ibox" id="restrictions_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>
                                        {{ trans('general.list_of') }} {{ trans('restrictions.restrictions') }}
                                    </h3>
                                </div>
                                <div class="ibox-tools">
                                        <button class="create-restriction btn btn-sm btn-custom" data-title="{{trans('restrictions.add_new')}}" data-action="{{route('restrictions.create')}}" data-get>
                                            <i class="fa fa-plus"></i>&nbsp;
                                            {{trans('restrictions.add_new')}}
                                        </button>
                                    <div class="restrictions_search inline"></div>
                                </div>

                            </div>
                            <div class="ibox-content">
                                @include('backend.restrictions.partials.list')
                            </div>
                        </div>
                    </div>
                    <div id="violations" class="tab-pane">
                        <div class="ibox" id="violations_list">
                            <div class="ibox-title" style="border-top:none">
                                <div class="col-md-5">
                                    <h3>
                                        {{ trans('general.list_of') }} {{ trans('violations.violations') }}
                                    </h3>
                                </div>
                                <div class="ibox-tools">
                                        <button class='btn btn-custom btn-sm' data-action='{{ route('violations.destroy.all') }}' data-delete-all data-table-name="violations_table">
                                            <i class="fa fa-trash-o"></i>&nbsp;
                                            {{trans('general.delete')}}
                                        </button>
                                    <div class="violations_search inline"></div>
                                </div>

                            </div>
                            <div class="ibox-content">
                                @include('backend.violations.partials.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 hidden">
            @include('backend.restrictions.partials.map')
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('js/modules/restrictions.js') !!}
    {!! Html::script('js/modules/violations.js') !!}
    {!! Html::script('js/data-tables.js') !!}
@endsection
