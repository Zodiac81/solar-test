<?php

namespace App\Http\Repositories;


use Illuminate\Database\Eloquent\Model;

class Repository implements IRepository
{
    protected $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function show(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $request, int $id)
    {
        $record = $this->model->find($id);
        $record->update($request);
        return $record;
    }

    public function delete(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}