<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    protected $userId;

    public function __construct()
    {
        $this->userId = Auth::id();
    }

    /**
     * Handle the model "creating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function creating(Model $model)
    {
        if ($this->userId) {
            $model->created_by = $this->userId;
            $model->updated_by = $this->userId;
        }
    }

    /**
     * Handle the model "updating" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function updating(Model $model)
    {
        if ($this->userId) {
            $model->updated_by = $this->userId;
        }
    }

    /**
     * Handle the model "deleting" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function deleting(Model $model)
    {
        if ($this->userId) {
            $model->deleted_by = $this->userId;
        }
    }

    /**
     * Handle the model "restoring" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function restoring(Model $model)
    {
        if ($this->userId) {
            $model->updated_by = $this->userId;
        }

        $model->deleted_by = null;
    }
}
