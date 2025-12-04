<?php

namespace App\Helper;

use App\Models\AcademicYear;
use App\Models\Book;
use Auth;

Class Helper {

    
    public static function getBookDetails($id){
       return  Book::find($id);
    }

    public static function getCurrentAcademicYear(){
        $data = [];
        if(empty(Auth::user()->academic_year_id)){
          $data =  AcademicYear::with('academic_terms')->where('is_current','true')->first();
        }else{
            $data =  AcademicYear::with('academic_terms')->where('id',Auth::user()->academic_year_id)->first();
        }
        return $data;
    } 
    

}