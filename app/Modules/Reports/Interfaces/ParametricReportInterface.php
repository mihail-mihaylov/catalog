<?php

namespace App\Modules\Reports\Interfaces;

interface ParametricReportInterface
{
    public function getParametricReport($inputId, $start, $end);
    public function find($id);
    public function create($attributes);
    public function update($id, $attributes);
    public function delete($id);
    public function findBy($key, $value);
    public function restore($id);
}
