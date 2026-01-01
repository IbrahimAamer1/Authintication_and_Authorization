@push('scripts')
<script>
    $(document).ready(function() {
        //============================================= LOADER
        var $loading = $('#loading').hide();
        $(document)
            .ajaxStart(function() {
                $loading.show();
            })
            .ajaxStop(function() {
                $loading.hide();
            });

        //============================================= SCRIPT FOR DISPLAYING RECORD DETAILS ON MODAL (if needed)
        $(document).on('click', ".displayClass", function(e) {
            e.preventDefault();
            let formAction = $(this).attr("href");
            let title = $(this).attr("data-title");
            $("#modal-title").html(title);
            $.ajax({
                url: formAction,
                method: "get",
                success: function(data) {
                    $("#modal-body").html(data);
                },
                error: function() {
                    alert("failed .. Please try again !");
                }
            });
        });
        
        // Ensure Bootstrap dropdowns work
        if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
            // Bootstrap 5
            document.querySelectorAll('.dropdown-toggle').forEach(function(element) {
                try {
                    new bootstrap.Dropdown(element);
                } catch(e) {
                    console.log('Dropdown already initialized or error:', e);
                }
            });
        } else if (typeof $ !== 'undefined' && $.fn.dropdown) {
            // Bootstrap 4 fallback
            $('.dropdown-toggle').dropdown();
        }
    });
</script>
@endpush

