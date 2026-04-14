<?php

namespace App\Http\Controllers;

use App\Models\inventaris;
use App\Models\categories;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(){
        
        return view("inventaris.index");
    }

}
