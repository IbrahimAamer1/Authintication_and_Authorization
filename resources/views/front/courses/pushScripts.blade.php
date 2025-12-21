@push('scripts')
<script>
    $(document).ready(function() {
        // Enroll Now Button
        $(document).on('click', '#enrollBtn', function(e) {
            e.preventDefault();
            let courseId = $(this).data('course-id');
            let button = $(this);
            
            if (!courseId) {
                alert('{{ __("lang.error_occurred") ?? "An error occurred" }}');
                return;
            }

            // Disable button
            button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> {{ __("lang.enrolling") ?? "Enrolling..." }}');

            $.ajax({
                url: '{{ route("front.enrollments.store") }}',
                method: 'POST',
                data: {
                    course_id: courseId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        button.closest('.card-body').prepend(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="bx bx-check-circle"></i> ' + response.success +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '</div>'
                        );
                        
                        // Replace button with success message
                        setTimeout(function() {
                            button.replaceWith(
                                '<div class="alert alert-success">' +
                                '<i class="bx bx-check-circle"></i> {{ __("lang.already_enrolled") ?? "You are already enrolled in this course" }}' +
                                '</div>' +
                                '<a href="{{ route("front.enrollments.index") }}" class="btn btn-success w-100">' +
                                '{{ __("lang.continue_learning") ?? "Continue Learning" }}' +
                                '</a>'
                            );
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    button.prop('disabled', false).html('<i class="bx bx-plus-circle"></i> {{ __("lang.enroll_now") ?? "Enroll Now" }}');
                    
                    let errorMessage = '{{ __("lang.error_occurred") ?? "An error occurred" }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                    
                    button.closest('.card-body').prepend(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        errorMessage +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                }
            });
        });
    });
</script>
@endpush

