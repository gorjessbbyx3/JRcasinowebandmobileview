<?php 
namespace VanguardLTE\Http\Requests\Auth
{
    class RegisterRequest extends \VanguardLTE\Http\Requests\Request
    {
        public function rules()
        {
            $isDemo = $this->input('is_demo', 0);
            
            if ($isDemo) {
                $rules = [
                    'is_demo' => 'required|boolean',
                    'age_confirmation' => 'required|accepted',
                    'demo_disclaimer' => 'required|accepted'
                ];
            } else {
                $rules = [
                    'username' => 'required|regex:/^[A-Za-z0-9]+$/|unique:users,username', 
                    'password' => 'required|confirmed|min:6'
                ];
                if( settings('tos') ) 
                {
                    $rules['tos'] = 'accepted';
                }
                if( settings('use_email') ) 
                {
                    $rules['email'] = 'required|unique:users,email';
                }
            }
            return $rules;
        }
        public function messages()
        {
            return [
                'tos.accepted' => trans('app.you_have_to_accept_tos'),
                'age_confirmation.accepted' => 'You must confirm that you are over 18 years old.',
                'demo_disclaimer.accepted' => 'You must acknowledge the demo account limitations.'
            ];
        }
    }

}
