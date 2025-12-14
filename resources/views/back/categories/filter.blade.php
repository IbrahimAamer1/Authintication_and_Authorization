@php
    $modelName = App\Models\Category::class;
@endphp

<x-filteration :modelName="$modelName">
    <div class="row">
        <div class="col-md-6">
            <label class="label-filter">{{ __('lang.word') ?? 'Search' }}</label>
            <input type="text" name="word" class="form-control" placeholder="{{ __('lang.please_enter') ?? 'Enter' }} {{ __('lang.word') ?? 'keyword' }}" value="{{ request()->input('word') }}">
        </div>

        <div class="col-md-3">
            <label class="label-filter">{{ __('lang.status') ?? 'Status' }}</label>
            <select name="status" class="form-control">
                <option value="">{{ __('lang.all') ?? 'All' }}</option>
                <option value="1" @selected(request()->input('status') == '1')>{{ __('lang.active') ?? 'Active' }}</option>
                <option value="0" @selected(request()->input('status') == '0')>{{ __('lang.inactive') ?? 'Inactive' }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="label-filter">{{ __('lang.date') ?? 'Date' }}</label>
            <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                <input type="date" class="form-control" name="start" placeholder="{{ __('lang.date_from') ?? 'From' }}" value="{{ request()->input('start') }}"/>
                <input type="date" class="form-control" name="end" placeholder="{{ __('lang.date_to') ?? 'To' }}" value="{{ request()->input('end') }}"/>
            </div>
        </div>
    </div>
</x-filteration>

