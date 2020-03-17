<div class="card">
    <div class="card-content">
        <img class="card-img img-fluid" src="{{ asset('images/elements/clock2.jpg') }}" alt="Card image">
        <div class="card-img-overlay overflow-hidden overlay-primary overlay-lighten-2">
            @php
            date_default_timezone_set('Europe/Budapest');

            $datenow = new DateTime(date("Y/m/d"));
            $datenow = date_format($datenow, 'Y/m/d');

            $timenow = new DateTime(date("H:i:s"));
            $timenow = date_format($timenow, 'H:i:s');
            @endphp
            <h1 class="text-white">{{ $timenow }}</h1>
            <p class="card-text text-white">{{ $datenow }}</p>
        </div>
    </div>
</div>