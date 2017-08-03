@extends('boilerplate::layout.index', [
    'title' => __('boilerplate_tracks::admin.list.title'),

])

@section('content')
    <div class="row">
        <div class="col-sm-12 mbl">
            <span class="btn-group pull-right">

            </span>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">{{ __('boilerplate_tracks::admin.list.title') }}</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-hover va-middle" id="tracks-table">
                <thead>
                <tr>
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_id') }}</th>
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_date') }}</th>
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_user') }}</th>
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_action') }}</th>
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_title') }}</th>
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_description') }}</th>
                    {{--<th></th>--}}
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@include('boilerplate::load.datatables')

@push('js')
    <script>
        $(function () {
            oTable = $('#tracks-table').DataTable({
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{!! route('tracks.index_xhr_dt') !!}',
                    type: 'post',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                order: [[1, "desc"]],
                columns: [
                    {data: 'id', name: 'id', visible: false},
                    {data: 'created_at', name: 'created_at', visible: true},
                    {data: 'user_id', name: 'user_id', sortable: false},
                    {data: 'action', name: 'action', sortable: false},
                    {data: 'ref_title', name: 'ref_title', sortable: false},
                    {data: 'description', name: 'description', sortable: false},
                ]
            });

            $('#users-table').on('click', '.destroy', function (e) {
                e.preventDefault();

                var href = $(this).attr('href');

                bootbox.confirm("{{ __('boilerplate::users.list.confirmdelete') }}", function (result) {
                    if (result === false) return;

                    $.ajax({
                        url: href,
                        method: 'delete',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        success: function () {
                            oTable.ajax.reload();
                            growl("{{ __('boilerplate::users.list.deletesuccess') }}", "success");
                        }
                    });
                });
            });
        });
    </script>
@endpush

@push('css')
    <style>
        #tracks-table tr td:last-child div {
            font-family: monospace;
            font-size: small;
            white-space: pre;
            padding: 5px;
            border: 1px solid lightgray;
            border-radius: 5px;
        }
    </style>
@endpush
