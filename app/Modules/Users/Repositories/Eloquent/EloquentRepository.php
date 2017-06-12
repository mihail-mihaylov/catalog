<?php
namespace App\Modules\Users\Repositories\Eloquent;

use Illuminate\Http\Request;

abstract class EloquentRepository
{

    /**
     * The repository model
     *
     * @var Model
     */
    protected $model;

    public static function __callStatic($name, $arguments)
    {
        if ($name === 'where') {
            foreach ($arguments as $argument) {
                $this->model = $this->model->with($argument);
            }
        }
    }

    public function newObject()
    {
        return new $this->model;
    }

    public function insert($arr)
    {
        return $this->model->insert($arr);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($attributes)
    {
        $obj = $this->model->create($attributes);
        // foreach ($attributes as $k => $v) {
        //     if (in_array($k, $this->model->getFillable())) {
        //         $obj->$k = $v;
        //     }
        // }
        $obj->save();

        return $obj;
    }

    public function load($attributes)
    {
        $obj = $this->model->load($attributes);

        return $obj;
    }

    public function update($id, $attributes)
    {
        $obj = $this->model->withTrashed()->find($id);

        foreach ($attributes as $property => $attribute) {
            if (is_array($attribute)) {
                $obj->{$property}()->sync($attribute);
            }
        }

        if ($obj !== null) {
            $obj->update($attributes);
        }

        return $obj;
    }

    public function updateWithoutRelations($id, $attributes)
    {
        $obj = $this->model->withTrashed()->find($id);

        $obj->update($attributes);

        return $obj;
    }

    public function delete($id)
    {
        $obj = $this->findOrFail($id);

        $obj->delete();

        return $obj;
    }

    public function findBy($key, $value)
    {
        return $this->model->where($key, $value);
    }

    public function restore($id)
    {
        $obj = $this->model->withTrashed()->find($id);

        $obj->restore();

        return $obj;
    }

    public function findWithDeletes($id, $with = [])
    {
        $obj = $this->model->withTrashed()->where('id', $id);
        foreach ($with as $relation) {
            $obj->with($relation);
        }

        return $obj->first();
    }

    public function allWithDeleted($with = [])
    {
        $res = $this->model->withTrashed();

        foreach ($with as $relation) {
            $res = $res->with($relation);
        }

        return $res->get();
    }

    public function with($with = [])
    {
        $r = $this->model;
        foreach ($with as $relation) {
            $r = $r->with($relation);
        }

        return $r;
    }

    public function attach($attach)
    {
        $this->model->attach($attach);
    }

    public function whereInWithDeletes($in, $with = [], $column = 'id')
    {
        $res = $this->model->withTrashed();

//        foreach ($with as $relation) {
        //            $res = $res->with($relation);
        //        }

        return $res->whereIn($column, $in)->get();
    }

    public function whereInWith($in, $with = [], $column = 'id')
    {
        $res = $this->model;

        foreach ($with as $relation) {
            $res = $res->with($relation);
        }

        return $res->whereIn($column, $in)->get();
    }

    public function whereIn($in, $column = 'id')
    {
        return $this->model->whereIn($column, $in)->get();
    }

    public function whereEquals(array $conditions)
    {
        foreach ($conditions as $column => $value) {
            $this->model = $this->model->where($column, $value);
        }

        return $this->model->get();
    }

    public function setConnection($conn)
    {
        $this->model->setConnection($conn);
    }

    public function getConnection()
    {
        return $this->model->getConnection();
    }

    public function createTranslations($translationData, $modelForeignKey, $model)
    {
        foreach ($translationData as $languageId => $translatedAttributes) {
            $data                   = $translatedAttributes;
            $data['language_id']    = $languageId;
            $data[$modelForeignKey] = $model->id;

            $translation = $model->translations()->create($data);
//            dd('first');
        }
    }

    public function updateTranslations($translationData, $modelForeignKey, $model)
    {
        foreach ($translationData as $languageId => $translatedAttributes) {
            $data                   = $translatedAttributes;
            $model->translations()->where('language_id', $languageId)->first()->update($data);
        }
    }
    // TODO:
    // Automate translation functionality in models too
    // ManyToMany with Language class
    // public function translate(Request $request, $id)
    // {
    //     $syncedTranslations = [];

    //     $modelName = mb_strtolower(class_basename($this->model));
    //     $modelName = str_replace('slave', '', $modelName);
    //     $modelName = str_replace('master', '', $modelName);

    //     $translations = $request->translations;

    //     foreach ($translations as $language => $translationValues) {
    //         $data = array_merge(
    //             $translationValues,
    //             [
    //                 'language_id' => $language,
    //                 $modelName . '_id'   => $id,
    //             ]
    //         );

    //         $syncedTranslations[] = $data;
    //     }

    //     return $syncedTranslations;
    // }
}
