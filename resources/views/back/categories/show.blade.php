<div class="row">
    <div class="col-md-4">
        @if($category->image)
            <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="img-fluid rounded mb-3">
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
                <th width="30%">{{ __('lang.name') ?? 'Name' }}</th>
                <td>{{ $category->name }}</td>
            </tr>
            @if($category->icon)
            <tr>
                <th>{{ __('lang.icon') ?? 'Icon' }}</th>
                <td><i class="{{ $category->icon }}"></i> {{ $category->icon }}</td>
            </tr>
            @endif
            @if($category->description)
            <tr>
                <th>{{ __('lang.description') ?? 'Description' }}</th>
                <td>{{ $category->description }}</td>
            </tr>
            @endif
            <tr>
                <th>{{ __('lang.sort_order') ?? 'Sort Order' }}</th>
                <td>{{ $category->sort_order }}</td>
            </tr>
            <tr>
                <th>{{ __('lang.status') ?? 'Status' }}</th>
                <td>
                    @if($category->is_active)
                        <span class="badge bg-label-success">{{ __('lang.active') ?? 'Active' }}</span>
                    @else
                        <span class="badge bg-label-danger">{{ __('lang.inactive') ?? 'Inactive' }}</span>
                    @endif
                </td>
        </table>
    </div>
</div>

