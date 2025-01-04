<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tarefa extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'categoria_id',
        'titulo',
        'descricao',
        'status',
        'data_conclusao',
        'ativo',
    ];

    protected $casts = [
        'data_conclusao' => 'datetime',
        'created_at' => 'datetime',
    ];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getStatusOptions()
    {
        return [
            ["id" => 1, "nome" => "Pendente"],
            ["id" => 2, "nome" => "Em andamento"],
            ["id" => 3, "nome" => "Concluída"],
        ];
    }

    public static function getCategorias()
    {
        return Categoria::where('user_id', Auth::user()->id)->where("ativo", 1)->get();
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }


}
