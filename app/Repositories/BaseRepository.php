<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function newModel()
    {
        return new $this->model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function Paginate()
    {
        return $this->model->Paginate(5);
    }

    public function getLatestRecord()
    {
        return $this->model->orderByRaw("updated_at DESC, created_at DESC");
    }

    public function pluck($attributes = [])
    {
        return $this->model->pluck($attributes);
    }

    public function with($attributes = [])
    {
        return $this->model->with($attributes);
    }

    public function select($attributes = [])
    {
        return $this->model->select($attributes);
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function first()
    {
        $result = $this->model->first();

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}
