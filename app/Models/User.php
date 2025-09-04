<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tahvel_cookie',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function tahvelUser(): mixed
    {
        $response = Http::withHeaders([
            'cookie' => $this->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/user');

        if (! $response->ok() || empty($response->body())) {
            return null;
        }

        return $response->json();
    }
    
    public function tahvelJournals(): mixed
    {
        $response = Http::withHeaders([
            'cookie' => $this->tahvel_cookie,
        ])->get('https://tahvel.edu.ee/hois_back/journals/studentJournalAbsences?studentId=132813', [
            'studyYear' => 708,
            'onlyMyJournals' => true,
            'size' => 20,
            'page' => 0,
        ]);

        if (! $response->ok() || empty($response->body())) {
            return null;
        }

        return $response->json();

    }

}
