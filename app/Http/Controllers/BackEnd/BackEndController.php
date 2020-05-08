<?php

namespace App\Http\Controllers\BackEnd;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class BackEndController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {

    $this->model=$model;
    }

    public function index()
    {
        $rows = $this->model;
        $rows = $this->filter($rows);
        $with = $this->with();
        if(!empty($with)){

            $rows = $rows->with($with);
        }
        $rows = $rows->paginate(10);

        $moduleName = $this->pluralModelName();
        $sModuleName = $this->getModelName();
        $routeName = $this->getClassNameFromModel();

        $pageTitle = 'Control '. $moduleName;
        $pageDes = 'Here You Can Add / Edit / Delete / '. $moduleName;


        return view('back-end.' .$this->getClassNameFromModel(). '.index',compact(
            'rows',
                 'pageTitle',
                    'pageDes',
                    'moduleName',
                    'sModuleName',
                    'routeName'
        ));
    }

    public function create()
    {
        $moduleName = $this->getModelName();
        $pageTitle = 'Create '. $moduleName;
        $pageDes = 'Here You Can Create '.$moduleName;
        $folderName = $this->getClassNameFromModel();
        $routeName = $folderName;
        $append = $this->append();


        return view('back-end.'.$folderName.'.create',compact(

      'pageTitle',
            'pageDes',
               'moduleName',
               'folderName',
                'routeName'
        ))->with($append);

    }

    public function destroy($id)
    {
        $this->model->FindOrFail($id)->delete();
        return redirect()->route($this->getClassNameFromModel().'.index');

    }

    public function edit($id)
    {
        $row = $this->model->FindOrFail($id);

        $moduleName = $this->getModelName();
        $pageTitle ='Edit '. $moduleName;
        $pageDes = 'Here You Can Edit '. $moduleName;
        $folderName = $this->getClassNameFromModel();
        $routeName = $folderName;
        $append = $this->append();


        return view('back-end.'.$folderName.'.edit',compact(
            'row',
                 'pageTitle',
                    'pageDes',
                    'moduleName',
                    'folderName',
                    'routeName'
        ))->with($append);

    }

    protected function filter($rows)
    {
        return $rows;

    }

    protected function with()
    {

        return [];



    }

    protected function getClassNameFromModel()
    {
        return strtolower($this->pluralModelName());

    }

    protected function pluralModelName()
    {
       return str_plural($this->getModelName());

    }

    protected function getModelName()
    {

        return class_basename($this->model);
    }

    protected function append()
    {

        return [];
    }
}