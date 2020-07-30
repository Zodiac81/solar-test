<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 30.07.20
 * Time: 14:30
 */

namespace App\Http\Repositories;


interface IRepository
{
    public function all();
    public function show(int $id);
    public function store(array $data);
    public function update(array $data, int $id);
    public  function delete(int $id);
}