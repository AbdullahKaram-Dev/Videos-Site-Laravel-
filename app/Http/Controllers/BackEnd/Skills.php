<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\BackEnd\Skills\Store;
use App\Models\Skill;

class Skills extends BackEndController
{
    public function __construct(Skill $model)
    {
        parent::__construct($model);
    }

    public function store(Store $request)
    {
        $this->model->create($request->all());

        return redirect()->route('skills.index');
    }

    public function update(Store $request,$id)
    {
        $row = $this->model->FindOrFail($id);

        $row->update($request->all());

        return redirect()->route('skills.edit',['id'=>$row->id]);

    }

}
