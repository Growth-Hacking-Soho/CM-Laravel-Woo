@push('child-styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/b-print-2.0.1/r-2.2.9/datatables.min.css"/>
@endpush
@push('child-scripts')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/b-print-2.0.1/r-2.2.9/datatables.min.js"></script>

    <script>

        $.fn.dtUiFixes = function (dt) {
            let container = $("#table_length").addClass("d-flex justify-content-between p-0");

            container.append('<div class="p-0" id="filter"/>');
            container.append('<div class="p-0" id="search"/>');
            container.append('<div class="p-0" id="actions"/>');

            $("#table_length label").appendTo($("#filter"));
            $("#table_length select").removeClass("form-control-sm").removeClass('custom-select-sm');
            $("#table_filter .form-control-sm").removeClass("form-control-sm").attr("placeholder", "Buscar...").appendTo($("#search"));
            $("#table_filter").remove();
            $(".dt-buttons").appendTo($("#actions"));
            $(".dt-pre-buttons button").appendTo(".dt-buttons");
            $(".dt-pre-buttons").remove();

        }
        $.fn.delay = function (callback, ms) {
            let timer = 0;
            return function () {
                let context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }
        $.fn.boolBadgeRender = function (input, defaultValue, trueValue, falseValue) {

            let color = "warning";
            let value = defaultValue;
            switch (input) {
                case "1":
                case 1:
                case true:
                    color = "success";
                    value = trueValue;
                    break;
                case "0":
                case 0:
                case false:
                    color = "danger";
                    value = falseValue;
                    break;
                default:
                    break;
            }

            return `<span class="float-center badge badge-${color}">${value}</span>`;
        }
        $.fn.rangeBadgeRender = function (input, defaultValue, values, texts) {

            let color = "warning";
            let value = defaultValue;
            if (input === values[0]) {
                color = "success";
                value = texts[0];
            } else if (input === values[1]) {
                color = "danger";
                value = texts[1];
            }
            return `<span class="float-center badge badge-${color}">${value}</span>`;
        }

        $.fn.dateTimeRender = function (input, format = "DD/MM/YYYY", nullValue = '') {
            return input !== null ? moment(input).format(format) : nullValue;
        }
        $.fn.valueRender = function (input, warning, danger) {

            let color = "warning";

            if (input <= danger) color = "danger";
            else if (input <= warning) color = "warning";
            else color = "success";

            return `<span class="float-center badge badge-${color}">${input}</span>`;
        }
        $.fn.doSearchDelay = function (dt) {
            $('.dataTables_filter input').unbind().bind('input', (this.delay(function (e) {
                dt.search($(this).val()).draw();
            }, 400)));
            $('[name="table_length"]').removeClass("form-control-sm").removeClass("custom-select-sm").css("min-width", "6em");
        }

        let dataTableLangPath = '{{ asset('js/datatables/il8n/spanish.json') }}';
        let otroButtons = []
        let defaultButtons = [
            {
                extend: "excelHtml5",
                text: '<span class="btn-label"><i class="far fa-file-excel mr-2"></i></span>Excel',
                className: "btn btn-success btn-labeled",
                action: function (e, dt, button, config) {
                    Swal.fire({
                        title: 'Espere...',
                        text: "Este proceso puede tardar unos segundos dependiendo al número de registros que se desea exportar",
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        closeOnClickOutside: false,
                    });
                    let that = this;
                    setTimeout(function () {
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(that, e, dt, button, config);
                        Swal.close();
                    }, 1000);
                }
            },
            {
                extend: 'print',
                text: '<span class="btn-label"><i class="fas fa-print mr-2"></i></span>Imprimir',
                className: "btn btn-secondary btn-labeled",
                customize: function (win) {
                    $(win.document).css('background-image', 'none !important');
                    $(win.document.body).css('font-size', '10pt');
                }
            },
            {
                extend: 'pdf',
                text: '<span class="btn-label"><i class="fas fa-file-pdf mr-2"></i></span>PDF',
                className: "btn btn-danger btn-labeled",
                customize: function (win) {
                    /*$(win.document).css('background-image', 'none !important');*/
                    /*$(win.document.body).css('font-size', '10pt');*/
                }
            }
        ];
        let defaultLengthMenu = [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]];

    </script>

    @if(!App::environment('production'))
        <!-- Inicio Depuracion -->
        <style>
            .dt-debug {
                display: inline-block;
                padding: 0.25rem;
                position: fixed;
                top: 60%;
                right: 0;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
                z-index: 10;
                /* image replacement properties */
                overflow: hidden;
                white-space: nowrap;
                visibility: hidden;
                opacity: 0;
                -webkit-transition: opacity .3s 0s, visibility 0s .3s;
                -moz-transition: opacity .3s 0s, visibility 0s .3s;
                transition: opacity .3s 0s, visibility 0s .3s;
                background-color: gray;
                color: white;
            }

            .dt-debug::content {
                margin-top: 0.15rem;
            }

            .dt-debug:hover {
                color: white;
            }

            .dt-debug.dt-is-visible {
                visibility: visible;
                opacity: 1;
            }
        </style>
        <script>
            function datatableDebug() {
                let n = document.createElement('script');
                n.setAttribute('language', 'JavaScript');
                n.setAttribute('src', 'https://debug.datatables.net/debug.js');
                document.body.appendChild(n);
            }
        </script>
        <a class="dt-debug dt-is-visible shadow p-2" href="javascript:datatableDebug()">
            <i>
                <svg width="32" height="32" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bug"
                     class="svg-inline--fa fa-bug fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 512 512">
                    <path fill="currentColor"
                          d="M511.988 288.9c-.478 17.43-15.217 31.1-32.653 31.1H424v16c0 21.864-4.882 42.584-13.6 61.145l60.228 60.228c12.496 12.497 12.496 32.758 0 45.255-12.498 12.497-32.759 12.496-45.256 0l-54.736-54.736C345.886 467.965 314.351 480 280 480V236c0-6.627-5.373-12-12-12h-24c-6.627 0-12 5.373-12 12v244c-34.351 0-65.886-12.035-90.636-32.108l-54.736 54.736c-12.498 12.497-32.759 12.496-45.256 0-12.496-12.497-12.496-32.758 0-45.255l60.228-60.228C92.882 378.584 88 357.864 88 336v-16H32.666C15.23 320 .491 306.33.013 288.9-.484 270.816 14.028 256 32 256h56v-58.745l-46.628-46.628c-12.496-12.497-12.496-32.758 0-45.255 12.498-12.497 32.758-12.497 45.256 0L141.255 160h229.489l54.627-54.627c12.498-12.497 32.758-12.497 45.256 0 12.496 12.497 12.496 32.758 0 45.255L424 197.255V256h56c17.972 0 32.484 14.816 31.988 32.9zM257 0c-61.856 0-112 50.144-112 112h224C369 50.144 318.856 0 257 0z"></path>
                </svg>
            </i>
        </a>
        <!-- Fin Depuracion -->
    @endif

@endpush
