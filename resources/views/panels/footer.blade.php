<!-- BEGIN: Footer-->
@if($configData["mainLayoutType"] == 'horizontal')
    <footer class="footer {{ $configData['footerType'] }} footer-light navbar-shadow">
@else
    <footer class="footer {{ $configData['footerType'] }} footer-light">
@endif
    <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date("Y"); ?><a class="text-bold-800 grey darken-2" href="https://codelabs.hu" target="_blank">CodeLabs,</a>Minden jog fenttartva.</span><span class="float-md-right d-none d-md-block">with.hu<i class="feather icon-git-branch primary"></i>0.0.36</span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
    </p>
</footer>
<!-- END: Footer-->

<!-- Modal -->
<div class="modal fade text-left" id="onshow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel21">Értesítés</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h1><i class="fa fa-check" style="color: #47b272 !important;"></i></h1>
                <h4 style="color: #47b272 !important;">Új rendelés!</h4>
            </div>
            <div class="modal-footer">
                <a href="{{ url('orders') }}" class="btn btn-primary" >Megtekintés</a>
            </div>
        </div>
    </div>
</div>

@if(Auth::check())
<audio id="notification" preload="auto">
  <source src="{{ asset('sounds/notification15.ogg') }}" type="audio/ogg">
  <source src="{{ asset('sounds/notification15.mp3') }}" type="audio/mpeg">
</audio>

<script>

    function playNotification() {
        var x = document.getElementById("notification");
        x.loop = true;
        x.currentTime = 0;
        x.defaultMuted = false;
        x.play();
    }

    function stopNotification() {
        var x = document.getElementById("notification");
        x.currentTime = 0;
        x.pause();
    }

    $(document).ready(function(){
        $("#onshow").on('show.bs.modal', function () {
            playNotification();
        });

        $("#onshow").on('hidden.bs.modal', function(){
            stopNotification();
        });
    });

    function notificate() {
        $('#onshow').modal('show');
    }
</script>

<script>

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.response);
    document.getElementById("reservations").innerHTML = myObj.reservation;
    document.getElementById("orders").innerHTML = myObj.order;
    if (myObj.order > 0) {
        notificate();
    }
}
};
xmlhttp.open("GET", 'http://localhost/withadmin/public/api/notification/{{ Auth::user()->restaurantid }}', false);
xmlhttp.send();

window.setInterval(function(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.response);
    document.getElementById("reservations").innerHTML = myObj.reservation;
    document.getElementById("orders").innerHTML = myObj.order;
}
};
xmlhttp.open("GET", 'http://localhost/withadmin/public/api/notification/{{ Auth::user()->restaurantid }}', true);
xmlhttp.send();
}, 15000);


window.setInterval(function(){
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
    var myObj = JSON.parse(this.response);

    if (myObj.order > 0) {
        notificate();
    }
}
};
xmlhttp.open("GET", 'http://localhost/withadmin/public/api/notification/{{ Auth::user()->restaurantid }}', true);
xmlhttp.send();
}, 60000);

setTimeout(function() {
  location.reload();
}, 600000);


</script>
@endif
