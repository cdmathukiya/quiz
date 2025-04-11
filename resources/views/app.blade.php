<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @routes
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
    <link rel="icon" href="{{asset('images/icon-light.svg')}}" type="image/x-icon" >
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/icon-light.svg')}}" >
    @inertiaHead
</head>
<body>

<div>
    @inertia
</div>
<script>
</script>
</body>
</html>
