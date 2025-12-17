<div class="row">
    <div class="col-md-4">
        @if($course->image)
            <img src="{{ $course->getImageUrl() }}" alt="{{ $course->title }}" class="img-fluid rounded mb-3">
        @else
            <div class="bg-light rounded p-5 text-center mb-3">
                <i class="bx bx-image display-4 text-muted"></i>
                <p class="text-muted mt-2">No Image</p>
            </div>
        @endif
    </div>
    <div class="col-md-8">
        <table class="table table-bordered">
            <tr>
                <th width="30%">{{ __('lang.title') ?? 'Title' }}</th>
                <td>{{ $course->title }}</td>
            </tr>
            <tr>
                <th>{{ __('lang.slug') ?? 'Slug' }}</th>
                <td>{{ $course->slug }}</td>
            </tr>
            <tr>
                <th>{{ __('lang.category') ?? 'Category' }}</th>
                <td>
                    @if($course->category)
                        <span class="badge bg-label-info">{{ $course->category->name }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.instructor') ?? 'Instructor' }}</th>
                <td>
                    @if($course->instructor)
                        {{ $course->instructor->name }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.level') ?? 'Level' }}</th>
                <td>
                    <span class="badge bg-label-{{ $course->getLevelBadgeColor() }}">
                        {{ ucfirst($course->level) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.price') ?? 'Price' }}</th>
                <td>
                    @if($course->hasDiscount())
                        <span class="text-decoration-line-through text-muted">{{ $course->price }}</span>
                        <span class="text-danger fw-bold ms-2">{{ $course->getFinalPrice() }}</span>
                        <span class="badge bg-label-danger ms-2">{{ $course->getDiscountPercentage() }}% {{ __('lang.off') ?? 'Off' }}</span>
                    @else
                        <span class="fw-bold">{{ $course->getFinalPrice() }}</span>
                    @endif
                </td>
            </tr>
            @if($course->duration)
            <tr>
                <th>{{ __('lang.duration') ?? 'Duration' }}</th>
                <td>{{ $course->getFormattedDuration() }}</td>
            </tr>
            @endif
            @if($course->language)
            <tr>
                <th>{{ __('lang.language') ?? 'Language' }}</th>
                <td>{{ strtoupper($course->language) }}</td>
            </tr>
            @endif
            <tr>
                <th>{{ __('lang.status') ?? 'Status' }}</th>
                <td>
                    @if($course->status == 'published')
                        <span class="badge bg-label-success">{{ __('lang.published') ?? 'Published' }}</span>
                    @else
                        <span class="badge bg-label-warning">{{ __('lang.draft') ?? 'Draft' }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.sort_order') ?? 'Sort Order' }}</th>
                <td>{{ $course->sort_order }}</td>
            </tr>
            @if($course->description)
            <tr>
                <th>{{ __('lang.description') ?? 'Description' }}</th>
                <td>{{ $course->description }}</td>
            </tr>
            @endif
            @if($course->meta_title)
            <tr>
                <th>{{ __('lang.meta_title') ?? 'Meta Title' }}</th>
                <td>{{ $course->meta_title }}</td>
            </tr>
            @endif
            @if($course->meta_description)
            <tr>
                <th>{{ __('lang.meta_description') ?? 'Meta Description' }}</th>
                <td>{{ $course->meta_description }}</td>
            </tr>
            @endif
            <tr>
                <th>{{ __('lang.created_at') ?? 'Created At' }}</th>
                <td>{{ $course->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <th>{{ __('lang.updated_at') ?? 'Updated At' }}</th>
                <td>{{ $course->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>
</div>