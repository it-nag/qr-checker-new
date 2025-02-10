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
        <div class="card card-primary collapsed-card" id = "scan-qr-header">
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
                                {{-- <input type="button" class="btn btn-sm btn-primary" value="Scan Line" /> --}}
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

    <div class="card card-primary">
        <div class="card-header">
            <h5 class="card-title fw-bold mb-0"><i class="fas fa-list"></i> Item Detail</h5>
        </div>
        <div class="card-body">
            <div class="row justify-content-center align-items-end">
                <div class="col-6 col-md-6">
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
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Cut Plan</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtcut_plan" id="txtcut_plan"
                            readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Tgl Plan Sewing</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txttgl_plan_sew"
                            id="txttgl_plan_sew" readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>No Form</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtno_form" id="txtno_form"
                            readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Sewing Line</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtsew_line" id="txtsew_line"
                            readonly>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><small><b>Packing Line</b></small></label>
                        <input type="text" class="form-control form-control-sm" name="txtpack" id="txtpack"
                            readonly>
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
                        document.getElementById('txtsew_line').value = response.sewing_line;
                        document.getElementById('txtpack').value = response.packing_line;
                        document.getElementById('txttgl_plan_sew').value = response.tgl_plan_fix;
                    } else {
                        document.getElementById('txtsew_line').value = response;
                        document.getElementById('txtpack').value = response;
                        document.getElementById('txttgl_plan_sew').value = response.tgl_plan_fix;
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
