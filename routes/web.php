<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    $router->post('doctor/{docId}/patient/opCosultation', 'DoctorApi@createOpConsultation');
    $router->get('doctor/patient/{docId}/opCosultation/{patientId}', 'DoctorApi@Opconsultationlist');

    /* Discharge summary */
    $router->post('doctor/{docId}/patient/DischargeSummary', 'DoctorApi@CreateDischargeSummary');
    $router->get('doctor/patient/{docId}/DischargeSummary/{patientId}', 'DoctorApi@DischargeSummaryList');


    /* Record Precription */
    $router->post('doctor/{docId}/patient/UploadRecordPrescription', 'DoctorApi@UploadRecordPrescription');
    $router->get('doctor/patient/{docId}/RecordPrescription/{patientId}', 'DoctorApi@RecordPrescriptionList');
});
