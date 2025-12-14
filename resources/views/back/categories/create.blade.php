<form action="{{ route('back.categories.store') }}" method="post" id="add_form" enctype="multipart/form-data">
    @csrf

    <div id="add_form_messages"></div>

    <div class="row">
        @include('components.forms.input', [
            'name' => 'name',
            'label' => __('lang.name') ?? 'Name',
            'value' => old('name'),
            'required' => true,
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.input', [
            'name' => 'icon',
            'label' => __('lang.icon') ?? 'Icon',
            'value' => old('icon'),
            'help' => 'Icon class name (e.g., bx-book)',
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.textarea', [
            'name' => 'description',
            'label' => __('lang.description') ?? 'Description',
            'value' => old('description'),
            'rows' => 3,
            'class' => 'col-12'
        ])

        @include('components.forms.file-upload', [
            'name' => 'image',
            'label' => __('lang.image') ?? 'Image',
            'accept' => 'image/*',
            'help' => 'Max size: 2MB',
            'class' => 'col-12 col-md-6'
        ])

        <div class="form-group col-12 col-md-6 mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))>
                <label class="form-check-label" for="is_active">
                    {{ __('lang.is_active') ?? 'Is Active' }}
                </label>
            </div>
        </div>
    </div>

    <hr class="text-muted">

    <div class="form-group float-end">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') ?? 'Close' }}</button>
        <button type="button" class="btn btn-primary" id="submit_add_form">
            {{ __('lang.submit') ?? 'Submit' }}
            @include('partials.shared.modals.spinner')
        </button>
    </div>
</form>

