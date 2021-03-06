<?php

namespace App\Http\Requests;

use App\ApiUser;
use App\RoutingList;
use App\Services\ApiKeyService;
use App\Http\Requests\Request;

use Log;

class AssignListAgentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // this one not checked, by the validation rules, should move to policy
        $apiuser = ApiKeyService::getApiUser($this->header('apiKey'));
        $list = $this->route('lists');

        return ($list->api_user_id==$apiuser->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lead_info' => 'required|string|max:255'
        ];
    }

    protected function failedAuthorization()
    {
        throw new \Exception("Forbidden ApiUser to assign this ListAgent", 403);
    }
}
