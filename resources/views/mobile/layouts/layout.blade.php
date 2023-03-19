<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- Required Meta Tags --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        {{-- CSS Header --}}
        @include('mobile.inc.cssheader')
        {{--- End CSS Header --}}
            
       
        <title>
            @yield('title')
        </title>
        
        {{-- Favicon --}}
        <link rel="icon" type="image/png" href="{{asset('favicon.png')}}">
    </head>
    <body>

        <div class="container-fluid rounded-top rounded-bottom border border-secondary m-1">
            {{-- Page Content --}}
            @yield('contents')
            {{-- End Page Content --}}
            
            {{--  Buttons --}}
            @include ('mobile.inc.buttons')   
            {{--  End of buttons --}}
            {{-- Footer Area --}}
            @include('mobile.inc.footer')
            {{-- End Footer Area --}}

        </div>
        
        {{-- JS Ordinary  --}} 
        @include('mobile.inc.jsfooter')
        {{-- End JS ordinary --}}

        {{-- JS Customs  --}} 
        @include('mobile.inc.jscustom')
        {{-- End JSCustoms --}}
        
    </body>
</html>