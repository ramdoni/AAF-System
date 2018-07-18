@extends('layouts.administrator')

@section('title', 'Medical Reimbursement - PT. Arthaasia Finance')

@section('sidebar')

@endsection

@section('content')

<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Medical Reimbursement</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Medical Reimbursement</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('karyawan.medical.store') }}" id="form-medical" method="POST"  autocomplete="off">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Medical Reimbursement</h3>
                        <hr />
                        <br />
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                        {{ csrf_field() }}
                        
                        <div class="col-md-6" style="padding-left: 0;">
                            <div class="form-group">
                                <label class="col-md-12">NIK / Nama Karyawan</label>
                                <div class="col-md-12">
                                    <input type="text" readonly="" class="form-control" value="{{ Auth::user()->nik .' - '. Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Jabatan</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ Auth::user()->organisasi_job_role }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department" value="{{ isset(Auth::user()->department->name) ? Auth::user()->department->name : '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Tanggal Pengajuan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control datepicker" name="tanggal_pengajuan" required />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
                            
                            <br />
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Rawat Jalan</td>
                                        <td>Kuitansi Asli/Struk, Diagnosa, Copy Resep, Copy, Hasil scan (jika ada), kode Gigi (jika klaim gigi)</td>
                                    </tr>
                                    <tr>
                                        <td>Rawat Inap</td>
                                        <td>Kuitansi asli, Diagnosa, Copy Resep, Copy hasil scan (jika ada)</td>
                                    </tr>
                                    <tr>
                                        <td>Melahirkan</td>
                                        <td>Kuitansi Asli, Surat Keterangan Lahir</td>
                                    </tr>
                                    <tr>
                                        <td>Kacamata</td>
                                        <td>Kuitansi Asli, Pemerikasaan Dokter Mata (untuk permata kali)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div>
                          <table class="table table-hover">
                              <thead>
                                  <tr>
                                      <th>NO</th>
                                      <th>TANGGAL KWITANSI</th>
                                      <th>HUBUNGAN</th>
                                      <th>NAMA PASIEN</th>
                                      <th>JENIS KLAIM</th>
                                      <th>JUMLAH</th>
                                  </tr>
                              </thead>
                              <tbody class="table-claim">
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" class="form-control datepicker" required name="tanggal_kwitansi[]" /></td>
                                    <td>
                                        <select name="user_family_id[]" class="form-control" onchange="select_hubungan(this)" required>
                                            <option value="">Pilih Hubungan</option>
                                            <option value="{{ \Auth::user()->id }}" data-nama="{{ \Auth::user()->name }}">Saya Sendiri</option>
                                            @foreach(Auth::user()->userFamily as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->hubungan }}</option>
                                            @endforeach 
                                        </select>
                                    </td>
                                    <td><input type="text" readonly="true" class="form-control nama_hubungan" /></td>
                                    <td>
                                        <select name="jenis_klaim[]" class="form-control" required>
                                            <option value="">Pilih Jenis Klaim</option>
                                            @foreach(['RJ' => 'RJ (Rawat Jalan)', 'RI' => 'RI (Rawat Inap)', 'MA' => 'MA (Melahirkan)', 'Kacamata' => 'Kacamata'] as $k => $i)
                                            <option value="{{ $k }}">{{ $i }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control" name="jumlah[]" required /></td>
                                </tr>
                              </tbody>
                          </table>  
                          <span class="btn btn-info btn-xs pull-right" id="add">Tambah</span>
                        </div>

                        <h4><b>Approval</b></h4>
                        <div class="col-md-6" style="border: 1px solid #eee; padding: 15px">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control autcomplete-atasan" placeholder="Select Superior  / Atasan Langsung">
                                    <input type="hidden" name="atasan_user_id" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-6">Jabatan</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan_atasan">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department_atasan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">No Handphone</label>
                                <label class="col-md-6">Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control no_handphone_atasan">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control email_atasan">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ route('administrator.overtime.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                                <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit"><i class="fa fa-save"></i> Submit Medical Reimbursement</a>
                                <br style="clear: both;" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>


@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">

    var list_atasan = [];

    @foreach(get_atasan_langsung() as $item)
        list_atasan.push({id : {{ $item->id }}, value : '{{ $item->nik .' - '. $item->name.' - '. $item->job_rule }}',  });
    @endforeach
</script>
<script type="text/javascript">
    $(".autcomplete-atasan" ).autocomplete({
        source: list_atasan,
        minLength:0,
        select: function( event, ui ) {
            $( "input[name='atasan_user_id']" ).val(ui.item.id);
            
            var id = ui.item.id;

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-karyawan-by-id') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    $('.jabatan_atasan').val(data.data.organisasi_job_role);
                    $('.department_atasan').val(data.data.department_name);
                    $('.no_handphone_atasan').val(data.data.telepon);
                    $('.email_atasan').val(data.data.email);
                }
            });
        }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });

    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    });

    var data_dependent = [];
    
    $("#btn_submit").click(function(){

        if($("input[name='atasan_user_id']").val() == "")
        {
            bootbox.alert('Approval atasan harus dipilih !');
            return false;
        }

        bootbox.confirm('Proses Form Medical Reimbursement ?', function(result){
            if(result)
            {
                $("#form-medical").submit();
            }
        });
    });

    function select_hubungan(el)
    {
        var nama_hubungan = $(el).find(":selected").data('nama');
        
        if(nama_hubungan == "") return false;

        $(el).parent().parent().find('.nama_hubungan').val(nama_hubungan);
    }
    

    $("#add").click(function(){

        var no = $('.table-claim tr').length;

        var html =  '<tr>'+
                        '<td>'+(no+1)+'</td>'+
                        '<td><input type="text" class="form-control datepicker" required name="tanggal_kwitansi[]" /></td>'+
                        '<td>'+
                            '<select name="user_family_id[]" class="form-control" onchange="select_hubungan(this)" required>'+
                                '<option value="">Pilih Hubungan</option><option value="{{ \Auth::user()->id }}" data-nama="{{ \Auth::user()->name }}">Saya Sendiri</option>@foreach(Auth::user()->userFamily as $item)<option value="{{ $item->id }}" data-nama="{{ $item->nama }}">{{ $item->hubungan }}</option>@endforeach'+
                            '</select>'+
                        '</td>'+
                        '<td><input type="text" readonly="true" class="form-control nama_hubungan" /></td>'+
                        '<td>'+
                            '<select name="jenis_klaim[]" class="form-control" required>'+
                                '<option value="">Pilih Jenis Klaim</option>@foreach(['RJ' => 'RJ (Rawat Jalan)', 'RI' => 'RI (Rawat Inap)', 'MA' => 'MA (Melahirkan)', 'Kacamata' => 'Kacamata'] as $k => $i)<option value="{{ $k }}">{{ $i }}</option>@endforeach'+
                            '</select>'+
                        '</td>'+
                        '<td><input type="number" class="form-control" name="jumlah[]" required /></td></tr>';

        $('.table-claim').append(html);

         jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

    });

</script>


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
