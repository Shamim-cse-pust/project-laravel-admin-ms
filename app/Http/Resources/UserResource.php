<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_influencer' => $this->is_influencer,
            $this->mergeWhen(Auth::user() && Auth::user()->isAdmin(), [
                'role' => new RoleResource($this->role),
            ]),
            $this->mergeWhen(Auth::user() && Auth::user()->isInfluencer(), [
                'revenue' => $this->revenue,
            ]),
        ];
    }
}
