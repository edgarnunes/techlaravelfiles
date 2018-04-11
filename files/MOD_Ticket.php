<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'title', 'description'];

    public function updateTicket($data)
    {
        $ticket = $this->find($data['id']);
        $ticket->user_id = auth()->user()->id;
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->save();
        return $this;
    }

    public function saveTicket($data)
    {
        $this->user_id = auth()->user()->id;
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->save();
        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
