<form action="{{ route('back.categories.update', ['category' => $category]) }}" method="post" id="edit_form" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div id="edit_form_messages"></div>

    <div class="row">
        @include('components.forms.input', [
            'name' => 'name',
            'label' => __('lang.name') ?? 'Name',
            'value' => old('name', $category->name),
            'required' => true,
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.input', [
            'name' => 'icon',
            'label' => __('lang.icon') ?? 'Icon',
            'value' => old('icon', $category->icon),
            'help' => 'Icon class name (e.g., bx-book)',
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.textarea', [
            'name' => 'description',
            'label' => __('lang.description') ?? 'Description',
            'value' => old('description', $category->description),
            'rows' => 3,
            'class' => 'col-12'
        ])

        @include('components.forms.file-upload', [
            'name' => 'image',
            'label' => __('lang.image') ?? 'Image',
            'value' => $category->image,
            'accept' => 'image/*',
            'preview' => true,
            'help' => 'Max size: 2MB. Leave empty to keep current image.',
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.input', [
            'name' => 'sort_order',
            'type' => 'number',
            'label' => __('lang.sort_order') ?? 'Sort Order',
            'value' => old('sort_order', $category->sort_order),
            'class' => 'col-12 col-md-6'
        ])

        <div class="form-group col-12 col-md-6 mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active_edit" value="1" @checked(old('is_active', $category->is_active))>
                <label class="form-check-label" for="is_active_edit">
                    {{ __('lang.is_active') ?? 'Is Active' }}
                </label>
            </div>
        </div>
    </div>

    <hr class="text-muted">

    <div class="form-group float-end">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') ?? 'Close' }}</button>
        <button type="button" class="btn btn-primary" id="submit_edit_form">
            {{ __('lang.submit') ?? 'Submit' }}
            @include('partials.shared.modals.spinner')
        </button>
    </div>
</form>

