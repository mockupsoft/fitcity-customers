<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\GroupClassController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\HealthScreeningController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsVerificationController;
use App\Http\Controllers\Api\NotificationController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/sayfa2', function () {
    return view('sayfa2');
})->name('sayfa2');

Route::get('/api/check-in/{groupClass}', [\App\Http\Controllers\QRController::class, 'processCheckIn']);
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/privacy-policy', function () {
    return view('utility.privacy-policy');
})->name('privacy.policy');

Route::get('/terms-of-service', function () {
    return view('utility.terms-of-service');
})->name('terms.service');
Route::get('/sms/verify', [SmsVerificationController::class, 'show'])->name('sms.verify.show');
Route::post('/sms/verify', [SmsVerificationController::class, 'verify'])->name('sms.verify.submit');
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/devices/register', [NotificationController::class, 'registerDevice'])->name('devices.register');
});
Route::middleware('auth')->group(function () {


    Route::get('/infos/gender', [UserInfoController::class, 'showGenderForm'])->name('infos.gender');
    Route::post('/infos/gender', [UserInfoController::class, 'storeGender'])->name('infos.gender.store');
    Route::get('/infos/interests', [UserInfoController::class, 'showInterestForm'])->name('infos.interests');
    Route::post('/infos/interests', [UserInfoController::class, 'storeInterests'])->name('infos.interests.store');
    Route::get('/infos/body-type', [UserInfoController::class, 'showBodyTypeForm'])->name('infos.body-type');
    Route::post('/infos/body-type', [UserInfoController::class, 'storeBodyType'])->name('infos.body-type.store');
    Route::get('/infos/goals', [UserInfoController::class, 'showGoalForm'])->name('infos.goals');
    Route::post('/infos/goals', [UserInfoController::class, 'storeGoals'])->name('infos.goals.store');
    Route::get('/infos/focus', [UserInfoController::class, 'showFocusForm'])->name('infos.focus');
    Route::post('/infos/focus', [UserInfoController::class, 'storeFocus'])->name('infos.focus.store');
    Route::get('/infos/step-goal', [UserInfoController::class, 'showStepGoalForm'])->name('infos.step-goal');
    Route::post('/infos/step-goal', [UserInfoController::class, 'storeStepGoal'])->name('infos.step-goal.store');
    Route::get('/infos/habits', [UserInfoController::class, 'showHabitForm'])->name('infos.habits');
    Route::post('/infos/habits', [UserInfoController::class, 'storeHabits'])->name('infos.habits.store');
    Route::get('/infos/habit-info', [UserInfoController::class, 'showHabitInfoPage'])->name('infos.habit-info');
    Route::get('/infos/target-areas', [UserInfoController::class, 'showTargetAreaForm'])->name('infos.target-areas');
    Route::post('/infos/target-areas', [UserInfoController::class, 'storeTargetAreas'])->name('infos.target-areas.store');
    Route::get('/infos/body-metrics', [UserInfoController::class, 'showBodyMetricsForm'])->name('infos.body-metrics');
    Route::post('/infos/body-metrics', [UserInfoController::class, 'storeBodyMetrics'])->name('infos.body-metrics.store');
    Route::get('/infos/fitness-summary', [UserInfoController::class, 'showFitnessSummary'])->name('infos.fitness-summary');
    Route::get('/infos/plan-summary', [UserInfoController::class, 'showPlanSummary'])->name('infos.plan-summary');
    Route::get('/infos/subscription', [UserInfoController::class, 'showSubscriptionPage'])->name('infos.subscription');
    Route::get('/get-code', [DiscountCodeController::class, 'index'])->name('code.index');
    Route::post('/generate-code', [DiscountCodeController::class, 'generateAndStore'])->name('code.generate');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/coming-soon', function () {
        return view('utility.coming-soon');
    })->name('coming-soon');

    Route::get('/group-classes', [GroupClassController::class, 'index'])->name('group-classes.index');
    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
    Route::get('/trainers/{trainer}', [TrainerController::class, 'show'])->name('trainers.show');

    Route::get('/booking', [ReservationController::class, 'calendar'])->name('booking.calendar');

    Route::post('/group-classes/{groupClass}/join', [GroupClassController::class, 'join'])->name('group-classes.join');
    Route::get('/reservations/private-lesson/select-trainer', [ReservationController::class, 'selectTrainerForPrivateLesson'])->name('reservations.private-lesson.select-trainer');
    Route::post('/reservations/private-lesson', [ReservationController::class, 'storePrivateLesson'])->name('reservations.private-lesson.store');
    Route::post('/workouts/{workout}/increment-view', [WorkoutController::class, 'incrementViewCount'])->name('workouts.increment_view');
    Route::get('/my-program/{program}', [ProgramController::class, 'show'])->name('program.show');

    Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    Route::get('/workouts/{category:slug}', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/workouts', [WorkoutController::class, 'allWorkouts'])->name('workouts.all');

    Route::get('/reservations/measurement/select-trainer', [ReservationController::class, 'selectTrainerForMeasurement'])->name('reservations.measurement.select-trainer');
    Route::post('/reservations/measurement', [ReservationController::class, 'storeMeasurement'])->name('reservations.measurement.store');

    Route::get('/profile/subscription', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/measurements', [ProfileController::class, 'measurements'])->name('profile.measurements');
    Route::get('/qr', [QRController::class, 'index'])->name('qr.index');
    Route::get('/qr/scan', [QRController::class, 'scanner'])->name('qr.scan');


    Route::delete('/profile/delete', [ProfileController::class, 'destroyAccount'])->name('profile.destroy_account');

    Route::get('/health-screening/start', [HealthScreeningController::class, 'start'])
        ->name('health-screening.start');

    Route::post('/health-screening/parq', [HealthScreeningController::class, 'storeParq'])
        ->name('health-screening.storeParq');

    // 2. Başarısız / Sağlık Raporu Uyarısı
    Route::get('/health-screening/failed', [HealthScreeningController::class, 'failed'])
        ->name('health-screening.failed');

    // 3. ACSM Formu
    Route::get('/health-screening/acsm', [HealthScreeningController::class, 'acsmForm'])
        ->name('health-screening.acsm');

    Route::post('/health-screening/acsm', [HealthScreeningController::class, 'storeAcsm'])
        ->name('health-screening.storeAcsm');


});
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
require __DIR__.'/auth.php';
