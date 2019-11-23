<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'reply' => $this->body,
            'user_id' => $this->user_id,
            'question_slug' => $this->question->slug,
            'replied_at' => $this->created_at->diffForHumans(),
            'replied_by' => $this->user->name,
        ];
    }
}
