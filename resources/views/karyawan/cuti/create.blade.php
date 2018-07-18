@extends('layouts.karyawan')

@section('title', 'Cuti Karyawan - PT. Arthaasia Finance')

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
                <h4 class="page-title">Form Cuti / Ijin Karyawan</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Cuti / Ijin Karyawan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" id="form-cuti" enctype="multipart/form-data" action="{{ route('karyawan.cuti.store') }}" method="POST" autocomplete="off">
                <div class="col-md-12"> 
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Cuti / Ijin</h3>
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
                                <label class="col-md-6">NIK / Nama Karyawan</label>
                                <label class="col-md-6">Telepon</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ Auth::user()->nik .' / '. Auth::user()->name }}" readonly="true">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ Auth::user()->telepon }}" readonly="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Jabatan</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan" value="{{ Auth::user()->organisasi_job_role }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department" value="{{ isset(Auth::user()->department) ? Auth::user()->department->name : '' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Jenis Cuti / Ijin</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="jenis_cuti" required>
                                        <option value="">Pilih Jenis Cuti / Ijin</option>
                                        @foreach(list_user_cuti() as $item)
                                        <option value="{{ $item->id }}" data-kuota="{{ $item->kuota }}" data-cutiterpakai="{{ get_cuti_terpakai($item->id, \Auth::user()->id) }}" data-sisacuti="{{ get_cuti_user($item->id, \Auth::user()->id, 'sisa_cuti') }}">{{ $item->jenis_cuti }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-s6"> 
                                    <input type="text" name="jam_pulang_cepat" style="display: none;" class="form-control jam_pulang_cepat" placeholder="Jam Pulang Cepat">
                                    <input type="text" name="jam_datang_terlambat" style="display: none;" class="form-control jam_datang_terlambat" placeholder="Jam Datang Terlambat">
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label class="col-md-4">Kuota Cuti / Ijin</label>
                                <label class="col-md-3">Cuti Terpakai</label>
                                <label class="col-md-3">Sisa Cuti</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control kuota_cuti" name="" readonly="true" />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control cuti_terpakai" readonly="true"  />
                                </div>
                                <div class="col-md-3">
                                    <input type="text" readonly="true" class="form-control sisa_cuti">
                                </div>
                                <div class="col-md-2">
                                    <label class="btn btn-info btn-sm" id="history_cuti"><i class="fa fa-history"></i> History</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">
                                    Superior / Atasan Langsung
                                </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control autcomplete-atasan">
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

                            <div class="clearfix"></div>
                            <br />
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12">Tanggal Cuti / Ijin</label>
                                <div class="col-md-5">
                                    <input type="text" name="tanggal_cuti_start" class="form-control" id="from" placeholder="Start Tanggal" />
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="tanggal_cuti_end" class="form-control" id="to" placeholder="End Tanggal">
                                </div>
                                <div class="col-md-2">
                                    <h3 class="btn btn-info total_hari_cuti" style="margin-top:0;">0 Hari</h3>
                                    <h3 class="btn btn-warning btn_hari_libur" style="margin-top:0;">Hari Libur</h3>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Keperluan</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="keperluan"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Selama Cuti / Ijin, Backup dan Informasi pekerjaan diberikan kepada</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control autcomplete-backup">
                                    <input type="hidden" name="backup_user_id" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">Jabatan</label>
                                <label class="col-md-6">Division / Departement</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control jabatan_backup">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control department_backup">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-6">No Handphone</label>
                                <label class="col-md-6">Email</label>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control no_handphone">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" readonly="true" class="form-control email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('karyawan.cuti.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_submit_form"><i class="fa fa-save"></i> Submit Form Cuti / Ijin</a>
                            <br style="clear: both;" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>  
                <input type="hidden" name="total_cuti" />  
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>

<!-- sample modal content -->
<div id="modal_history_cuti" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">History Cuti</h4> </div>
                <div class="modal-body">
                   <div class="form-horizontal">
                    <table class="table tabl-hover">
                       <thead>
                           <tr>
                               <th width="50">NO</th>
                               <th>TANGGAL CUTI</th>
                               <th>JENIS CUTI</th>
                               <th>LAMA CUTI</th>
                               <th>KEPERLUAN</th>
                           </tr>
                       </thead> 
                       <tbody>
                        @foreach(list_cuti_user(Auth::user()->id) as $no => $item)
                        
                        @if($item->status == 1 || $item->status == 3)
                            @continue
                        @endif

                        <tr>
                           <td>{{ $no + 1 }}</td>
                           <td>{{ $item->tanggal_cuti_start }} - {{ $item->tanggal_cuti_end }}</td>
                           <td>{{ $item->jenis_cuti }}</td>
                           <td>{{ lama_hari($item->tanggal_cuti_start, $item->tanggal_cuti_end) }}</td>
                           <td>{{ $item->keperluan }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                       </table>
                   </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- sample modal content -->
<div id="modal_hari_libur" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">HARI LIBUR</h4> </div>
                <div class="modal-body">
                   <div class="form-horizontal">
                    <table class="table tabl-hover">
                       <thead>
                           <tr>
                               <th width="50">NO</th>
                               <th>TANGGAL</th>
                               <th>KETERANGAN</th>
                           </tr>
                       </thead> 
                       <tbody>
                        @foreach(list_hari_libur() as $no => $item)
                        <tr>
                           <td>{{ $no + 1 }}</td>
                           <td>{{ $item->tanggal }}</td>
                           <td>{{ $item->keterangan }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                       </table>
                   </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<!-- Clock Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script type="text/javascript">
    var list_anggota = [];
    var list_atasan = [];

    @foreach(get_backup_cuti() as $item)
        list_anggota.push({id : {{ $item->id }}, value : "{{ $item->nik .' - '. $item->name }}" });
    @endforeach

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

    $(".autcomplete-backup" ).autocomplete({
        source: list_anggota,
        minLength:0, 
        select: function( event, ui ) {
            $( "input[name='backup_user_id']" ).val(ui.item.id);
            
            var id = ui.item.id;

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-karyawan-by-id') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    $('.jabatan_backup').val(data.data.organisasi_job_role);
                    $('.department_backup').val(data.data.department_name);
                    $('.no_handphone').val(data.data.telepon);
                    $('.email').val(data.data.email);
                }
            });
          }
    }).on('focus', function () {
            $(this).autocomplete("search", "");
    });
    
    $(".btn_hari_libur").click(function(){

        $("#modal_hari_libur").modal('show');

    });

    $("input[name='tanggal_cuti_end']").on('change', function(){
        calculateCuti();
    });
    $("input[name='tanggal_cuti_start']").on('change', function(){
        calculateCuti();
    });

    function getMonth(date) {
      var month = date.getMonth() + 1;
      return month < 10 ? '0' + month : '' + month;
    } 

    function getDay(date) {
      var month = date.getDate() + 1;
      return month < 10 ? '0' + month : '' + month;
    }  

    function calculateCuti()
    {
        var oneDay      = 24*60*60*1000; // hours*minutes*seconds*milliseconds
        var start_date  = $("input[name='tanggal_cuti_start']").val();
        var end_date    = $("input[name='tanggal_cuti_end']").val();
        
        if(start_date == "" || end_date == "")
        {
            return false;
        }

        if(start_date == end_date)
        {
            $('.total_hari_cuti').html('1 Hari');  
            $("input[name='total_cuti']").val(1);            
        }
        else
        {
            var star_date   = new Date(start_date);
            var end_date    = new Date(end_date);

            var star_date2   = new Date(start_date);
            var end_date2    = new Date(end_date);

            var hari_libur = [];
            @foreach(hari_libur() as $i)
            hari_libur.push('{{ $i->tanggal }}');
            @endforeach

            var total_libur = 0;

            while(star_date2 <= end_date2){

                var mm = ((star_date2.getMonth()+1)>=10)?(star_date2.getMonth()+1):'0'+(star_date2.getMonth()+1);
                var dd = ((star_date2.getDate())>=10)? (star_date2.getDate()) : '0' + (star_date2.getDate());
                var yyyy = star_date2.getFullYear();
                var date = yyyy+"-"+mm+"-"+dd;

                if (hari_libur.indexOf(date) === -1) { }    
                else 
                {
                    total_libur++;
                }

                star_date2 = new Date(star_date2.setDate(star_date2.getDate() + 1)); //date increase by 1
            }

            $('.total_hari_cuti').html(  (calcBusinessDays(star_date, end_date) - total_libur ) +" Kerja" ); 
            $("input[name='total_cuti']").val((calcBusinessDays(star_date, end_date) - total_libur ));  
        } 
    }

    function calcBusinessDays(dDate1, dDate2) // input given as Date objects
    { 
        var iWeeks, iDateDiff, iAdjust = 0;
        if (dDate2 < dDate1) return -1; // error code if dates transposed
        var iWeekday1 = dDate1.getDay(); // day of week
        var iWeekday2 = dDate2.getDay();
        iWeekday1 = (iWeekday1 == 0) ? 7 : iWeekday1; // change Sunday from 0 to 7
        iWeekday2 = (iWeekday2 == 0) ? 7 : iWeekday2;
        if ((iWeekday1 > 5) && (iWeekday2 > 5)) iAdjust = 1; // adjustment if both days on weekend
        iWeekday1 = (iWeekday1 > 5) ? 5 : iWeekday1; // only count weekdays
        iWeekday2 = (iWeekday2 > 5) ? 5 : iWeekday2;
     
        // calculate differnece in weeks (1000mS * 60sec * 60min * 24hrs * 7 days = 604800000)
        iWeeks = Math.floor((dDate2.getTime() - dDate1.getTime()) / 604800000)
     
        if (iWeekday1 <= iWeekday2) {
          iDateDiff = (iWeeks * 5) + (iWeekday2 - iWeekday1)
        } else {
          iDateDiff = ((iWeeks + 1) * 5) - (iWeekday1 - iWeekday2)
        }
     
        iDateDiff -= iAdjust // take into account both days on weekend
     
        return (iDateDiff + 1); // add 1 because dates are inclusive
    }

    $("#history_cuti").click(function(){

        $("#modal_history_cuti").modal('show');

    });

    $("select[name='jenis_cuti']").on('change', function(){

        var el = $(this).find(":selected");
    
        if($(this).val() != 'Izin')
        {   
            $('.kuota_cuti').val( el.data('kuota') );
            $('.cuti_terpakai').val( el.data('cutiterpakai') );
            $('.sisa_cuti').val( el.data('sisacuti') );

        }else{
            $('.kuota_cuti').val('0');
            $('.cuti_terpakai').val('0');
            $('.sisa_cuti').val('0');
        }


        if($(this).val() == 15)
        {
            $('.jam_pulang_cepat').show();
            time_picker();
        }
        else
        {
            $('.jam_pulang_cepat').hide();
        }

        if($(this).val() == 14)
        {
            $('.jam_datang_terlambat').show();
            time_picker();
        }
        else
        {
            time_picker();
            $('.jam_datang_terlambat').hide();
        }

    });

    $("#btn_submit_form").click(function(){

        // Validasi data
        if($("input[name='jenis_cuti']").val()== "" || $("input[name='backup_user_id']").val() == "" || $("textarea[name='keperluan']").val() == "" ||  $("input[name='tanggal_cuti_start']").val() == "" || $("input[name='tanggal_cuti_end']").val() == "" )
        {
            bootbox.alert("Data Cuti belum lengkap !");
            return false;
        }
        if($("input[name='atasan_user_id']").val() == "")
        {

            bootbox.alert('Nama Superior tidak ditemukan dalam list department anda !');
            return false;
        }

        bootbox.confirm('Submit Form Cuti / Izin ?', function(result){
            if(result)
            {
                $("#form-cuti").submit();
            }
        });
    });

    jQuery('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        minDate: 1
    });
    

    $( "#from, #to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        onSelect: function( selectedDate ) {
            if(this.id == 'from'){
              var dateMin = $('#from').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate()); // Min Date = Selected + 1d
              var rMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 31); // Max Date = Selected + 31d
              $('#to').datepicker("option","minDate",rMin);
              $('#to').datepicker("option","maxDate",rMax);                    
            }

            calculateCuti();
        }
    });

    $("select[name='backup_user_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $('.jabatan_backup').val(data.data.organisasi_job_role);
                $('.department_backup').val(data.data.department_name);
                $('.no_handphone').val(data.data.telepon);
                $('.email').val(data.data.email);
            }
        });

    });

    $("select[name='user_id']").on('change', function(){

        var id = $(this).val();

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $('.hak_cuti').val(data.data.hak_cuti);
                $('.jabatan').val(data.data.nama_jabatan);
                $('.department').val(data.data.department_name);
                $('.cuti_terpakai').val(data.data.cuti_yang_terpakai);

                $("select[name='backup_user_id'] option[value="+ id +"]").remove();
            }
        });
    });


    $("#add").click(function(){

        var no = $('.table-content-lembur tr').length;

        var html = '<tr>';
            html += '<td>'+ (no+1) +'</td>';
            html += '<td><textarea name="description[]" class="form-control"></textarea></td>';
            html += '<td><input type="text" name="awal[]" class="form-control" /></td>';
            html += '<td><input type="text" name="akhir[]" class="form-control" /></td>';
            html += '<td><input type="text" name="total_lembur[]" class="form-control"  /></td>';
            html += '<td><select name="employee_id" class="form-control"><option value="">Pilih Employee</option></select></td>';
            html += '<td><select name="employee_id" class="form-control"><option value="">Pilih SPV</option></select></td>';
            html += '<td><select name="employee_id" class="form-control"><option value="">Pilih Manager</option></select></td>';
            html += '</tr>';

        $('.table-content-lembur').append(html);

    }); 

    function time_picker()
    {
        // Clock pickers
        $('.jam_pulang_cepat').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        $('.jam_datang_terlambat').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
    }

</script>


@endsection
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
