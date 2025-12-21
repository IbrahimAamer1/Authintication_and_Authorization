@push('scripts')
<script>
    $(document).ready(function() {
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
        
        if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
            document.querySelectorAll('.dropdown-toggle').forEach(function(element) {
                try {
                    new bootstrap.Dropdown(element);
                } catch(e) {
                    console.log('Dropdown already initialized or error:', e);
                }
            });
        } else if (typeof $ !== 'undefined' && $.fn.dropdown) {
            $('.dropdown-toggle').dropdown();
        }
    });
</script>
@endpush

