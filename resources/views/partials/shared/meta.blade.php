<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

@if(isset($metaDescription))
<meta name="description" content="{{ $metaDescription }}" />
@else
<meta name="description" content="{{ config('app.name', 'E-Learning Platform') }}" />
@endif

@if(isset($metaKeywords))
<meta name="keywords" content="{{ $metaKeywords }}" />
@endif

@if(isset($metaAuthor))
<meta name="author" content="{{ $metaAuthor }}" />
@endif

