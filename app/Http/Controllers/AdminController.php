<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(AdminsDataTable $dataTable){

        return $dataTable->render('admin.list');
    }
}
