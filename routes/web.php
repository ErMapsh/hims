<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\PatientApi;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'Controller@heartbeat');

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    //doctor

    // patient
    $router->get('doctor/{docId}/patients', 'DoctorApi@index');
    $router->post('doctor/{docId}/patientRegister', 'DoctorApi@createPatient');

     /* diagnostic report */
    $router->post('doctor/{docId}/createDiagnosticReport','DoctorApi@createDiagnosticReport');
    $router->get('doctor/dignosticReport/{patientId}', 'DoctorApi@diagnosticlist');

    /* OP consultation */
    $router->post('doctor/{docId}/patient/opCosultation', 'DoctorApi@createOpConsultation');
    $router->get('doctor/patient/opCosultation/{patientId}', 'DoctorApi@Opconsultationlist');

    /* Discharge summary */
    $router->post('doctor/{docId}/patient/DischargeSummary', 'DoctorApi@CreateDischargeSummary');
    $router->get('doctor/patient/DischargeSummary/{patientId}', 'DoctorApi@DischargeSummaryList');
});
