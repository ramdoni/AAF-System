<?php

namespace App\Http\Controllers\Karyawan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApprovalPaymentRequestController extends Controller
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
        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','payment_request')->first();
        $params['approval'] = $approval;
        $params['data'] = [];

        $params['data'] = \App\PaymentRequest::whereNull('is_proposal_approved')->orderBy('id', 'DESC')->get();


        if($approval)
        {
            $params['data'] = \App\PaymentRequest::orderBy('id', 'DESC')->get();
            // if($approval->nama_approval =='Approval')
            // {
            //     $params['data'] = \App\PaymentRequest::whereNull('is_proposal_approved')->orderBy('id', 'DESC')->get();
            // }

            // if($approval->nama_approval =='Verification')
            // {
            //     $params['data'] = \App\PaymentRequest::whereNull('is_proposal_verification_approved')->orderBy('id', 'DESC')->get();
            // }

            // if($approval->nama_approval =='Payment')
            // {
            //     $params['data'] = \App\PaymentRequest::whereNull('is_payment_approved')->orderBy('id', 'DESC')->get();
            // }
        }
        else
        {
            return redirect()->route('karyawan.dashboard')->with('message-error', 'Access Denied');
        }

        return view('karyawan.approval-payment-request.index')->with($params);
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
        $status->jenis_form             = 'payment_request';
        $status->foreign_id             = $request->id;
        $status->status                 = $request->status;
        $status->save();    

        // cek nominal yang di approve
        if(isset($request->nominal_approve))
        {
            foreach($request->nominal_approve as $k => $item)
            {
                $i = \App\PaymentRequestForm::where('id', $k)->first();
                if($i)
                {
                    $i->note = $request->note[$k];
                    $i->nominal_approved = $item;
                    $i->save();
                }
            }
        }

        $approval = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','payment_request')->first();
        
        $payment = \App\PaymentRequest::where('id', $request->id)->first();

        if($approval)
        {
            if($approval->nama_approval =='Approval')
            {
                $payment->is_proposal_approved      = $request->status;
                $payment->proposal_approval_date    = date('Y-m-d H:i:s');
                $payment->proposal_approval_id      = \Auth::user()->id;
            }

            if($approval->nama_approval =='Verification')
            {
                $payment->is_proposal_verification_approved = $request->status;
                $payment->proposal_verification_date        = date('Y-m-d H:i:s');
                $payment->proposal_verification_id          = \Auth::user()->id;
            }

            if($approval->nama_approval =='Payment')
            {
                $payment->is_payment_approved               = $request->status;
                $payment->payment_approval_date             = date('Y-m-d H:i:s');
                $payment->payment_approval_id               = \Auth::user()->id;
            }
        }
        $payment->save();

        $payment = \App\PaymentRequest::where('id', $request->id)->first();
        if($payment->is_proposal_approved==1 and $payment->is_proposal_verification_approved ==1 and $payment->is_payment_approved ==1)
        {
            // cek semua approval
            $status = \App\StatusApproval::where('jenis_form', 'payment_request')
                                            ->where('foreign_id', $request->id)
                                            ->where('status', 0)
                                            ->count();
            if($status >=1)
            {
                $status = 3;

                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $payment->user->name .'</p><p> Pengajuan Payment Request anda ditolak.</p>' ;
            }
            else
            {
                $status = 2;

                // send email atasan
                $objDemo = new \stdClass();
                $objDemo->content = '<p>Dear '. $payment->user->name .'</p><p> Pengajuan Payment Request anda disetujui.</p>' ;
            }

            $payment->status = $status;
            $payment->save();
        }

        // Jika ada salah satu yang reject maka statusnya berubah jadi reject untuk payment request ini
        if($request->status==0)
        {
            $status = 3;
            $payment->status = $status;
            $payment->save();
        }

        return redirect()->route('karyawan.approval.payment_request.index')->with('message-success', 'Form Payment Request Berhasil diproses !');
    }

    /**
     * [detail description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function detail($id)
    {   
        $params['data'] = \App\PaymentRequest::where('id', $id)->first();
        $params['approval'] = \App\SettingApproval::where('user_id', \Auth::user()->id)->where('jenis_form','payment_request')->first();

        return view('karyawan.approval-payment-request.detail')->with($params);
    }
}
