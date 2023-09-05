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
    /* patient under patient*/
    $router->get('doctor/{esteblishmentusermapID}/patientList', 'DoctorApi@getPatientList');
    $router->post('doctor/{esteblishmentusermapID}/patientRegister', 'DoctorApi@createPatient');

    /* diagnostic report */
    $router->post('doctor/{docId}/createDiagnosticReport/{patientId}', 'DoctorApi@createDiagnosticReport');
    $router->get('doctor/{docId}/dignosticReportList/{patientId}', 'DoctorApi@getDiagnosticList');

    /* OP consultation */
    $router->post('doctor/{docId}/opCosultation/{patientId}', 'DoctorApi@createOpConsultation');
    $router->get('doctor/{docId}/opCosultation/{patientId}', 'DoctorApi@Opconsultationlist');

    /* Discharge summary */
    $router->post('doctor/{docId}/DischargeSummary/{patientId}', 'DoctorApi@CreateDischargeSummary');
    $router->get('doctor/{docId}/DischargeSummary/{patientId}', 'DoctorApi@DischargeSummaryList');


    /* Record Precription */
    $router->post('doctor/{docId}/UploadRecordPrescription/{patientId}', 'DoctorApi@UploadRecordPrescription');
    $router->get('doctor/{docId}/UploadRecordPrescription/{patientId}', 'DoctorApi@RecordPrescriptionList');

    // view past clinical history
    $router->get('doctor/{docId}/viewPastClinicalHistory/{patientId}', 'DoctorApi@viewPastClinicalHistory');



});
