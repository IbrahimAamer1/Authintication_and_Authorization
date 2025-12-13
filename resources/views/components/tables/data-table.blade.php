@props([
    'headers' => [],
    'data' => [],
    'actions' => ['show', 'edit', 'delete'],
    'emptyMessage' => 'No data available',
    'pagination' => null,
    'class' => ''
])

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-nowrap font-size-14 {{ $class }}">
                <thead class="bg-light">
                    <tr>
                        @foreach($headers as $header)
                            <th class="text-primary">{{ is_array($header) ? $header['label'] : $header }}</th>
                        @endforeach
                        @if(count($actions) > 0)
                            <th class="text-primary" width="11%">{{ __('lang.actions') ?? 'Actions' }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        @foreach($data as $item)
                            <tr>
                                @foreach($headers as $key => $header)
                                    @php
                                        $field = is_array($header) ? $header['field'] : $key;
                                        $value = is_object($item) ? $item->$field : ($item[$field] ?? '');
                                    @endphp
                                    <td>{{ $value }}</td>
                                @endforeach
                                @if(count($actions) > 0)
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ __('lang.actions') ?? 'Actions' }} <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if(in_array('show', $actions))
                                                    <a href="#" class="dropdown-item displayClass" data-title="{{ __('lang.show') ?? 'Show' }}" data-bs-toggle="modal" data-bs-target="#mainModal">
                                                        <span class="bx bx-show-alt"></span> {{ __('lang.show') ?? 'Show' }}
                                                    </a>
                                                @endif
                                                @if(in_array('edit', $actions))
                                                    <a href="#" class="dropdown-item editClass" data-title="{{ __('lang.edit') ?? 'Edit' }}" data-bs-toggle="modal" data-bs-target="#mainModal">
                                                        <span class="bx bx-edit-alt"></span> {{ __('lang.edit') ?? 'Edit' }}
                                                    </a>
                                                @endif
                                                @if(in_array('delete', $actions))
                                                    <a href="#" class="dropdown-item deleteClass" data-title="{{ __('lang.delete') ?? 'Delete' }}">
                                                        <span class="bx bx-trash-alt"></span> {{ __('lang.delete') ?? 'Delete' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($headers) + (count($actions) > 0 ? 1 : 0) }}" class="text-center">
                                <x-empty-state :message="$emptyMessage" />
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if($pagination)
            <div class="mt-3">
                {{ $pagination }}
            </div>
        @endif
    </div>
</div>

