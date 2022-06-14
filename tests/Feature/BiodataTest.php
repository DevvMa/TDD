<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class BiodataTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_biodata()
    {
        $payloads = [
            'name' => 'Aldi',
            'email'=> 'gmail@aldi.com',
            'password'=>'1234',
            'nim'=> '12045',
            'tempat_lahir' => 'Bangkalan', 
            'tanggal_lahir' => '2000-01-05',
            'jenis_kelamin' => 'L', 
            'alamat' => 'Jl. Madura kec. bangkalan kota Surabaya' 
        ];

        $response = $this->post('api/biodata', $payloads);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', Arr::only($payloads, ['name', 'email']));
        $this->assertDatabaseHas('biodata', Arr::only($payloads, ['nim', 'tempat_lahir', 'jenis_kelamin', 'alamat']));
        $response->assertJson(['msg' => 'Data Telah Ditambahkan']);
    }

    public function test_can_update_biodata()
    {
        $this->test_can_create_biodata();

        $payloads = [
            'name' => 'Aldi Taher',
            'email'=> 'gmail@alditaher.com',
            'password'=>'43215',
            'nim'=> '14045',
            'tempat_lahir' => 'Surabaya', 
            'tanggal_lahir' => '1996-01-05',
            'jenis_kelamin' => 'L', 
            'alamat' => 'Jl. Surabaya kec. bangkalan kota Madura' 
        ];

        $user = User::select('id')->where('email', 'gmail@aldi.com')->first();
        $response = $this->put("api/biodata/{$user->id}", $payloads);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', Arr::only($payloads, ['name', 'email']));
        $this->assertDatabaseMissing('users', $user->only(['name', 'email']));
        $this->assertDatabaseHas('biodata', Arr::only($payloads, ['nim', 'tempat_lahir', 'jenis_kelamin', 'alamat']));
        $response->assertJson(['msg' => 'Data Telah Diubah']);
    }

    public function test_can_delete_biodata()
    {
        $this->test_can_create_biodata();
        
        $user = User::select('id')->where('email', 'gmail@aldi.com')->first();
        
        $response = $this->delete("api/biodata/{$user->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', $user->only(['name', 'email']));
        $response->assertJson(['msg' => 'Data Telah Dihapus']);
    }
    
    public function test_can_read_biodata()
    {
        $this->test_can_create_biodata();
        $user = User::select('id','name', 'email')->with('biodata')->where('email', 'gmail@aldi.com')->first();
        $response= $this->get("api/biodata/{$user->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'name' => $user->name,
            'email'=>$user->email,
            'nim'=>$user->biodata->nim
        ]);
    }
}
