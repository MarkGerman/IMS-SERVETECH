<?php

namespace App\Helper;

use App\Models\ExamRecord;
use App\Models\Subject;
use App\Models\SubjectPaper;

Class Exam {


public static function getsubjectpaper($subject_id ,$level = null){
   return SubjectPaper::where("subject_id",$subject_id)->where("level_id",$level)->get();
}

public static function getRecord($term_id, $student_id){
   return ExamRecord::where("term_id",$term_id)->where('student_id',$student_id)->get();
}



}