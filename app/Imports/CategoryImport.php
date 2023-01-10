<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $data)
    {
        foreach($data as $row) {
           $check = Category::where('name',$row)->first();
           if (empty($check)) {
              return new Category([
                 'name' => $row,
                 ]);
           } 
       }
    }
}
