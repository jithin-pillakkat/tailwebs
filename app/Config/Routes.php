<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->group('', ['filter' => 'auth:Guest'], static function ($routes) {
    $routes->get('/', 'TeacherController::login', ['as' => 'login']);
    $routes->post('login', 'TeacherController::loginHandler', ['as' => 'login.handler']);
});

$routes->group('', ['filter' => 'auth:Teacher'], static function ($routes) {
    $routes->get('logout', 'TeacherController::logout', ['as' => 'logout']);

    $routes->get('students', 'StudentController::index', ['as' => 'student.index']);
    $routes->get('student-list', 'StudentController::list', ['as' => 'student.list']);
    $routes->post('student-save', 'StudentController::save', ['as' => 'student.save']);
    $routes->post('student-action', 'StudentController::action', ['as' => 'student.action']);

    $routes->get('normal-table', 'StudentController::normalTable', ['as' => 'normal.table']);
    $routes->post('normal-action', 'StudentController::normalTableAction', ['as' => 'normal.table.action']);
});
