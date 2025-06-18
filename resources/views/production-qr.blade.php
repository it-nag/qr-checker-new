@extends('layouts.index')

@section('custom-link')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{-- <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endsection

@section('content')
    {{-- <form id="form" name='form'> --}}
        <div class="card card-sb collapsed-card" id = "scan-qr-header">
            <div class="card-header" data-card-widget="collapse">
                <h5 class="card-title fw-bold mb-0"><i class="fas fa-hand-pointer"></i> Scan QR</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center align-items-end">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label label-input"><small><b>QR Code</b></small></label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm border-input" name="txtqr" id="txtqr" autocomplete="off" enterkeyhint="go" onkeyup="if (event.keyCode == 13) document.getElementById('scan_qr').click()" autofocus>
                                {{-- <input type="button" class="btn btn-sm btn-sb" value="Scan Line" /> --}}
                                {{-- style="display: none;" --}}
                                <button class="btn btn-sm btn-primary" type="button" id="scan_qr" onclick="scanqr()">Scan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div></div>
                    </div>
                    <div class="col-md-8">
                        <center>
                            {{-- <div id="reader_s"></div> --}}
                            <video id="scan-qr-nimic" style="max-width: 100%;max-height: 300px;"></video>
                        </center>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </div>
        </div>
    {{-- </form> --}}

    <div class="card card-sb">
        <div class="card-header">
            <h5 class="card-title fw-bold mb-0"><i class="fas fa-list"></i> Item Detail</h5>
        </div>
        <div class="card-body">
            <h3 class="text-sb fw-bold" id="label_kode_numbering">Label Kode Numbering</h3>
            <div class="row justify-content-center align-items-end">
                <div class="col-12 col-md-12">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Buyer</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtbuyer" id="txtbuyer" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Season</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtseason" id="txtseason" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Worksheet</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtws" id="txtws" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Style</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtstyle" id="txtstyle" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Color</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtcolor" id="txtcolor" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Size</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtsize" id="txtsize" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Dest</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtdest" id="txtdest" readonly>
                    </div>
                </div>
                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">Cutting</h5>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Cut Plan</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtcut_plan" id="txtcut_plan"
                            readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Form</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtno_form" id="txtno_form"
                            readonly>
                    </div>
                </div>
                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">DC</h5>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tanggal Loading</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txttgl_load" id="txttgl_load"
                            readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Line Loading</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtline_load" id="txtline_load"
                            readonly>
                    </div>
                </div>
                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <h5 class="text-sb fw-bold">Output</h5>
                <div class="col-12 col-md-12">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tgl Plan Sewing</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txttgl_plan_sew" id="txttgl_plan_sew" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Sewing Line</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtsew_line" id="txtsew_line" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Sewing In</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="sew_in" id="sew_in" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Packing Line</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtpack" id="txtpack" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Packing In</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="pack_in" id="pack_in" readonly>
                    </div>
                </div>
                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <div class="col-md-12" id="defect-output">
                    <h5 class="text-sb fw-bold">Defect QC</h5>
                    <div class="row">
                        <div class="col-3 col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect Sewing Line</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="defect_line" id="defect_line" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Status Defect</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="defect_status" id="defect_status" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Jenis Defect</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="defect_type" id="defect_type" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Alokasi</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="defect_allocation" id="defect_allocation" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect In</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="defect_in" id="defect_in" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect Out</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="defect_out" id="defect_out" readonly>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-sb-secondary">External</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect External</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="external" id="external" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect External Status</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="external_status" id="external_status" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect External IN</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="external_in" id="external_in" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect External OUT</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="external_out" id="external_out" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-top: 1px solid rgba(109, 109, 109, 1);">
                <div class="col-md-12" id="defect-output">
                    <h5 class="text-sb fw-bold">Defect Packing</h5>
                    <div class="row">
                        <div class="col-3 col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect Packing Line</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_defect_line" id="packing_defect_line" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Status Defect</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_defect_status" id="packing_defect_status" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Jenis Defect</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_defect_type" id="packing_defect_type" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Alokasi</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_defect_allocation" id="packing_defect_allocation" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect Packing In</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_defect_in" id="packing_defect_in" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Defect Packing Out</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_defect_out" id="packing_defect_out" readonly>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-sb-secondary">External</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Packing Defect External</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_external" id="packing_external" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Packing Defect External Status</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_external_status" id="packing_external_status" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Packing Defect External IN</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_external_in" id="packing_external_in" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label"><small><b>Packing Defect External OUT</b></small></label>
                                <input type="text" class="form-control form-control-sm" name="packing_external_out" id="packing_external_out" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="mb-3">
                        {{-- <label class="form-label"><small><b>Gambar</b></small></label> --}}
                        <img class="img-fluid" alt="" title="" id = "gambar" name = "gambar" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(async function() {
            $('#scan-qr-header').on('expanded.lte.cardwidget', () => {
                document.getElementById("txtqr").focus();
                $("#txtqr").val('');

                initScanNimiq();
            });

            $(document).ready(function() {
                $("#txtqr").val('');
                $("#txtbuyer").val('');
                $("#txtstyle").val('');
                $("#txtseason").val('');
                $("#txtcolor").val('');
                $("#txtsize").val('');
                $("#txtdest").val('');
                $("#txtcut_plan").val('');
                $("#txtno_form").val('');
                $("#txtsew_line").val('');
                $("#txtpack").val('');
                $("#txtws").val('');
                $("#txttgl_plan_sew").val('');
                $("#sew_in").val('');
                $("#pack_in").val('');

                // Defect
                $('#defect_line').val('');
                $('#defect_status').val('');
                $('#defect_type').val('');
                $('#defect_allocation').val('');
                $('#defect_in').val('');
                $('#defect_out').val('');
                $('#external').val('');
                $('#external_status').val('');
                $('#external_in').val('');
                $('#external_out').val('');
                $('#packing_defect_line').val('');
                $('#packing_defect_status').val('');
                $('#packing_defect_type').val('');
                $('#packing_defect_allocation').val('');
                $('#packing_defect_in').val('');
                $('#packing_defect_out').val('');
                $('#packing_external').val('');
                $('#packing_external_status').val('');
                $('#packing_external_in').val('');
                $('#packing_external_out').val('');

                scanqr();
            })
        })

        // Scan QR Module :
        // Variable List :
        var html5QrcodeScanner = null;

        // Function List :
        // -Initialize Scanner-
        async function initScan() {
            if (document.getElementById("reader_s")) {
                if (html5QrcodeScanner) {
                    await html5QrcodeScanner.clear();
                }

                function onScanSuccess(decodedText, decodedResult) {
                    // handle the scanned code as you like, for example:
                    console.log(`Code matched = ${decodedText}`, decodedResult);

                    // store to input text
                    // let breakDecodedText = decodedText.split('-');

                    document.getElementById('txtqr').value = decodedText;

                    scanqr();

                    html5QrcodeScanner.clear();

                    $("#scan-qr-header").CardWidget('collapse');

                }

                function onScanFailure(error) {
                    // handle scan failure, usually better to ignore and keep scanning.
                    // for example:
                    console.warn(`Code scan error = ${error}`);
                }

                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader_s", {
                        fps: 120,
                        qrbox: {
                            width: 150,
                            height: 100
                        },
                        rememberLastUsedCamera: true,
                        aspectRatio: 1.7777778,
                        useBarCodeDetectorIfSupported: true,
                        showTorchButtonIfSupported: true,
                        showZoomSliderIfSupported: true,
                        defaultZoomValueIfSupported: 1,
                    },
                    /* verbose= */
                    false);

                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }
        }

        async function initScanNimiq() {
            const nimiqScanner = await import('{{ asset('plugins/js/nimiq-scan.js') }}');

            await nimiqScanner.initScanNimiq(document.getElementById('scan-qr-nimic'), document.getElementById('txtqr'));
        }

        $("#txtqr").on("change", () => {
            if ($("#txtqr").val()) {
                scanqr();
            }
        });

        function scanqr() {
            document.getElementById("loading").classList.remove("d-none");

            let txtqr = document.getElementById("txtqr").value;
            if (txtqr == '') {
                document.getElementById("loading").classList.add("d-none");

                return
                Swal.fire({
                    icon: 'error',
                    title: 'Data QR Tidak Terdaftar',
                    showConfirmButton: true,
                    showCancelButton: false,
                })

                $('#scan-qr-header').CardWidget('toggle')
            }
            let html_1 = $.ajax({
                type: "get",
                url: '{{ route('getdataqr_sb') }}',
                data: {
                    txtqr: txtqr
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    document.getElementById("loading").classList.add("d-none");

                    console.log(response);
                    if (response != '-') {
                        document.getElementById('label_kode_numbering').innerHTML = "Kode Label : "+txtqr;

                        document.getElementById('txtsew_line').value = response.sewing_line;
                        document.getElementById('txtpack').value = response.packing_line;
                        document.getElementById('txttgl_plan_sew').value = response.tgl_plan_fix;
                        document.getElementById('sew_in').value = response.sewing_in;
                        document.getElementById('pack_in').value = response.packing_in;
                    } else {
                        document.getElementById('txtsew_line').value = response;
                        document.getElementById('txtpack').value = response;
                        document.getElementById('txttgl_plan_sew').value = response;
                        document.getElementById('sew_in').value = response;
                        document.getElementById('pack_in').value = response;
                    }

                    $('#scan-qr-header').CardWidget('toggle')
                },
                error: function(request, status, error) {
                    document.getElementById("loading").classList.add("d-none");

                    $('#scan-qr-header').CardWidget('toggle')
                },
            });


            let html_2 = $.ajax({
                type: "get",
                url: '{{ route('getdataqr_defect') }}',
                data: {
                    txtqr: txtqr
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    document.getElementById("loading").classList.add("d-none");

                    console.log(response);
                    if (response != '-') {
                        document.getElementById('defect_line').value = response.sewing_line ? response.sewing_line : "-";
                        document.getElementById('defect_status').value = response.defect_status ? response.defect_status : "-";
                        document.getElementById('defect_type').value = response.defect_type ? response.defect_type : "-";
                        document.getElementById('defect_allocation').value = response.defect_allocation ? response.defect_allocation : "-";
                        document.getElementById('defect_in').value = response.defect_in ? response.defect_in : "-";
                        document.getElementById('defect_out').value = response.defect_out ? response.defect_out : "-";
                        document.getElementById('external').value = response.external_type ? response.external_type : "-";
                        document.getElementById('external_status').value = response.external_status ? response.external_status : "-";
                        document.getElementById('external_in').value = response.external_in ? response.external_in : "-";
                        document.getElementById('external_out').value = response.external_out ? response.external_out : "-";

                        document.getElementById('packing_defect_line').value = response.packing_line ? response.packing_line : "-";
                        document.getElementById('packing_defect_status').value = response.packing_defect_status ? response.packing_defect_status : "-";
                        document.getElementById('packing_defect_type').value = response.packing_defect_type ? response.packing_defect_type : "-";
                        document.getElementById('packing_defect_allocation').value = response.packing_defect_allocation ? response.packing_defect_allocation : "-";
                        document.getElementById('packing_defect_in').value = response.packing_defect_in ? response.packing_defect_in : "-";
                        document.getElementById('packing_defect_out').value = response.packing_defect_out ? response.packing_defect_out : "-";
                        document.getElementById('packing_external').value = response.packing_external_type ? response.packing_external_type : "-";
                        document.getElementById('packing_external_status').value = response.packing_external_status ? response.packing_external_status : "-";
                        document.getElementById('packing_external_in').value = response.packing_external_in ? response.packing_external_in : "-";
                        document.getElementById('packing_external_out').value = response.packing_external_out ? response.packing_external_out : "-";
                    } else {
                        document.getElementById('defect_status').value = response;
                        document.getElementById('defect_type').value = response;
                        document.getElementById('defect_allocation').value = response;
                        document.getElementById('external').value = response;
                        document.getElementById('external_status').value = response;
                        document.getElementById('external_in').value = response;
                        document.getElementById('external_out').value = response;

                        document.getElementById('packing_defect_status').value = response;
                        document.getElementById('packing_defect_type').value = response;
                        document.getElementById('packing_defect_allocation').value = response;
                        document.getElementById('packing_external').value = response;
                        document.getElementById('packing_external_status').value = response;
                        document.getElementById('packing_external_in').value = response;
                        document.getElementById('packing_external_out').value = response;
                    }

                    $('#scan-qr-header').CardWidget('toggle')
                },
                error: function(request, status, error) {
                    document.getElementById("loading").classList.add("d-none");

                    $('#scan-qr-header').CardWidget('toggle')
                },
            });
            // let html = $.ajax({
            //     type: "get",
            //     url: '{{ route('getdataqr_gambar') }}',
            //     data: {
            //         id: response.master_plan_id
            //     },
            //     dataType: 'json',
            //     success: function(res) {
            //         $("#gambar").attr("src",
            //             "https://nag.ddns.net/qr-checker/public/storage/images/" + res
            //             .gambar);
            //         document.getElementById('txtgambar').value = res.gambar;
            //     },
            // });

            let html = $.ajax({
                type: "get",
                url: '{{ route('getdataqr') }}',
                data: {
                    txtqr: txtqr
                },
                dataType: 'json',
                success: function(response) {
                    console.log("get data", response);

                    document.getElementById('txtbuyer').value = response.buyer;
                    document.getElementById('txtstyle').value = response.styleno;
                    document.getElementById('txtseason').value = response.season;
                    document.getElementById('txtcolor').value = response.color;
                    document.getElementById('txtsize').value = response.size;
                    document.getElementById('txtcut_plan').value = response.kode;
                    document.getElementById('txtno_form').value = response.no_form;
                    document.getElementById('txtdest').value = response.dest;
                    document.getElementById('txtws').value = response.ws;
                    document.getElementById('txtline_load').value = response.line_loading;
                    document.getElementById('txttgl_load').value = response.tanggal_loading;
                    // setTimeout(() => {
                    //     // initScan();
                    // }, 1000);

                    // datatable.ajax.reload();
                },
                error: function(request, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data QR Tidak Terdaftar',
                        showConfirmButton: true,
                        showCancelButton: false,

                    })
                    // setTimeout(() => {
                    // initScan();
                    // $('.scan-qr-header').collapsed();
                    // }, 1000);
                    // $("#txtline").val('');
                    // alert(request.responseText);
                },
            });
        };
    </script>
@endsection
