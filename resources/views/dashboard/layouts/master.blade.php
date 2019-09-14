<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ config('dashboard.title') }} | Dashboard</title>
    {{-- Common Styles --}}
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    {!! Notify::render() !!}
    
    {{-- Page Styles --}}
    @yield('style')
</head>

<body ng-app="myApp">
    <div class="main-wrapper">
        {{-- Header --}}
        @include('dashboard.layouts.header')
        {{-- Sidebar --}}
        @include('dashboard.layouts.sidebar')
        
        <div class="page-wrapper">
            {{-- Content --}}
            @yield('content')

            {{-- Message Box --}}
            @include('dashboard.layouts.message_box')
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    {{-- Common Scripts --}}
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script>
        var app = angular.module('myApp', []);

        //Red asteric on label of required input field 
        $('*[required]').each(function () {
            var label = $("label[for='" + $(this).attr('id') + "']");
            var red_star = ' <span class="text-danger">*</span>'
            label.append(red_star);
        });

        $('*[data-model]').each(function () {
            load_select_options($(this));
        });
        $('*[data-model]').on('change', function () {
            $('*[data-dependent-element-id=' + $(this).attr('id') + ']').each(function () {
                load_select_options($(this));
            });
        });
        function load_select_options(el) {
            var param = {};
            param.model = el.data('model');
            param.value_field = el.data('value-field');
            param.text_field = el.data('text-field');
            param.dependent_field = el.data('dependent-field');
            var el_d = $('#' + el.data('dependent-element-id'));
            param.dependent_model = el_d.data('model');
            param.dependent_value = el_d.val();
            param._token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get-select-options') }}",
                method: "POST",
                data: param,
                success: function (result) {
                    result.unshift({ id: '', text: '' });
                    el.html('');
                    el.select2({ data: result });

                }
            });
        }
    </script>
    {{-- Page Scripts --}}
    @yield('script')
</body>

</html>