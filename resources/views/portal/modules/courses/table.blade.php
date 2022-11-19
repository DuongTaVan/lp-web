<table>
    @section('styles')
        <style>
            th {
                min-width: 130px;
            }
        </style>
    @endsection
    <tr>
        <th id="updated_at">
            <div class="d-flex justify-content-between f-w6 fields">
                申請 日
                <div class="created_at">
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'created_at' && Request::get('sort_by') === 'DESC') active @endif"
                       data-sort="created_at">
                    </i>
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'created_at' && Request::get('sort_by') === 'ASC') active @endif"
                       data-sort="created_at"></i>
                </div>
            </div>
        </th>
        <th id="title">
            <div class="d-flex justify-content-between f-w6 fields">
                サービス名
                <div class="title">
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'title' && Request::get('sort_by') === 'DESC') active @endif"
                       data-sort="title">
                    </i>
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'title' && Request::get('sort_by') === 'ASC') active @endif"
                       data-sort="title"></i>
                </div>
            </div>
        </th>
        <th id="full_name">
            <div class="d-flex justify-content-between f-w6 fields">
                出品者
                <div class="full_name_user">
                    <i
                        class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'full_name_user' && Request::get('sort_by') === 'DESC') active @endif"
                        data-sort="full_name">
                    </i>
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'full_name_user' && Request::get('sort_by') === 'ASC') active @endif"
                       data-sort="full_name"></i>
                </div>
            </div>
        </th>
        <th>
            <div class="d-flex justify-content-center f-w6 fields">
                サブカテゴリ

            </div>
        </th>
        <th class="course_status">
            <div class="d-flex justify-content-center f-w6 fields">
                ステータス

            </div>
        </th>
        <th>
            <div class="d-flex justify-content-center f-w6 fields">
                申請サービス

            </div>
        </th>
        <th class="course_status">
            <div class="d-flex justify-content-center f-w6 fields">
                結果通知

            </div>
        </th>
        <th id="admin_update_at">
            <div class="d-flex justify-content-between f-w6 fields">
                通知日
                <div class="admin_update_at">
                    <i class="fa fa-arrow-down sort-desc @if(Request::get('sort_column') === 'admin_update_at' && Request::get('sort_by') === 'DESC') active @endif"
                       data-sort="admin_update_at"></i>
                    <i class="fa fa-arrow-up sort-asc @if(Request::get('sort_column') === 'admin_update_at' && Request::get('sort_by') === 'ASC') active @endif"
                       data-sort="admin_update_at"></i>
                </div>
            </div>
        </th>
    </tr>
    <tbody class="content-table-data">
    @foreach($courses as $course)
        <tr id="{{ $course->course_id }}">
            <td style="max-width: 159px; min-width: 159px">{{ date_format(date_create($course->created_at), 'Y-m-d') }}</td>
            <td>{{ $course->title }}</td>
            <td>{{ $course->full_name_user }}</td>
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
    @endforeach
    </tbody>
</table>
