<center>
    <p>{{ $message }}</p><br><br>
    @if(!empty($weather))
    <p>Weather in {{ $user->getLocation() }} is {{ $weather->getDescription() }}</p><br>
    <p>{{ $weather->getTemp() }} degree in {{ $weather->getTempType() }} </p>
    @endif
</center>