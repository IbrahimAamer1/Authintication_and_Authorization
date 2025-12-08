@props(['modelName'])

<div class="card mb-3" id="filter-card">
    <div class="card-body">
        <form method="GET" action="{{ request()->url() }}" id="filter-form">
            @foreach (request()->except(['word', 'start', 'end', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            {{ $slot }}

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-search"></i> {{ __('lang.search') }}
                        </button>
                        <a href="{{ request()->url() }}" class="btn btn-light">
                            <i class="bx bx-reset"></i> {{ __('lang.reset') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
