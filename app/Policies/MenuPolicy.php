<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        /* $user: Trong TH này sẽ trả về bản ghi của user hiện tại */
        return $user->checkPermissionAccess($user, 'list-menu');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->checkPermissionAccess($user, 'add-menu');
        
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user)
    {
        return $user->checkPermissionAccess($user, 'edit-menu');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAccess($user, 'delete-menu');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Menu $menu)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Menu $menu)
    {
        //
    }
}
