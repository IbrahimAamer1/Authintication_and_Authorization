<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered">
            <tr>
                <th width="30%">{{ __('lang.user') ?? 'User' }}</th>
                <td>
                    @if($enrollment->user)
                        <div>
                            <strong>{{ $enrollment->user->name }}</strong><br>
                            <small class="text-muted">{{ $enrollment->user->email }}</small>
                        </div>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.course') ?? 'Course' }}</th>
                <td>
                    @if($enrollment->course)
                        <span class="badge bg-label-info">{{ $enrollment->course->title }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.status') ?? 'Status' }}</th>
                <td>
                    @if($enrollment->status == 'enrolled')
                        <span class="badge bg-label-primary">{{ __('lang.enrolled') ?? 'Enrolled' }}</span>
                    @elseif($enrollment->status == 'completed')
                        <span class="badge bg-label-success">{{ __('lang.completed') ?? 'Completed' }}</span>
                    @else
                        <span class="badge bg-label-danger">{{ __('lang.cancelled') ?? 'Cancelled' }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.progress') ?? 'Progress' }}</th>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="progress" style="width: 200px; height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%" aria-valuenow="{{ $enrollment->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $enrollment->progress_percentage }}%
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>{{ __('lang.enrolled_at') ?? 'Enrolled At' }}</th>
                <td>{{ $enrollment->enrolled_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @if($enrollment->completed_at)
            <tr>
                <th>{{ __('lang.completed_at') ?? 'Completed At' }}</th>
                <td>{{ $enrollment->completed_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @endif
            <tr>
                <th>{{ __('lang.created_at') ?? 'Created At' }}</th>
                <td>{{ $enrollment->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            <tr>
                <th>{{ __('lang.updated_at') ?? 'Updated At' }}</th>
                <td>{{ $enrollment->updated_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>
</div>

