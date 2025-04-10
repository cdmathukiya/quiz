<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @routes
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
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
