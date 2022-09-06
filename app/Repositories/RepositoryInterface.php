<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();

    public function Paginate();

    public function getLatestRecord();

    public function pluck($attributes = []);

    public function find($id);

    public function first();

    public function with($attributes = []);

    public function select($attributes = []);

    public function create($attributes = []);

    public function update($id, $attributes = []);

    public function delete($id);

    public function newModel();




}
