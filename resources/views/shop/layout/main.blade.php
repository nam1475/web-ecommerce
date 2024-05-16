<!DOCTYPE html>
<html lang="en">
    <head>
        @include('shop.layout.head')
    </head>

    <body > <!--class="animsition" -->

        <!-- Header -->
        @include('shop.layout.header')

        <!-- Cart -->
        {{-- @include('shop.layout.cart')     --}}

        {{-- Content --}}
        @yield('content')

        {{-- Footer --}}
        @include('shop.layout.footer')

    </body>
</html>