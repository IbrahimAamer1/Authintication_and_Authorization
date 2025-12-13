<form action="{{ route('back.users.store') }}" method="post" id="add_form" enctype="multipart/form-data">
    @csrf

    <div id="add_form_messages"></div>

    <div class="row">
        @include('components.forms.input', [
            'name' => 'name',
            'label' => __('lang.name'),
            'value' => old('name'),
            'required' => true,
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.input', [
            'name' => 'email',
            'type' => 'email',
            'label' => __('lang.email'),
            'value' => old('email'),
            'required' => true,
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.input', [
            'name' => 'password',
            'type' => 'password',
            'label' => __('lang.password'),
            'required' => true,
            'class' => 'col-12 col-md-6'
        ])

        @include('components.forms.input', [
            'name' => 'password_confirmation',
            'type' => 'password',
            'label' => __('lang.password_confirmation'),
            'required' => true,
            'class' => 'col-12 col-md-6'
        ])
    </div>

    <div class="form-group float-right mt-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.close') }}</button>
        <button type="button" class="btn btn-primary" id="submit_add_form">
            {{ __('lang.submit') }}
            @include('partials.shared.modals.spinner')
        </button>
    </div>
</form>