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
            <form class="form-horizontal" id="form-medical" enctype="multipart/form-data" action="{{ route('karyawan.approval.medical.proses') }}" method="POST">

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
                                    <input type="text" class="form-control" readonly="true" value="{{ $data->user->nik .' - '. $data->user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Jabatan</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ $data->user->organisasi_job_role }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department" value="{{ $data->user->department->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Tanggal Pengajuan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" readonly name="tanggal_pengajuan" required value="{{ $data->tanggal_pengajuan }}" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
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
                                @foreach($data->form as $key => $f)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><input type="text" class="form-control datepicker"  readonly="true" name="tanggal_kwitansi[]" value="{{ $f->tanggal_kwitansi }}"  /></td>
                                     <td>
                                        @if($data->user->id == $f->user_family_id)
                                            <input type="text" readonly="true" class="form-control" value="Saya Sendiri">
                                        @else
                                            <input type="text" readonly="true" class="form-control" value="{{ $f->UserFamily->nama }}">
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->user->id == $f->user_family_id)
                                            <input type="text" readonly="true" class="form-control" value="{{ isset($f->user_family->name) ? $f->user_family->name : ''  }}" />
                                        @else
                                            <input type="text" readonly="true" class="form-control" value="{{ isset($f->UserFamily->nama) ? $f->UserFamily->nama : ''  }}" />
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-control" readonly>
                                            <option value="">Pilih Jenis Klaim</option>
                                            @foreach(jenis_claim_medical() as $k => $i)
                                            <option value="{{ $k }}" {{ $f->jenis_klaim == $k ? 'selected' : '' }} >{{ $i }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" required value="{{ number_format($f->jumlah) }}" readonly /></td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                            
                            <input type="hidden" name="status" value="0" />
                            <input type="hidden" name="id" value="{{ $data->id }}">

                        </div>
                        <br />
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('karyawan.approval.medical.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                            @if($data->is_approved_atasan == 1)
                                @if($approval->nama_approval == 'HR Benefit')
                                    @if($data->is_approved_hr_benefit == "")
                                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-save"></i> Approve</a>
                                        <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
                                    @endif
                                @endif

                                @if($approval->nama_approval == 'Manager HR')
                                    @if($data->is_approved_manager_hr == "")
                                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-save"></i> Approve</a>
                                        <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
                                    @endif
                                @endif  

                                @if($approval->nama_approval == 'GM HR')
                                    @if($data->is_approved_gm_hr == "")
                                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-save"></i> Approve</a>
                                        <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
                                    @endif
                                @endif
                            @endif

                            <br style="clear: both;" />
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
    <script type="text/javascript">
        $("#btn_approved").click(function(){
            bootbox.confirm('Approve Medical Reimbursement Karyawan ?', function(result){

                $("input[name='status']").val(1);
                if(result)
                {
                    $('#form-medical').submit();
                }

            });
        });

        $("#btn_tolak").click(function(){
            bootbox.confirm('Tolak Medical Reimbursement Karyawan ?', function(result){

                if(result)
                {
                    $('#form-medical').submit();
                }

            });
        });
    </script>
@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
