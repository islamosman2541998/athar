<?php
// app/Services/SearchService.php
namespace App\Services;


class SearchService
{
    public function search($queryParams , $model , $relationsArr , $modelCols , $relationCols )
    {


//        $companiesQuery = $model::query()
//            ->with(['departments.employees.projects', 'departments.employees.tasks']);
//
//        // Apply filters based on query parameters
//        if (!empty($queryParams['company_name'])) {
//            $companiesQuery->where('name', 'like', '%' . $queryParams['company_name'] . '%');
//        }
//
//        if (!empty($queryParams['department_name'])) {
//            $companiesQuery->whereHas('departments', function ($query) use ($queryParams) {
//                $query->where('name', 'like', '%' . $queryParams['department_name'] . '%');
//            });
//        }
//
//        if (!empty($queryParams['employee_name'])) {
//            $companiesQuery->whereHas('departments.employees', function ($query) use ($queryParams) {
//                $query->where('name', 'like', '%' . $queryParams['employee_name'] . '%');
//            });
//        }
//
//        if (!empty($queryParams['project_title'])) {
//            $companiesQuery->whereHas('departments.employees.projects', function ($query) use ($queryParams) {
//                $query->where('title', 'like', '%' . $queryParams['project_title'] . '%');
//            });
//        }
//
//        if (!empty($queryParams['task_description'])) {
//            $companiesQuery->whereHas('departments.employees.tasks', function ($query) use ($queryParams) {
//                $query->where('description', 'like', '%' . $queryParams['task_description'] . '%');
//            });
//        }
//
//        // Execute the query and get results
//        return $companiesQuery->get();


        $companiesQuery = $model::query()
            ->with($relationsArr);



        foreach($modelCols as $key1 => $val1){
            // Apply filters based on query parameters
            if (!empty($queryParams[$modelCols[$key1]])) {
                $companiesQuery->where($modelCols[$val1], 'like', '%' . $queryParams[$modelCols[$key1]] . '%');
            }
        }



        foreach($relationCols as $key2 => $val2) {

            if (!empty($queryParams[$relationCols[$key2]])) {
                $companiesQuery->whereHas('departments', function ($query) use ($queryParams) {
                    $query->where('name', 'like', '%' . $queryParams['department_name'] . '%');
                });
            }
        }

//        if (!empty($queryParams['employee_name'])) {
//            $companiesQuery->whereHas('departments.employees', function ($query) use ($queryParams) {
//                $query->where('name', 'like', '%' . $queryParams['employee_name'] . '%');
//            });
//        }
//
//        if (!empty($queryParams['project_title'])) {
//            $companiesQuery->whereHas('departments.employees.projects', function ($query) use ($queryParams) {
//                $query->where('title', 'like', '%' . $queryParams['project_title'] . '%');
//            });
//        }
//
//        if (!empty($queryParams['task_description'])) {
//            $companiesQuery->whereHas('departments.employees.tasks', function ($query) use ($queryParams) {
//                $query->where('description', 'like', '%' . $queryParams['task_description'] . '%');
//            });
//        }
//
        // Execute the query and get results
        return $companiesQuery->get();

    }
}
