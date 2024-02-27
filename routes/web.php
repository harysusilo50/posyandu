<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Inventory\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\Machine\MachineController as AdminMachineController;
use App\Http\Controllers\Admin\Task\TaskController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\Inventory\InventoryController;
use App\Http\Controllers\Pages\Inventory\WeeklyBreakageController;
use App\Http\Controllers\Pages\Loan\LoanController;
use App\Http\Controllers\Pages\Machine\DailyScoopController;
use App\Http\Controllers\Pages\Machine\HighTempMachineController;
use App\Http\Controllers\Pages\Machine\IceMachineController;
use App\Http\Controllers\Pages\Machine\ManualPotSinkController;
use App\Http\Controllers\Pages\TaskList\TaskListController;
use App\Http\Controllers\Pages\User\VerifyController;
use App\Models\HighTempMachine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('admin/login', [LoginController::class, 'showLoginFormAdmin'])->name('admin.login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user-verify-account', [VerifyController::class, 'not_verified'])->name('user.not_verified');
    Route::post('/user-send-verify-account', [VerifyController::class, 'user_send_verify'])->name('user.send.verify');
    Route::group(['middleware' => 'check.verify'], function () {
        Route::get('/', [HomeController::class, 'index']);
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::group(['prefix' => 'inventory'], function () {
            Route::get('/inventory-ware-list', [InventoryController::class, 'inventoryWareList'])->name('inventory.warelist');
            Route::get('/inventory-chemical-list', [InventoryController::class, 'inventoryChemicalList'])->name('inventory.chemicallist');
            Route::get('/input', [InventoryController::class, 'createInventory'])->name('inventory.input');
            Route::post('/input', [InventoryController::class, 'storeInventory'])->name('inventory.store');
            Route::get('/update/{id}', [InventoryController::class, 'editInventory'])->name('inventory.edit');
            Route::post('/update/{id}', [InventoryController::class, 'updateInventory'])->name('inventory.update');
            Route::get('/show', [InventoryController::class, 'showInventory'])->name('inventory.show');
            Route::resource('/weekly-breakage', WeeklyBreakageController::class);
        });
        Route::group(['prefix' => 'machine'], function () {
            Route::resource('/manual-pot-sink', ManualPotSinkController::class);
            Route::get('detail-log/manual-pot-sink', [ManualPotSinkController::class, 'detail'])->name('manual-pot-sink.detail');
            Route::resource('/high-temp-dish-machine', HighTempMachineController::class);
            Route::get('detail-log/high-temp-dish-machine', [HighTempMachineController::class, 'detail'])->name('high-temp-dish-machine.detail');
            Route::resource('/ice-machine-cleaning', IceMachineController::class);
            Route::get('detail-log/ice-machine-cleaning', [IceMachineController::class, 'detail'])->name('ice-machine-cleaning.detail');
            Route::resource('/daily-scoop', DailyScoopController::class);
            Route::get('detail-log/daily-scoop', [DailyScoopController::class, 'detail'])->name('daily-scoop.detail');
        });
        Route::group(['prefix' => 'loan'], function () {
            Route::get('/', [LoanController::class, 'index'])->name('loan.index');
            Route::get('/borrowing-form', [LoanController::class, 'borrowing_form'])->name('loan.borrowing_form');
            Route::get('/returning-form', [LoanController::class, 'returning_form'])->name('loan.returning_form');
            Route::post('/borrowing-store', [LoanController::class, 'borrowing_store'])->name('loan.borrowing_store');
            Route::post('/returning-store', [LoanController::class, 'returning_store'])->name('loan.returning_store');
        });
        Route::resource('/task-list', TaskListController::class);
        Route::get('/task-list/check-grading/{task_id}', [TaskListController::class, 'check_grade_link'])->name('check.grade');
    });
});

Route::group(['middleware' => ['auth', 'check.admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/home', [DashboardController::class, 'index'])->name('admin.home');

    // User
    Route::get('/user-all', [UserController::class, 'all'])->name('user.all');
    Route::resource('/user', UserController::class);
    Route::get('/verification-list-user', [UserController::class, 'list_verify'])->name('user.list-verify');
    Route::post('/verify-user', [UserController::class, 'verify_user'])->name('user.verify_user');
    Route::post('/reject-user', [UserController::class, 'reject_user'])->name('user.reject_user');

    // Task
    Route::resource('/task', TaskController::class);
    Route::post('/task/correction-submission', [TaskController::class, 'correction_submition'])->name('task.correction');
    Route::get('/task-link/{id}', [TaskController::class, 'show_link'])->name('task.show-link');
    Route::post('/task-link/grading-link', [TaskController::class, 'add_grading_link'])->name('task.add_grading_link');
    Route::get('/export-excel/task/{task_id}', [TaskController::class, 'export_grade_excel'])->name('export.excel');

    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/settings', [AdminInventoryController::class, 'settings'])->name('admin.inventory.settings');
        Route::post('/settings/slide', [AdminInventoryController::class, 'update_slide_link'])->name('admin.inventory.slide');
        Route::post('/delete/{id}', [AdminInventoryController::class, 'destroy'])->name('admin.inventory.destroy');
    });
    Route::group(['prefix' => 'machine'], function () {
        Route::group(['prefix' => 'settings'], function () {
            Route::get('/', [AdminMachineController::class, 'settings'])->name('admin.machine.settings');
            Route::get('/manual-pot-sink', [AdminMachineController::class, 'manual_pot_sink'])->name('admin.machine.settings.manual_pot_sink');
            Route::get('/high-temp-dish-machine', [AdminMachineController::class, 'high_temp_dish_machine'])->name('admin.machine.settings.high_temp_dish_machine');
            Route::get('/ice-machine-cleaning', [AdminMachineController::class, 'ice_machine_cleaning'])->name('admin.machine.settings.ice_machine_cleaning');
            Route::get('/daily-scoop', [AdminMachineController::class, 'daily_scoop'])->name('admin.machine.settings.daily_scoop');
        });
        Route::post('/upload-description', [AdminMachineController::class, 'upload_description'])->name('admin.machine.upload_description');
        Route::post('/upload-image', [AdminMachineController::class, 'upload_image'])->name('admin.machine.upload_image');
        Route::post('/delete-image', [AdminMachineController::class, 'delete_image'])->name('admin.machine.delete_image');
    });
});

Route::group(['prefix' => 'datatable/'], function () {
    Route::get('task', [TaskController::class, 'datatable_task'])->name('datatable.task');
    Route::get('weekly-breakage', [WeeklyBreakageController::class, 'datatable_weekly_breakage'])->name('datatable.weekly_breakage');
    Route::get('daily-scoop', [DailyScoopController::class, 'datatable_daily_scoop'])->name('datatable.daily-scoop');
    Route::get('ice-machine', [IceMachineController::class, 'datatable_ice_machine'])->name('datatable.ice-machine');
    Route::get('manual-pot-sink', [ManualPotSinkController::class, 'datatable_manual_pot_sink'])->name('datatable.manual-pot-sink');
    Route::get('high-temp-dish-machine', [HighTempMachineController::class, 'datatable_high_temp'])->name('datatable.high-temp-dish-machine');
    Route::get('loan', [LoanController::class, 'datatable_loan'])->name('datatable.loan');
    Route::get('user', [UserController::class, 'datatable_user'])->name('datatable.user');
    Route::get('user-all', [UserController::class, 'datatable_user_all'])->name('datatable.user.all');
});
