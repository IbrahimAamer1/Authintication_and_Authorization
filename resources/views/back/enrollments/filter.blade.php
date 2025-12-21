@php
    $modelName = App\Models\Enrollment::class;
@endphp

<x-filteration :modelName="$modelName">
    <div class="row">
        <div class="col-md-4">
            <label class="label-filter">{{ __('lang.word') ?? 'Search' }}</label>
            <input type="text" name="word" class="form-control" placeholder="{{ __('lang.please_enter') ?? 'Enter' }} {{ __('lang.word') ?? 'keyword' }}" value="{{ request()->input('word') }}">
        </div>

        <div class="col-md-2">
            <label class="label-filter">{{ __('lang.user') ?? 'User' }}</label>
            <select name="user_id" class="form-control">
                <option value="">{{ __('lang.all') ?? 'All' }}</option>
                @foreach($users ?? [] as $user)
                    <option value="{{ $user->id }}" @selected(request()->input('user_id') == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="label-filter">{{ __('lang.course') ?? 'Course' }}</label>
            <select name="course_id" class="form-control">
                <option value="">{{ __('lang.all') ?? 'All' }}</option>
                @foreach($courses ?? [] as $course)
                    <option value="{{ $course->id }}" @selected(request()->input('course_id') == $course->id)>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="label-filter">{{ __('lang.status') ?? 'Status' }}</label>
            <select name="status" class="form-control">
                <option value="">{{ __('lang.all') ?? 'All' }}</option>
                <option value="enrolled" @selected(request()->input('status') == 'enrolled')>{{ __('lang.enrolled') ?? 'Enrolled' }}</option>
                <option value="completed" @selected(request()->input('status') == 'completed')>{{ __('lang.completed') ?? 'Completed' }}</option>
                <option value="cancelled" @selected(request()->input('status') == 'cancelled')>{{ __('lang.cancelled') ?? 'Cancelled' }}</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="label-filter">{{ __('lang.date') ?? 'Date' }}</label>
            <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                <input type="date" class="form-control" name="start" placeholder="{{ __('lang.date_from') ?? 'From' }}" value="{{ request()->input('start') }}"/>
                <input type="date" class="form-control" name="end" placeholder="{{ __('lang.date_to') ?? 'To' }}" value="{{ request()->input('end') }}"/>
            </div>
        </div>
    </div>
</x-filteration>

