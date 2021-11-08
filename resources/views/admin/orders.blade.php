@extends('layouts.gifts')

@section('styles')
<style>
    tbody {
        font-weight: 600;
    }
</style>
@endsection

@section('content')

    <div>
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Orden</th>
                <th>Estado</th>
                <th>Enviado</th>
                <th>Creacion</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->send ? 'Si' : 'No' }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@include('components.datatable')

{{-- @section('scripts')
    <script>
        let dt = null;

        function reHandle() {
        }

        $(document).ready(function () {
            dt = $('#example').DataTable({
                dom: 'lBfrtip',
                responsive: true,
                serverSide: true,
                processing: false,
                paging: true,
                info: true,
                search: {
                    caseInsensitive: true
                },
                ajax: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('api.gift.data') }}",
                    type: 'POST',
                    contentType: "application/json",
                    data: function (d) {
                        return JSON.stringify(d);
                    }
                },
                columns: [
                    {data: "name"},
                    {data: "sku"},
                    {data: "email", "defaultContent": "<i>No especificado</i>"},
                    {data: "phone", "defaultContent": "<i>No especificado</i>"},
                    {data: "order_id"},
                    {data: "message"},
                    {
                        data: "video", "render": function (data, type, row, meta) {
                            if (type === 'display') {
                                data = '<a href="/gift/play/' + row['key'] + '">' + 'ver' + '</a>';
                            }
                            return data;
                        }
                    },
                    {data: "counter"},
                    {
                        data: null, "defaultContent": "<i>No especificado</i>", render: function (data, type, row, meta) {
                            if (data.status == 'send') {
                                return 'Enviado'
                            }
                            if (data.status == 'draft') {
                                return 'Borrador'
                            }
                            if (data.status == 'open') {
                                return 'Visto'
                            }
                        }
                    },
                    {data: "first_open_at"},
                    {data: "last_open_at"},
                    {data: "created_at"},
                ],
                initComplete: function () {
                    reHandle();
                    $(this).doSearchDelay(dt);
                    $(this).dtUiFixes(dt);
                    dt.columns.adjust();
                }
            });
            dt.on('draw.dt', function () {
                reHandle();
            });
        });
    </script>
@endsection --}}
