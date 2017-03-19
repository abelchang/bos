<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bnb()
    {
        return $this->hasMany('App\BnB');
    }


    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function isEmployee()
     {
         $roles = $this->roles->toArray();
         return !empty($roles);
     }

     public function hasRole($check)
     {
         return in_array($check, array_pluck($this->roles->toArray(), 'name'));
     }

     private function getIdInArray($array, $term)
     {
         foreach ($array as $key => $value) {
             if ($value == $term) {
                 return $key;
             }
         }
 
         // throw new UnexpectedValueException;
     }


     public function makeEmployee($title)
     {
         $assigned_roles = array();
 
         $roles = array_pluck(Role::all()->toArray(), 'name');
 
         switch ($title) {
             case 'super_admin':
                 $assigned_roles[] = $this->getIdInArray($roles, 'edit_customer');
                 $assigned_roles[] = $this->getIdInArray($roles, 'delete_customer');
             case 'admin':
                 $assigned_roles[] = $this->getIdInArray($roles, 'create_customer');
             case 'concierge':
                 $assigned_roles[] = $this->getIdInArray($roles, 'add_points');
                 $assigned_roles[] = $this->getIdInArray($roles, 'redeem_points');
                 break;
             default:
                 throw new \Exception("The employee status entered does not exist");
         }
 
         $this->roles()->attach($assigned_roles);
     }

     public function makeRole($name) {
        $role = Role::where('name', $name)->get();
        $this->roles()->attach($role->first()->id);
     }




}
