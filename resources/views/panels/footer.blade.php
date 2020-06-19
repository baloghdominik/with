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
