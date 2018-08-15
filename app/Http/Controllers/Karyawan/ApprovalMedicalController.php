<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalMedicalController extends Controller
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
        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','medical')->first();
        $params['data'] = [];
        if($approval)
        {
            if($approval->nama_approval =='HR Benefit')
            {
                $params['data'] = \App\MedicalReimbursement::where('is_approved_hr_benefit', 0)->orderBy('id', 'DESC')->get();
            }

            if($approval->nama_approval =='Manager HR')
            {
                $params['data'] = \App\MedicalReimbursement::where('is_approved_manager_hr', 0)->orderBy('id', 'DESC')->get();
            }

             if($approval->nama_approval =='GM HR')
            {
                $params['data'] = \App\MedicalReimbursement::where('is_approved_atasan', 1)->where('is_approved_gm_hr', 0)->orderBy('id', 'DESC')->get();
            }
        }

        if(empty($approval))
        {
            return redirect()->route('karyawan.dashboard')->with('message-error', 'Access Denied!');
        }

        $params['approval'] = $approval;
        $params['data']     = \App\MedicalReimbursement::orderBy('id', 'DESC')->get();

        return view('karyawan.approval-medical.index')->with($params);
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
        $status->jenis_form             = 'medical';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->noted                  = $request->noted;

        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','medical')->first();
        
        $medical = \App\MedicalReimbursement::where('id', $request->id)->first();        
        if($approval)
        {
            if($approval->nama_approval =='HR Benefit')
            {
                $medical->is_approved_hr_benefit = 1;
            }

            if($approval->nama_approval =='Manager HR')
            {
                $medical->is_approved_manager_hr = 1;
            }

            if($approval->nama_approval =='GM HR')
            {
                $medical->is_approved_gm_hr = 1;
            }   
        }
        $medical->save();    

        foreach($request->nominal_approve as $id => $val)
        {
            $list                   = \App\MedicalReimbursementForm::where('id', $id)->first();
            $list->nominal_approve  = $val;
            $list->save();
        }

        $medical = \App\MedicalReimbursement::where('id', $request->id)->first();
        if($medical->is_approved_hr_benefit ==1 and $medical->is_approved_manager_hr ==1 and $medical->is_approved_gm_hr == 1)
        {
            // cek semua approval
            $status = \App\StatusApproval::where('jenis_form', 'medical')
                                            ->where('foreign_id', $request->id)
                                            ->where('status', 0)
                                            ->count();

            $medical = \App\MedicalReimbursement::where('id', $request->id)->first();
            if($status >=1)
            {
                $status = 3;

                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $medical->user->name .'</p><p> Pengajuan Medical Reimbursement anda ditolak.</p>' ;
            }
            else
            {
                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $medical->user->name .'</p><p> Pengajuan Medical Reimbursement anda disetujui.</p>' ;

                $status = 2;
            }

            //\Mail::to('doni.enginer@gmail.com')->send(new \App\Mail\GeneralMail($objDemo));

            $medical->status = $status;
        }

        // Denied
        if($request->status == 0)
        {
            $medical->status == 3;
        }

        $medical->save();

        return redirect()->route('karyawan.approval.medical.index')->with('message-success', 'Form Medical Reimbursement Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data']         = \App\MedicalReimbursement::where('id', $id)->first();
        $params['approval']     = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','medical')->first();

        return view('karyawan.approval-medical.detail')->with($params);
    }
}
