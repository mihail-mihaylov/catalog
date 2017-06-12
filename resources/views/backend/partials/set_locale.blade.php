<li class="dropdown">
    {{ strtoupper(App::getLocale()) }}
</li>

<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <div>
            <i style="background-image:url('/img/flags/{{App::getLocale()}}.png');width:20px;background-repeat:no-repeat;display:block;margin:0;">&nbsp;</i>
        </div>
    </a>
    <ul class="dropdown-menu" >
        {{--@foreach (Session::get('company_languages') as $language)--}}
            {{--<li>--}}
                {{--<a href="#" class="set_locale" data-code="{{ $language['code'] }}">--}}
                    {{--<img src="/img/flags/{{ $language['code'] }}.png">&nbsp; {{ $language['name'] }}--}}
                {{--</a>--}}
            {{--</li>--}}
        {{--@endforeach--}}
    </ul>
</li>

{{--{!! Html::script('js/set_locale.js') !!}--}}
