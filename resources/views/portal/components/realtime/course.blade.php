<tr id="{{ $course->course_id }}">
    <td style="max-width: 159px; min-width: 159px">{{ now()->parse($course->created_at)->format('Y-m-d') }}</td>
    <td>{{ $course->title }}</td>
    <td>{{ $course->user->full_name }}</td>
    <td class="text-center" style="max-width: 179px; min-width: 179px">{{ $course->category->name }}</td>
    <td class="text-center">
        @if($course->approval_status === \App\Enums\DBConstant::COURSE_NOT_REVIEW)
            <div class="not-view">承認待ち</div>
        @elseif($course->approval_status === \App\Enums\DBConstant::COURSE_APPROVED)
            <div class="approval">承認</div>
        @else
            <div class="reject">否認</div>
        @endif
    </td>
    @php
        $query = app('request')->request->all();
        $result = array_merge(['courseId' => $course->course_id], $query);
    @endphp
    <td class="text-center">
        <a class="btn btn-review btn-review-course-custom"
           href="{{ route('portal.courses.show', $result) }}">閲覧</a>
    </td>
    <td class="text-center">
        @if($course->approval_status === \App\Enums\DBConstant::COURSE_NOT_REVIEW)
        @else
            <div class="approval-notice">通知済み</div>
        @endif
    </td>
    <td class="text-center" style="min-width: 159px; max-width: 159px">
        @if($course->approval_status === \App\Enums\DBConstant::COURSE_NOT_REVIEW)
        @else
            <div>@if($course->admin_update_at){{ Carbon\Carbon::parse($course->admin_update_at)->format('Y-m-d') }}@endif</div>
        @endif
    </td>
</tr>
