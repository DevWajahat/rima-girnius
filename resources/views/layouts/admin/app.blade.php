@include('includes.admin.head')

@include('includes.admin.header')

@if(isset($slot))
    {{ $slot }}
@else
    @yield('content')
@endif

@include('includes.admin.footer')
@include('includes.admin.scripts')

