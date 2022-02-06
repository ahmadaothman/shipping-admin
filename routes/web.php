<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeoLocationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ReportsController;

Route::get('get-address-from-ip',
[GeoLocationController::class, 'index']);

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics');
// Agents
Route::get('/agents', [AgentController::class, 'agentList'])->name('agents');
Route::get('/agents/add', [AgentController::class, 'agentForm'])->name('addAgent');
Route::post('/agents/add', [AgentController::class, 'agentForm'])->name('addAgent');
Route::get('/agents/edit', [AgentController::class, 'agentForm'])->name('editAgent');
Route::post('/agents/edit', [AgentController::class, 'agentForm'])->name('editAgent');
Route::post('/agents/remove', [AgentController::class, 'remove'])->name('removeAgents');
Route::get('/agents/search', [AgentController::class, 'search'])->name('search_agent');
// Branches
Route::get('/branches', [BranchController::class, 'branchList'])->name('branches');
Route::get('/branches/add', [BranchController::class, 'branchForm'])->name('addBranch');
Route::post('/branches/add', [BranchController::class, 'branchForm'])->name('addBranch');
Route::get('/branches/edit', [BranchController::class, 'branchForm'])->name('editBranch');
Route::post('/branches/edit', [BranchController::class, 'branchForm'])->name('editBranch');
Route::post('/branches/remove', [BranchController::class, 'remove'])->name('removeBranches');
// Regions
Route::get('/regions', [RegionController::class, 'list'])->name('regions');
Route::get('/regions/add', [RegionController::class, 'form'])->name('addRegion');
Route::post('/regions/add', [RegionController::class, 'form'])->name('addRegion');
Route::get('/regions/edit', [RegionController::class, 'form'])->name('editRegion');
Route::post('/regions/edit', [RegionController::class, 'form'])->name('editRegion');
Route::post('/regions/remove', [RegionController::class, 'remove'])->name('removeRegions');
// Cities
Route::get('/cities', [CityController::class, 'list'])->name('cities');
Route::get('/cities/add', [CityController::class, 'form'])->name('addCity');
Route::post('/cities/add', [CityController::class, 'form'])->name('addCity');
Route::get('/cities/edit', [CityController::class, 'form'])->name('editCity');
Route::post('/cities/edit', [CityController::class, 'form'])->name('editCity');
Route::post('/cities/remove', [CityController::class, 'remove'])->name('removeCities');
Route::get('/cities/regions', [CityController::class, 'regionBySate'])->name('regionsBySate');

// Users
Route::get('/users', [UserController::class, 'userList'])->name('users');
Route::get('/users/add', [UserController::class, 'userForm'])->name('addUser');
Route::post('/users/add', [UserController::class, 'userForm'])->name('addUser');
Route::get('/users/edit', [UserController::class, 'userForm'])->name('editUser');
Route::post('/users/edit', [UserController::class, 'userForm'])->name('editUser');
Route::post('/users/remove', [UserController::class, 'remove'])->name('removeUsers');
// Shipments
Route::get('/shipments', [ShipmentController::class, 'listShipment'])->name('shipments');
Route::post('/shipments', [ShipmentController::class, 'listShipment'])->name('shipments');

Route::get('/shipments/add', [ShipmentController::class, 'ShipmentForm'])->name('addShipment');
Route::post('/shipments/add', [ShipmentController::class, 'ShipmentForm'])->name('addShipment');
Route::get('/shipments/edit', [ShipmentController::class, 'ShipmentForm'])->name('editShipment');
Route::post('/shipments/edit', [ShipmentController::class, 'ShipmentForm'])->name('editShipment');
Route::post('/shipments/remove', [ShipmentController::class, 'remove'])->name('removeShipments');

Route::post('/shipments/removeShipment', [ShipmentController::class, 'removeShipment'])->name('removeShipment');

Route::get('/shipments/states', [ShipmentController::class, 'states'])->name('shippingCountryStates');
Route::get('/shipments/searchagents', [ShipmentController::class, 'searchAgent'])->name('shipmentSearchAgent');
Route::post('/shipments/importexcel', [ShipmentController::class, 'importExcel'])->name('importShipmentsExcel');
Route::post('/shipments/confirmExcel', [ShipmentController::class, 'confirmExcel'])->name('confirmShipmentExcel');
Route::get('/shipments/a4print', [ShipmentController::class, 'a4Print'])->name('ShipmentA4Print');
Route::get('/shipments/labelPrint', [ShipmentController::class, 'labelPrint'])->name('labelPrint');
Route::get('/shipments/cities', [ShipmentController::class, 'getCitiesByRegion'])->name('getCitiesByRegion');
Route::get('/shipments/checkReference', [ShipmentController::class, 'checkAgentReferenceStatus'])->name('check_reference');

Route::post('/shipments/cancel', [ShipmentController::class, 'cancel'])->name('cancelShipment');

Route::post('/shipments/email', [ShipmentController::class, 'emailShipments'])->name('emailShipments');
Route::post('/shipments/sms', [ShipmentController::class, 'smsShipments'])->name('smsShipments');

// invoices
Route::get('/invoices', [InvoiceController::class, 'list'])->name('invoices');
Route::get('/invoices/generate', [InvoiceController::class, 'generate'])->name('generate_invoice');
Route::post('/invoices/generate', [InvoiceController::class, 'generate'])->name('generate_invoice');
Route::get('/invoice', [InvoiceController::class, 'form'])->name('invoice');
Route::post('/invoice', [InvoiceController::class, 'form'])->name('invoice');
Route::get('/invoice/print', [InvoiceController::class, 'print'])->name('printInvoice');
Route::get('/invoice/pay', [InvoiceController::class, 'pay'])->name('payInvoice');
Route::get('/invoice/cancel', [InvoiceController::class, 'cancel'])->name('cancelInvoice');
Route::get('/invoice/remove', [InvoiceController::class, 'remove'])->name('removeInvoice');

// setting
Route::get('/setting', [SettingController::class, 'index'])->name('setting');
Route::post('/setting', [SettingController::class, 'index'])->name('setting');

// Expenses
Route::get('/expenses', [ExpensesController::class, 'expensesList'])->name('expenses');
Route::get('/expenses/add', [ExpensesController::class, 'expensesForm'])->name('addExpense');
Route::post('/expenses/add', [ExpensesController::class, 'expensesForm'])->name('addExpense');
Route::get('/expenses/edit', [ExpensesController::class, 'expensesForm'])->name('editExpense');
Route::post('/expenses/edit', [ExpensesController::class, 'expensesForm'])->name('editExpense');
Route::post('/expenses/remove', [ExpensesController::class, 'remove'])->name('removeExpenses');

// tracking 
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');

// charts
Route::get('/home/shipmentsChart', [HomeController::class, 'getShipmentsByMonthsChart'])->name('shipments_chart');

Route::get('/home/shipmentsRegionChart', [HomeController::class, 'getShipmentsByRegionsChart'])->name('shipments_by_region_chart');
// Reports
Route::get('/reports/revenue', [ReportsController::class, 'revenue'])->name('revenue_report');
