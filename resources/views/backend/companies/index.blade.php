@extends('backend.wrapper')

@section('page_title')
    {{ trans_choice('companies.company', 2) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox" id="companies_list">
                <div class="ibox-title fix-ibox-title">
                    <div class="col-md-5 fix-title">
                        <h5>
                            <i class="fa fa-building-o"></i>
                            {{ trans('general.list_of') }} {{ trans_choice('companies.company', 2) }}
                        </h5>
                    </div>
                    <div class="ibox-tools">
                        @can('haveClientCompany', Session::get('managed_company'))
                            <button type="button" class="btn btn-custom btn-sm" data-action="{{ route('companies.create') }}" data-get data-title="{{ trans('companies.add_new') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i>
                                {{trans('companies.add_new')}}
                            </button>
                        @endcan
                        <div class="companies_search inline"></div>
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered table-striped table-hover data-table" id="companiesTable">
                        <thead>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('general.company_name') }}</th>
                                <th>{{ trans('general.responsible_person_name') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="gradeX">
                                <th></th>
                                <th>{{ trans('general.company_name') }}</th>
                                <th>{{ trans('general.responsible_person_name') }}</th>
                                <th>{{ trans('general.actions') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($companies as $company)
                                @include('backend.companies.partials.row', ['company' => $company])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!! Html::script('js/modules/companies.js') !!}
    {!! Html::script('js/data-tables.js') !!}
@endsection
