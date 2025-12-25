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

        // ==================== Review Form Functionality ====================
        
        // Interactive Star Rating - Initialize on page load
        function initializeStarRating() {
            $('.star-rating-input').each(function() {
                let currentRating = parseInt($(this).data('rating')) || 0;
                $(this).find('.star-icon').each(function() {
                    let starRating = parseInt($(this).data('star'));
                    if (starRating <= currentRating && currentRating > 0) {
                        $(this).removeClass('bx-star text-muted').addClass('bxs-star text-warning');
                    } else {
                        $(this).removeClass('bxs-star text-warning').addClass('bx-star text-muted');
                    }
                });
            });
        }
        
        // Initialize on page load
        initializeStarRating();

        $(document).on('mouseenter', '.star-rating-input .star-icon', function() {
            let rating = parseInt($(this).data('star'));
            let container = $(this).closest('.star-rating-input');
            
            // Highlight stars up to hovered star
            container.find('.star-icon').each(function() {
                let starRating = parseInt($(this).data('star'));
                if (starRating <= rating) {
                    $(this).removeClass('bx-star text-muted').addClass('bxs-star text-warning');
                } else {
                    $(this).removeClass('bxs-star text-warning').addClass('bx-star text-muted');
                }
            });
        });

        $(document).on('mouseleave', '.star-rating-input', function() {
            let currentRating = parseInt($(this).data('rating')) || 0;
            let container = $(this);
            
            // Restore to current rating
            container.find('.star-icon').each(function() {
                let starRating = parseInt($(this).data('star'));
                if (starRating <= currentRating && currentRating > 0) {
                    $(this).removeClass('bx-star text-muted').addClass('bxs-star text-warning');
                } else {
                    $(this).removeClass('bxs-star text-warning').addClass('bx-star text-muted');
                }
            });
        });

        $(document).on('click', '.star-rating-input .star-icon', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            let rating = parseInt($(this).data('star'));
            let container = $(this).closest('.star-rating-input');
            let form = container.closest('form');
            let input = form.find('#rating-input');
            
            console.log('Star clicked:', rating);
            console.log('Container found:', container.length > 0);
            console.log('Form found:', form.length > 0);
            console.log('Input found:', input.length > 0);
            
            // Update data attribute and input value
            container.data('rating', rating);
            if (input.length) {
                input.val(rating);
                console.log('Rating set to:', input.val());
            } else {
                console.error('Rating input not found!');
            }
            
            // Update visual stars with animation
            container.find('.star-icon').each(function() {
                let starRating = parseInt($(this).data('star'));
                if (starRating <= rating) {
                    $(this).removeClass('bx-star text-muted').addClass('bxs-star text-warning');
                } else {
                    $(this).removeClass('bxs-star text-warning').addClass('bx-star text-muted');
                }
            });
            
            // Clear error
            if (form.length) {
                form.find('#rating-error').text('').hide();
            }
            container.removeClass('is-invalid');
            
            // Visual feedback
            container.find('.star-icon').css('transform', 'scale(1.1)');
            setTimeout(function() {
                container.find('.star-icon').css('transform', 'scale(1)');
            }, 200);
        });

        // Character counter for comment
        $(document).on('input', '#comment', function() {
            let length = $(this).val().length;
            $('#char-count').text(length);
            
            if (length > 1000) {
                $(this).val($(this).val().substring(0, 1000));
                $('#char-count').text(1000);
            }
        });

        // Submit Review Form (Create)
        $(document).on('submit', '#add-review-form', function(e) {
            e.preventDefault();
            
            console.log('Form submitted');
            
            let form = $(this);
            let submitBtn = form.find('#submit-btn');
            let originalText = submitBtn.html();
            
            // Validate rating
            let rating = parseInt(form.find('#rating-input').val()) || 0;
            console.log('Rating value:', rating);
            
            if (!rating || rating < 1 || rating > 5) {
                console.error('Invalid rating:', rating);
                form.find('#rating-error').text('{{ __("lang.rating_required") ?? "Please select a rating" }}').show();
                form.find('.star-rating-input').addClass('is-invalid');
                return false;
            }
            
            // Clear any previous errors
            $('#rating-error').text('').hide();
            $('#comment-error').text('').hide();
            form.find('.star-rating-input').removeClass('is-invalid');
            
            // Disable submit button
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> {{ __("lang.submitting") ?? "Submitting..." }}');
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val()
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showAlert('success', response.success);
                        
                        // Reload page to show updated reviews
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    let errorMessage = '{{ __("lang.error_occurred") ?? "An error occurred" }}';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.rating) {
                            $('#rating-error').text(errors.rating[0]).show();
                            form.find('.star-rating-input').addClass('is-invalid');
                        }
                        if (errors.comment) {
                            $('#comment-error').text(errors.comment[0]).show();
                            form.find('#comment').addClass('is-invalid');
                        }
                        if (errors.course || errors.review) {
                            errorMessage = Object.values(errors).flat().join(', ');
                        }
                    }
                    
                    if (errorMessage !== '{{ __("lang.error_occurred") ?? "An error occurred" }}') {
                        showAlert('danger', errorMessage);
                    }
                }
            });
        });

        // Update Review Form (Edit)
        $(document).on('submit', '#edit-review-form', function(e) {
            e.preventDefault();
            
            let form = $(this);
            let submitBtn = form.find('#submit-btn');
            let originalText = submitBtn.html();
            
            // Validate rating
            let rating = form.find('#rating-input').val();
            if (!rating || rating < 1 || rating > 5) {
                $('#rating-error').text('{{ __("lang.rating_required") ?? "Please select a rating" }}');
                return false;
            }
            
            // Disable submit button
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> {{ __("lang.updating") ?? "Updating..." }}');
            
            // Get form data and method
            let formData = form.serialize();
            let method = form.find('input[name="_method"]').val() || 'POST';
            
            $.ajax({
                url: form.attr('action'),
                method: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showAlert('success', response.success);
                        
                        // Reload page to show updated reviews
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalText);
                    
                    let errorMessage = '{{ __("lang.error_occurred") ?? "An error occurred" }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.rating) {
                            $('#rating-error').text(errors.rating[0]);
                        }
                        if (errors.comment) {
                            $('#comment-error').text(errors.comment[0]);
                        }
                        if (errors.course || errors.review) {
                            errorMessage = Object.values(errors).flat().join(', ');
                        }
                    }
                    
                    if (errorMessage !== '{{ __("lang.error_occurred") ?? "An error occurred" }}') {
                        showAlert('danger', errorMessage);
                    }
                }
            });
        });

        // Delete Review
        $(document).on('click', '#delete-btn', function(e) {
            e.preventDefault();
            
            if (!confirm('{{ __("lang.confirm_delete_review") ?? "Are you sure you want to delete your review?" }}')) {
                return;
            }
            
            let deleteBtn = $(this);
            let originalText = deleteBtn.html();
            let courseSlug = deleteBtn.data('course-slug');
            let reviewId = deleteBtn.data('review-id');
            
            // Disable delete button
            deleteBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> {{ __("lang.deleting") ?? "Deleting..." }}');
            
            $.ajax({
                url: '/front/courses/' + courseSlug + '/reviews/' + reviewId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showAlert('success', response.success);
                        
                        // Reload page to show updated reviews
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    deleteBtn.prop('disabled', false).html(originalText);
                    
                    let errorMessage = '{{ __("lang.error_occurred") ?? "An error occurred" }}';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    
                    showAlert('danger', errorMessage);
                }
            });
        });

        // Edit Review Button (from reviews list)
        $(document).on('click', '.edit-review-btn', function(e) {
            e.preventDefault();
            
            let reviewId = $(this).data('review-id');
            let rating = $(this).data('rating');
            let comment = $(this).data('comment');
            
            // Hide add review form if exists
            $('#add-review-section').hide();
            
            // Show edit review form
            let editForm = $('#edit-review-section');
            if (editForm.length) {
                editForm.show();
                
                // Update form values
                editForm.find('#rating-input').val(rating);
                editForm.find('#comment').val(comment);
                editForm.find('#char-count').text(comment.length);
                
                // Update star display
                let starContainer = editForm.find('.star-rating-input');
                starContainer.data('rating', rating);
                starContainer.find('.star-icon').each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('bx-star').addClass('bxs-star text-warning');
                    } else {
                        $(this).removeClass('bxs-star text-warning').addClass('bx-star text-muted');
                    }
                });
                
                // Scroll to form
                $('html, body').animate({
                    scrollTop: editForm.offset().top - 100
                }, 500);
            }
        });

        // Helper function to show alerts
        function showAlert(type, message) {
            let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            let icon = type === 'success' ? 'bx-check-circle' : 'bx-error-circle';
            
            let alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                '<i class="bx ' + icon + '"></i> ' + message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                '</div>';
            
            // Remove existing alerts
            $('.alert').remove();
            
            // Add new alert at top of reviews section
            $('#reviews-list-section').before(alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
</script>
@endpush

