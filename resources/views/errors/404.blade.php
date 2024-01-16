@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

{{--<x-filament::card title="Error 404" class="text-center">--}}
{{--    <p>Oops! This resource does not exist. Contact support if this problem persists.</p>--}}
{{--    <x-filament::button tag="a" href="{{ route('filament.admin.pages.dashboard') }}">Back to--}}
{{--        Dashboard--}}
{{--    </x-filament::button>--}}
{{--    --}}{{-- {{ $exception->getMessage() }} --}}
{{--</x-filament::card>--}}
