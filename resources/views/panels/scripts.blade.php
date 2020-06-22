    {{-- Vendor Scripts --}}
        <script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
        
        @yield('vendor-script')
        {{-- Theme Scripts --}}
        <script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
        <script src="{{ asset(mix('js/core/app.js')) }}"></script>
        <script src="{{ asset(mix('js/scripts/components.js')) }}"></script>
        <script>

(function(window, document, $) {
'use strict';
    $('[data-toggle="popover"]').popover();


    /******************/
    // Popover events //
    /******************/

    // onShow event
    $('#show-popover').popover({
        title: 'Popover Show Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'right'
        }).on('show.bs.popover', function() {
            alert('Show event fired.');
    });

    // onShown event
    $('#shown-popover').popover({
        title: 'Popover Shown Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'bottom'
    }).on('shown.bs.popover', function() {
        alert('Shown event fired.');
    });

    // onHide event
    $('#hide-popover').popover({
        title: 'Popover Hide Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'bottom'
    }).on('hide.bs.popover', function() {
        alert('Hide event fired.');
    });

    // onHidden event
    $('#hidden-popover').popover({
        title: 'Popover Hidden Event',
        content: 'Bonbon chocolate cake. Pudding halvah pie apple pie topping marzipan pastry marzipan cupcake.',
        trigger: 'click',
        placement: 'left'
    }).on('hidden.bs.popover', function() {
        alert('Hidden event fired.');
    });

    /*******************/
    // Tooltip methods //
    /*******************/

    // Show method
    $('#show-method').on('click', function() {
        $(this).popover('show');
    });
    // Hide method
    $('#hide-method').on('mouseenter', function() {
        $(this).popover('show');
    });
    $('#hide-method').on('click', function() {
        $(this).popover('hide');
    });
    // Toggle method
    $('#toggle-method').on('click', function() {
        $(this).popover('toggle');
    });
    // Dispose method
    $('#dispose').on('click', function() {
        $('#dispose-method').popover('dispose');
    });


    /* Trigger*/
    $('.manual').on('click', function() {
        $(this).popover('show');
    });
    $('.manual').on('mouseout', function() {
        $(this).popover('hide');
    });

    /****************/
    // Custom color //
    /****************/
    $('[data-popup=popover-color]').popover({
        template: '<div class="popover"><div class="bg-teal"><div class="popover-arrow"></div><div class="popover-inner"></div></div></div>'
    });

    /**********************/
    // Custom borer color //
    /**********************/
    $('[data-popup=popover-border]').popover({
        template: '<div class="popover"><div class="border-orange"><div class="popover-arrow"></div><div class="popover-inner"></div></div></div>'
    });

})(window, document, jQuery);
        </script>
        
@if($configData['blankPage'] == false)
        <script src="{{ asset(mix('js/scripts/footer.js')) }}"></script>
@endif
        {{-- page script --}}
        @yield('page-script')
