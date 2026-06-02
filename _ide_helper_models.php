<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property \App\Enum\Application\ApplicationStatusEnum $status
 * @property \Illuminate\Support\Carbon $applied_at
 * @property int $student_id
 * @property int $internship_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Internship|null $internship
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereAppliedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereInternshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $company_name
 * @property string $company_logo_path
 * @property string $description
 * @property string $region
 * @property string $city
 * @property string|null $website
 * @property bool $is_verified
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Internship> $internship
 * @property-read int|null $internship_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $report
 * @property-read int|null $report_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCompanyLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course withoutTrashed()
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $requirements
 * @property string $region
 * @property \App\Enum\Internship\InternshipSetupEnum $setup
 * @property \App\Enum\Internship\InternshipAllowanceEnum $allowance
 * @property int $duration
 * @property \App\Enum\Internship\InternshipDurationUnitEnum $duration_unit
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $application
 * @property-read int|null $application_count
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skill> $internshipSkill
 * @property-read int|null $internship_skill_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereDurationUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereSetup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Internship withoutTrashed()
 */
	class Internship extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $internship_id
 * @property int $skill_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill whereInternshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternshipSkill whereUpdatedAt($value)
 */
	class InternshipSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reports
 * @property-read int|null $reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reason withoutTrashed()
 */
	class Reason extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $description
 * @property \App\Enum\Report\ReportStatusEnum $status
 * @property string|null $admin_notes
 * @property int $reporter_user_id
 * @property string $reportable_type
 * @property int $reportable_id
 * @property \Illuminate\Support\Carbon $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reason> $reasons
 * @property-read int|null $reasons_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reportable
 * @property-read \App\Models\User $reporter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReportableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereReporterUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Report whereUpdatedAt($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $report_id
 * @property int $reason_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason whereReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportReason whereUpdatedAt($value)
 */
	class ReportReason extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InternshipSkill> $internshipSkill
 * @property-read int|null $internship_skill_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentSkill> $studentSkill
 * @property-read int|null $student_skill_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Skill withoutTrashed()
 */
	class Skill extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $profile_picture_path
 * @property string $school
 * @property string $region
 * @property string $city
 * @property string|null $resume_path
 * @property string $cellphone_number
 * @property int $user_id
 * @property int|null $course_id
 * @property string|null $course_other
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $application
 * @property-read int|null $application_count
 * @property-read \App\Models\User|null $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $report
 * @property-read int|null $report_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Skill> $skill
 * @property-read int|null $skill_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCellphoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCourseOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereProfilePicturePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereResumePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUserId($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $skill_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSkill whereUpdatedAt($value)
 */
	class StudentSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property \App\Enum\User\UserStatusEnum $status
 * @property \App\Enum\User\UserRoleEnum $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $report
 * @property-read int|null $report_count
 * @property-read \App\Models\Student|null $student
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

