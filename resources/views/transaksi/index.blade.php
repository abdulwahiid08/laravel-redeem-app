<x-master-layout>
    @section('content')
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Transaksi</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><b>Transaksi:</b> a.n {{ Auth::user()->name }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h3>Transaksi dan Redeem Voucher</h3>
                                    </div>
                                    {{-- Invoice Transaksi --}}
                                    <div class="faktur" style="display: none">
                                        <div class="card card-success mt-4">
                                            <div class="card-header">
                                                <h3 class="card-title">Faktur Transaksi</h3>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="mb-3 text-muted">Tanggal Transaksi: {{ date('d-M-Y') }}</h6>
                                                <h6>ID Transaksi: <b><span id="id-transaksi"></span></b></h6>
                                                <h6>Nama Customer: <b><span
                                                            id="nama-customer">{{ Auth::user()->name }}</span></b></h6>
                                                <h6>Total Belanja: Rp. <b><span id="total-bayar"></span></b></h6>
                                                <span class="badge bg-info mb-3">
                                                    <h6 id="ket-transaksi"></h6>
                                                </span>

                                                {{-- Klaim Voucher --}}
                                                <div id="input-klaim-transaksi" class="row input-klaim-transaksi"
                                                    style="display: none">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="id_transaksi">ID Transaksi</label>
                                                            <input type="text" name="id_transaksi" class="form-control"
                                                                id="id_transaksi" placeholder="masukan id transaksi">
                                                            <a href="#" class="btn btn-info mt-1"
                                                                id="btn-klaim">Klaim</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kode-contain" style="display: none">
                                                    <h6>Kode Voucher: <b><span id="kode-voucher"
                                                                class="text-danger">-</span></b></h6>
                                                    <h6>Masa Berlaku: <b><span id="masa-berlaku">-</span></b></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- Input Total Belanja --}}
                                        <div class="col-md-6">
                                            <div class="card mt-4">
                                                <form id="form-transaksi" method="POST">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="total_belanja">Total Belanja</label>
                                                            <input type="text" name="total_belanja" class="form-control"
                                                                id="total_belanja" onkeypress="return onlyNumberKey(event)"
                                                                placeholder="masukan total belanja">
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="btn-bayar">Bayar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- Input Redeem Token --}}
                                        <div class="col-md-6">
                                            <div class="card mt-4">
                                                <form id="form-redeem">
                                                    @csrf
                                                    @method('put')
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="kode_voucher">Redeem Voucher</label>
                                                            <input type="text" name="kode_voucher" class="form-control"
                                                                id="kode_voucher" placeholder="masukan kode voucher">
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-warning"
                                                            id="btn-redeem">Redeem</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>
            // Mencegah huruf pada input
            function onlyNumberKey(evt) {
                var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                    return false;
                return true;
            }

            // Get Voucher
            $('body').on('click', '#btn-klaim', function(e) {
                e.preventDefault();
                var idTransaksi = $('#id_transaksi').val();
                // alert(id)
                $.get('/transaksi-klaim/' + idTransaksi, function(data) {
                    if (data.error) {
                        toastr.warning(data.error);
                    } else {
                        $('#kode-voucher').text(data.kode_voucher);
                        $('#masa-berlaku').text(data.masa_berlaku);
                        $('.kode-contain').attr('style', 'display: block');
                    }
                });
            });

            // proses transaksi
            $('#form-transaksi').submit(function(e) {
                e.preventDefault();

                $("#btn-bayar").html("Sedang diproses...");
                $(".btn").attr("disabled", true);

                $.ajax({
                    type: "POST",
                    url: "{{ route('transaksi.store') }}",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#btn-bayar").html("Bayar");
                        $(".btn").attr("disabled", false);
                        // Cek error
                        if (data.error) {
                            toastr.error(data.error);
                        } else {
                            toastr.success(data.message);

                            $('#id-transaksi').html(data.data.kode_transaksi);
                            $('#total-bayar').html(data.data.totalBelanja);
                            if (data.data.total_belanja >= 1000000) {
                                $('#ket-transaksi').text(
                                    'Selamat! Anda mendapatkan voucher potongan sebesar Rp. 10.000. Klaim ID Transaksi untuk mendapatkan kode voucher'
                                );
                                $('.input-klaim-transaksi').attr('style', 'display: block');
                            } else {
                                $('#ket-transaksi').text(
                                    'Terima Kasih telah berbelanja di mall kami');
                            }
                            $('.faktur').attr('style', 'display: block');
                        }
                    },
                });
            });

            // Proses Redeem Voucher
            $('#form-redeem').submit(function(e) {
                e.preventDefault();

                // Get value input total belanja
                let kodeVoucher = $('#kode_voucher').val();

                $("#btn-redeem").html("Cek voucher...");
                $(".btn").attr("disabled", true);

                $.ajax({
                    type: "PUT",
                    url: "/voucher/" + kodeVoucher,
                    data: $(this).serialize(),
                    success: function(data) {
                        // alert('Berhasil');
                        $("#btn-redeem").html("Reedem");
                        $(".btn").attr("disabled", false);

                        if (data.error) {
                            toastr.info(data.error);
                        } else {
                            toastr.success(data.message);
                        }
                    }
                });
            });
        </script>
    @endsection
</x-master-layout>
