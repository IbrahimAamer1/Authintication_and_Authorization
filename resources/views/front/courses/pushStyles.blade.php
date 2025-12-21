@push('styles')
    <style>
        .course-card {
            transition: transform 0.2s;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .course-card .card-img-top {
            transition: transform 0.2s;
        }
        .course-card:hover .card-img-top {
            transform: scale(1.05);
        }
    </style>
@endpush

