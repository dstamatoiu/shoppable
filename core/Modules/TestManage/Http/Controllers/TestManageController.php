<?php

namespace Modules\TestManage\Http\Controllers;

use App\Events\TenantRegisterEvent;
use App\Helpers\FlashMsg;
use App\Helpers\ModuleMetaData;
use App\Mail\TenantCredentialMail;
use App\Models\PaymentLogs;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestManageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('testmanage::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('testmanage::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('testmanage::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('testmanage::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function paymentGateway($args){
        if (!empty(\tenant()))
        {
            return $this->tenantSuccess($args['payment_details']['id']);
        }

        $charge_data = $this->common_charge_customer_data($args);
        $id = random_int(100000,999999).$charge_data->id.random_int(100000,999999);
        return redirect()->route('landlord.frontend.order.payment.success', $id);
    }

    public function common_charge_customer_data($args)
    {
        $user = Auth::guard('web')->user();
        $email = $user->email;
        $name = $user->name;

        PaymentLogs::find($args['payment_details']['id'])->update([
            'transaction_id' => $args['request']['ali_id'] ?? '',
            'attachments' => $args['request']['ali_express_code'] ?? '',
            'status' => 'complete',
            'payment_status' => 'complete',
            'updated_at' => Carbon::now()
        ]);

        $payment_log = PaymentLogs::where('id', $args['payment_details']['id'])->first();
        $this->tenant_create_event_with_credential_mail($payment_log->id);

        $tenant = Tenant::find($payment_log->tenant_id);

        \DB::table('tenants')->where('id', $tenant->id)->update([
            'renew_status' => $renew_status = is_null($tenant->renew_status) ? 0 : $tenant->renew_status+1,
            'is_renew' => $renew_status == 0 ? 0 : 1,
            'start_date' => $payment_log->start_date,
            'expire_date' => get_plan_left_days($payment_log->package_id, $tenant->expire_date)
        ]);

        return $payment_log;
    }

    public function tenant_create_event_with_credential_mail($order_id)
    {
        $log = PaymentLogs::findOrFail($order_id);
        if (empty($log))
        {
            abort(462,__('Does not exist, Tenant does not exists'));
        }

        $user = User::where('id', $log->user_id)->first();
        $tenant = Tenant::find($log->tenant_id);

        if (!empty($log) && $log->payment_status == 'complete' && is_null($tenant)) {
            event(new TenantRegisterEvent($user, $log->tenant_id, get_static_option('default_theme')));
            try {
                $raw_pass = get_static_option_central('tenant_admin_default_password') ??'12345678';
                $credential_password = $raw_pass;
                $credential_email = $user->email;
                $credential_username = get_static_option_central('tenant_admin_default_username') ?? 'super_admin';

                Mail::to($credential_email)->send(new TenantCredentialMail($credential_username, $credential_password));

            } catch (\Exception $e) {

            }

        } else if (!empty($log) && $log->payment_status == 'complete' && !is_null($tenant) && $log->is_renew == 0) {
            try {
                $raw_pass = get_static_option_central('tenant_admin_default_password') ??'12345678';
                $credential_password = $raw_pass;
                $credential_email = $user->email;
                $credential_username = get_static_option_central('tenant_admin_default_username') ?? 'super_admin';

                Mail::to($credential_email)->send(new TenantCredentialMail($credential_username, $credential_password));

            } catch (\Exception $exception) {
                $message = $exception->getMessage();
                if(str_contains($message,'Access denied')){
                    abort(463,__('Database created failed, Make sure your database user has permission to create database'));
                }
            }
        }

        return true;
    }

    public function tenantSuccess($order_id)
    {
        $order_id = wrap_random_number($order_id);
        return redirect()->route('tenant.user.frontend.order.payment.success', $order_id);
    }
}
