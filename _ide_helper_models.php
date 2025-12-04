<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AcademicTerm
 *
 * @property int $id
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property int $academic_year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear|null $academic_year
 * @property-read \App\Models\Payment|null $payment
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicTerm whereUpdatedAt($value)
 */
	class AcademicTerm extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AcademicYear
 *
 * @property int $id
 * @property string $start_date
 * @property string|null $end_date
 * @property string|null $is_current
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYear whereUpdatedAt($value)
 */
	class AcademicYear extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AcademicYearStudentLog
 *
 * @property int $id
 * @property string $student_id
 * @property string $academic_year_id
 * @property string $classroom_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear|null $academicyear
 * @property-read \App\Models\Classroom|null $classroom
 * @property-read \App\Models\User|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcademicYearStudentLog whereUpdatedAt($value)
 */
	class AcademicYearStudentLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $student_id
 * @property int $classroom_id
 * @property string $date
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string $isbn
 * @property string $author
 * @property float $price
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 */
	class Book extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookBorrow
 *
 * @property int $id
 * @property int $borrow_session_id
 * @property int $book_id
 * @property string $status
 * @property string $librarian_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Book|null $book
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereBorrowSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereLibrarianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookBorrow whereUpdatedAt($value)
 */
	class BookBorrow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BorrowSession
 *
 * @property int $id
 * @property int $student_id
 * @property int $number_of_days
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property string $librarian_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereLibrarianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereNumberOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BorrowSession whereUpdatedAt($value)
 */
	class BorrowSession extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chat
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ChatMessage
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatMessage whereUpdatedAt($value)
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClassLevel
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassLevel whereUpdatedAt($value)
 */
	class ClassLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClassRoomType
 *
 * @property int $id
 * @property string $name
 * @property int $level_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Classroom> $classrooms
 * @property-read int|null $classrooms_count
 * @property-read \App\Models\ClassLevel|null $level
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassRoomType whereUpdatedAt($value)
 */
	class ClassRoomType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ClassTimeTable
 *
 * @property int $id
 * @property int $classroom_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassTimeTable whereUpdatedAt($value)
 */
	class ClassTimeTable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Classroom
 *
 * @property int $id
 * @property string $name
 * @property int|null $teacher_id
 * @property int $classroom_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClassRoomType|null $classroomtype
 * @property-read \App\Models\ClassRoomType|null $crt
 * @property-read \App\Models\User|null $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereClassroomTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classroom whereUpdatedAt($value)
 */
	class Classroom extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExamTimeTable
 *
 * @property int $id
 * @property string $hours
 * @property string $min
 * @property string $date
 * @property int $term_id
 * @property int $subject_id
 * @property int $level_id
 * @property string $start_time
 * @property int $paper_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClassLevel|null $level
 * @property-read \App\Models\SubjectPaper|null $paper
 * @property-read \App\Models\Subject|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable wherePaperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExamTimeTable whereUpdatedAt($value)
 */
	class ExamTimeTable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Feature
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
 */
	class Feature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Grade
 *
 * @property int $id
 * @property string $name
 * @property string $mark_from
 * @property string $mark_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Grade query()
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereMarkFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereMarkTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Grade whereUpdatedAt($value)
 */
	class Grade extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mobile
 *
 * @property int $id
 * @property int $user_id
 * @property string $number
 * @property string $phone_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile wherePhoneType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mobile whereUserId($value)
 */
	class Mobile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $name
 * @property string|null $classtype_id
 * @property int $amount
 * @property int $academic_year_id
 * @property int $academic_term_id
 * @property string|null $desc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYear|null $ay
 * @property-read \App\Models\Classroom|null $classroom
 * @property-read \App\Models\ClassRoomType|null $classroomtype
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentRecord> $pay_records
 * @property-read int|null $pay_records_count
 * @property-read \App\Models\AcademicTerm|null $term
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAcademicTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereClasstypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentRecord
 *
 * @property int $id
 * @property int $payment_id
 * @property int $student_id
 * @property int $parent_id
 * @property string $date
 * @property string $amount
 * @property string $payment_type
 * @property string|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentRecord whereUpdatedAt($value)
 */
	class PaymentRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $system_title
 * @property string $system_phone
 * @property string $system_address
 * @property string $email
 * @property string $logo
 * @property string $bank_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereBankDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSystemAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSystemPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSystemTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slot
 *
 * @property int $id
 * @property string $start
 * @property string|null $end
 * @property string|null $day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereUpdatedAt($value)
 */
	class Slot extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SlotSubject
 *
 * @property int $id
 * @property int $slot_id
 * @property int $teacher_id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject whereSlotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SlotSubject whereUpdatedAt($value)
 */
	class SlotSubject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Student
 *
 * @property int $id
 * @property string $name
 * @property string $dob
 * @property int $parent_id
 * @property string $gender
 * @property int|null $classroom_id
 * @property string|null $cover
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classroom|null $classroom
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StudentParent
 *
 * @property int $id
 * @property int $student_id
 * @property int $parent_id
 * @property string|null $guardian_role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $parent
 * @property-read \App\Models\User|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereGuardianRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereUpdatedAt($value)
 */
	class StudentParent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subject
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubjectPaper> $papers
 * @property-read int|null $papers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subject whereUpdatedAt($value)
 */
	class Subject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubjectPaper
 *
 * @property int $id
 * @property string $paper
 * @property string $level_id
 * @property int $subject_id
 * @property int $classroom_type_id
 * @property int $mark
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereClassroomTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper wherePaper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectPaper whereUpdatedAt($value)
 */
	class SubjectPaper extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubjectTeacherClass
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubjectTeacherClass whereUpdatedAt($value)
 */
	class SubjectTeacherClass extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string|null $gender
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $academic_yea_id
 * @property string $status
 * @property string|null $dob
 * @property int|null $level_id
 * @property int|null $academic_log_id
 * @property string|null $nationality
 * @property string|null $address
 * @property string|null $occupation
 * @property int|null $subject_id
 * @property string|null $medical_issues
 * @property string|null $emergency_contact
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AcademicYearStudentLog|null $academiclog
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AcademicYearStudentLog> $academiclogs
 * @property-read int|null $academiclogs_count
 * @property-read \App\Models\Classroom|null $classroom
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mobile> $mobiles
 * @property-read int|null $mobiles_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentParent> $parent
 * @property-read int|null $parent_count
 * @property-read \App\Models\StudentParent|null $student
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAcademicLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAcademicYeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMedicalIssues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

