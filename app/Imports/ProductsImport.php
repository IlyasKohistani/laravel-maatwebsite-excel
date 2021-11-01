<?php

namespace App\Imports;

use App\Jobs\CreatePasswordMailJob;
use App\Jobs\SendingWelcomeMailJob;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use App\Models\GroupUser;
use App\Models\Position;
use App\Models\Region;
use App\Models\Store;
use App\Models\Title;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;

class ProductImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $companyId = $this->company->id;
        $authenticationTypeId = $this->company->authentication_type_id;
        $loginTypeId = $this->company->login_type_id;
        $user = new User([
            'registration_number' => $row['sicil_numarasi'],
            'name'    => $row['ad'],
            'surname' => $row['soyad'],
            'email' => $row['e_mail'],
            'phone' => $row['telefon'],
            'password' => $row['sifre'] ? bcrypt($row['sifre']) : '0',
            'position_id' => Position::where('company_id', $companyId)->where('name', $row['gorev'])->pluck('id')->first(),
            'title_id' => Title::where('company_id', $companyId)->where('name', $row['unvan'])->pluck('id')->first(),
            'region_id' => Region::where('company_id', $companyId)->where('name', $row['gmbolge_kodu'])->pluck('id')->first(),
            'branch_id' => Branch::where('company_id', $companyId)->where('name', $row['bolumsubebranch_kodu'])->pluck('id')->first(),
            'department_id' => Department::where('company_id', $companyId)->where('name', $row['bolumdepartman_kodu'])->pluck('id')->first(),
            'store_id' => Store::where('company_id', $companyId)->where('name', $row['subemagazadistrubitor_kodu'])->pluck('id')->first(),
            'email_verified_at' => Carbon::now(),
            'login_check_field' => 'email',
            'password_change_required' => $row['sifre'] ? 0 : 1,
            'company_id' => $companyId,
            'login_type_id' => $loginTypeId,
            'authentication_type_id' => $authenticationTypeId,
            "gmbolge_kodu" => "Bulgurlu"
        ]);

        $user->save();
        if ($row['sifre'] == null) {
            if (Cache::has('import_excel_send_password')) {
                $pass_user_id = json_decode(Cache::get('import_excel_send_password'));
                array_push($pass_user_id, $user->id);
                $pass_user_id = json_encode($pass_user_id);
                Cache::put('import_excel_send_password', $pass_user_id);
            } else {
                $pass_user_id = [$user->id];
                $pass_user_id = json_encode($pass_user_id);

                Cache::put('import_excel_send_password', $pass_user_id);
            }
        }

        if (Cache::has('import_excel_send_welcome')) {
            $welcome_user_id = json_decode(Cache::get('import_excel_send_welcome'));
            array_push($welcome_user_id, $user->id);
            $welcome_user_id = json_encode($welcome_user_id);
            Cache::put('import_excel_send_welcome', $welcome_user_id);
        } else {
            $welcome_user_id = [$user->id];
            $welcome_user_id = json_encode($welcome_user_id);

            Cache::put('import_excel_send_welcome', $welcome_user_id);
        }

        if (request()->user_group) {
            GroupUser::insert([
                'user_id' =>  $user->id,
                'group_id' => request()->user_group,
                'created_at' => now()
            ]);
        }


        return $user;
    }

    public function rules(): array
    {
        $companyId = $this->company->id;
        return [
            'sicil_numarasi' => 'nullable',
            'ad' => 'required|regex:/^([0-9\p{Latin}]+[\ -]?)+[a-zA-Z0-9ÜüŞşıIİiçÇöÖğĞ ]+$/u|max:255',
            'soyad' => 'required|regex:/^([0-9\p{Latin}]+[\ -]?)+[a-zA-Z0-9ÜüŞşıIİiçÇöÖğĞ ]+$/u|max:255',
            'e_mail' => ['required', 'email', Rule::unique('users', 'email')->where(function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })],
            'telefon' => 'required',
            'sifre' => 'nullable',
            'gorev' => 'nullable|exists:positions,name',
            'unvan' => 'nullable|exists:titles,name',
            'gmbolge_kodu' => 'nullable|exists:regions,name',
            'bolumsubebranch_kodu' => 'nullable|exists:branches,name',
            'bolumdepartman_kodu' => 'nullable|exists:departments,name',
            'subemagazadistrubitor_kodu' => 'nullable|exists:stores,name',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return ['e_mail' => __('general.email')];
    }


    public function headingRow(): int
    {
        return 1;
    }
}
