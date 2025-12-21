<form method="GET" action="{{ route('front.courses.index') }}" id="filterForm">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('lang.filters') ?? 'Filters' }}</h5>
        </div>
        <div class="card-body">
            <!-- Search -->
            <div class="mb-3">
                <label class="form-label">{{ __('lang.search') ?? 'Search' }}</label>
                <input type="text" name="word" class="form-control" placeholder="{{ __('lang.search_courses') ?? 'Search courses...' }}" value="{{ request('word') }}">
            </div>

            <!-- Category Filter -->
            <div class="mb-3">
                <label class="form-label">{{ __('lang.category') ?? 'Category' }}</label>
                <select name="category_id" class="form-select">
                    <option value="">{{ __('lang.all_categories') ?? 'All Categories' }}</option>
                    @if(isset($categories) && is_iterable($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Level Filter -->
            <div class="mb-3">
                <label class="form-label">{{ __('lang.level') ?? 'Level' }}</label>
                <select name="level" class="form-select">
                    <option value="">{{ __('lang.all_levels') ?? 'All Levels' }}</option>
                    <option value="beginner" @selected(request('level') == 'beginner')>{{ __('lang.beginner') ?? 'Beginner' }}</option>
                    <option value="intermediate" @selected(request('level') == 'intermediate')>{{ __('lang.intermediate') ?? 'Intermediate' }}</option>
                    <option value="advanced" @selected(request('level') == 'advanced')>{{ __('lang.advanced') ?? 'Advanced' }}</option>
                </select>
            </div>

            <!-- Price Filter -->
            <div class="mb-3">
                <label class="form-label">{{ __('lang.price') ?? 'Price' }}</label>
                <select name="price" class="form-select">
                    <option value="">{{ __('lang.all_prices') ?? 'All Prices' }}</option>
                    <option value="free" @selected(request('price') == 'free')>{{ __('lang.free') ?? 'Free' }}</option>
                    <option value="paid" @selected(request('price') == 'paid')>{{ __('lang.paid') ?? 'Paid' }}</option>
                </select>
            </div>

            <!-- Sort -->
            <div class="mb-3">
                <label class="form-label">{{ __('lang.sort_by') ?? 'Sort By' }}</label>
                <select name="sort" class="form-select">
                    <option value="latest" @selected(request('sort') == 'latest')>{{ __('lang.latest') ?? 'Latest' }}</option>
                    <option value="price_low" @selected(request('sort') == 'price_low')>{{ __('lang.price_low_to_high') ?? 'Price: Low to High' }}</option>
                    <option value="price_high" @selected(request('sort') == 'price_high')>{{ __('lang.price_high_to_low') ?? 'Price: High to Low' }}</option>
                    <option value="popular" @selected(request('sort') == 'popular')>{{ __('lang.most_popular') ?? 'Most Popular' }}</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">{{ __('lang.apply_filters') ?? 'Apply Filters' }}</button>
                <a href="{{ route('front.courses.index') }}" class="btn btn-outline-secondary">{{ __('lang.clear_filters') ?? 'Clear Filters' }}</a>
            </div>
        </div>
    </div>
</form>

