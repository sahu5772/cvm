<?php

namespace App\Http\Controllers;

use App\Models\NotificationRecord;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NotificationRecord::company()->get();
            return datatables()::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="editCategory('.$row->id.')" >Edit</a>';
                    return $actionBtn;
                })
                ->editColumn('name', function($data) {
                    return ucfirst($data->name);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('notification.index');
    }
}
