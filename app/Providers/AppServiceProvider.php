<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('not_equal_to', function ($attribute, $value, $parameters, $validator) {
            return $value !== '#';
        });

        Event::listen('eloquent.deleting*', function ($eventName, array $data) {
            $model = $data[0];
            $userId = auth()->id();

            // Pastikan model menggunakan soft deletes
            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($model))) {
                // Simpan ID pengguna dalam kolom 'deleted_by'
                $model->deleted_by = $userId;
                $model->save();
            }
        });
    }
}
