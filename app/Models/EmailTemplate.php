<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name', 'content',
    ];

    public function getAll()
    {
        return self::all();
    }

    public function getById($id)
    {
        return self::where('id', $id)->first();
    }
    
    public function setUpdate($id, $data)
    {
        return self::findOrFail($id)->update([
            'name' => $data['name'],
            'content' => $data['content'],
        ]);
    }

    public function template()
    {
        return $this->hasMany(EmailNotification::class);
    }
}
