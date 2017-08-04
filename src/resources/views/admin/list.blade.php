@extends('boilerplate::layout.index', [
    'title' => __('boilerplate_tracks::admin.main_title'),

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
                    <th>{{ __('boilerplate_tracks::admin.list.tbl_type') }}</th>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/fr.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.15/dataRender/ellipsis.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.15/dataRender/datetime.js"></script>
    <script>
        jQuery.fn.dataTable.render.expand = function () {

            return function (d, type, row) {
                // Order, search and type get the original data
                if (type !== 'display') {
                    return d;
                }
                if (typeof d !== 'string') {
                    return d;
                }
                return '<div class="expandable">' +
                    '<button class="btn btn-default btn-xs">' +
                    '<i class="fa fa-expand"></i>&nbsp;{{ __('boilerplate_tracks::admin.list.details_button') }}</button>' +
                    '<div class="expandable-data">' + d + '</div>' +
                    '</div>';
            };
        };

        (function ($) {
            $(document).on('click', '.expandable button', function (e) {
                // Show modal window
                let $data = $(this).next('.expandable-data').html();
                bootbox.dialog({
                    title: '{{ __('boilerplate_tracks::admin.list.details') }}',
                    message: $data,
                    width: '500px',
                });
            });
        })(jQuery);

    </script>
    <script>
        $(function () {
            oTable = $('#tracks-table').DataTable({
                columnDefs: [
                    {
                        targets: 4,
                        render: $.fn.dataTable.render.ellipsis(40, false)
                    },
                    {
                        targets: 1,
                        render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'Do MMM YY à HH:mm', 'fr')
                    },
                    {
                        targets: 5,
                        render: $.fn.dataTable.render.expand()
                    }
                ],
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
                    {data: 'type', name: 'type', sortable: false},
                    {data: 'ref_title', name: 'ref_title', sortable: false},
                    {data: 'description', name: 'description', sortable: false},
                ]
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .tracks-field {
            font-weight: bold;
            text-decoration: underline;
            text-transform: capitalize;
            margin-top: 10px;
        }

        .tracks-diff {
            max-width: 300px;
        }

        .bootbox-body .tracks-diff {
            max-width: 100%;
        }

        @media (min-width: 768px) {
            .modal-dialog {
                width: 900px !important;
            }
        }

        .DifferencesSideBySide {
            width: 100%;
        }

        .DifferencesSideBySide del {
            background-color: #ffc8c3;
        }

        .DifferencesSideBySide ins {
            background-color: #d4ffbd;
        }

        .DifferencesSideBySide thead {
            display: none;
        }

        .DifferencesSideBySide tr th {
            width: 5%;
            vertical-align: top;
            text-align: center;
        }
        .DifferencesSideBySide tr td {
            width: 45%;
        }

        .dataTable .expandable {
            height: 23px;
            overflow-y: hidden;
        }

        .dataTable .expandable button {
            float: right;
            margin: 0;
        }
    </style>
@endpush
