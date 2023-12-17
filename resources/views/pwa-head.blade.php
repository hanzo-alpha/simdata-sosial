<!-- PWA  -->
@php
    $asset = '';
    if(app()->environment('production')){
        $asset .= 'public/';
    }
@endphp
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset($asset . 'images/logo/simdata/logo-color.svg') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">
