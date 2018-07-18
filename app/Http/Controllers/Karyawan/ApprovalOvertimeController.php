<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalOvertimeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // cek jenis user
        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','overtime')->first();
        
        if(empty($approval))
        {
            return redirect()->route('karyawan.dashboard')->with('message-error', 'Access denied');
        }
        $params['approval'] = $approval;
        $params['data'] = \App\OvertimeSheet::orderBy('id', 'DESC')->get();

        return view('karyawan.approval-overtime.index')->with($params);
    }

    /**
     * [proses description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function proses(Request $request)
    {
        $status = new \App\StatusApproval;
        $status->approval_user_id       = \Auth::user()->id;
        $status->jenis_form             = 'overtime';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->noted                  = $request->noted;
        $status->save();    
    
        $overtime = \App\OvertimeSheet::where('id', $request->id)->first();
        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','overtime')->first();
        
        if($approval)
        {
            if($approval->nama_approval =='Manager HR')
            {
                $overtime->is_hr_manager = 1;
            }

            if($approval->nama_approval =='HR Operation')
            {
                $overtime->is_hr_benefit_approved = 1;
            }
        }
        $overtime->save();

        $overtime = \App\OvertimeSheet::where('id', $request->id)->first();
        if($overtime->is_hr_benefit_approved ==1 and $overtime->is_hr_manager ==1)
        {
            // cek semua approval
            $status = \App\StatusApproval::where('jenis_form', 'overtime')
                                            ->where('foreign_id', $request->id)
                                            ->where('status', 0)
                                            ->count();
            $overtime = \App\OvertimeSheet::where('id', $request->id)->first();
            if($status >=1)
            {
                $status = 3;

                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $overtime->user->name .'</p><p> Pengajuan Overtime anda ditolak.</p>' ;    
            }
            else
            {
                $status = 2;
                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $overtime->user->name .'</p><p> Pengajuan Overtime anda disetujui.</p>' ; 
            }
            
            //\Mail::to($overtime->user->)->send(new \App\Mail\GeneralMail($objDemo));
            //\Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));

            $overtime->status = $status;
            $overtime->save();
        }

        return redirect()->route('karyawan.approval.overtime.index')->with('messages-success', 'Form Cuti Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = \App\OvertimeSheet::where('id', $id)->first();
        $params['approval']     = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','overtime')->first();

        return view('karyawan.approval-overtime.detail')->with($params);
    }
}
