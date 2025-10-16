<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(\Illuminate\Http\Request $r){
    $q = \App\Models\Shipment::query()->with('warehouse');
    if ($r->filled('warehouse_id')) $q->where('warehouse_id',$r->warehouse_id);
    if ($r->filled('status')) $q->where('status',$r->status);
    return response()->json($q->get());
}
public function show($id){ return response()->json(\App\Models\Shipment::with('packages')->findOrFail($id)); }
public function store(\Illuminate\Http\Request $r){
    $data = $r->validate([
        'warehouse_id'=>'required|exists:warehouses,id',
        'status'=>'in:created,in_transit,delivered,canceled'
    ]);
    $data['user_id'] = auth('api')->id();
    $s = \App\Models\Shipment::create($data);
    return response()->json($s, 201);
}
public function update(\Illuminate\Http\Request $r, $id){
    $s = \App\Models\Shipment::findOrFail($id);
    $data = $r->validate([
        'status'=>'in:created,in_transit,delivered,canceled',
        'warehouse_id'=>'exists:warehouses,id'
    ]);
    $s->update($data);
    return response()->json($s);
}
public function destroy($id){
    $s = \App\Models\Shipment::findOrFail($id);
    if ($s->status !== 'created') {
        return response()->json(['error'=>'Only "created" shipments can be deleted'], 400);
    }
    $s->delete();
    return response()->noContent(); // 204
}

// HIERARCHINIS: visos pakuotės konkrečiai siuntai
public function packages($id){
    $s = \App\Models\Shipment::findOrFail($id);
    return response()->json($s->packages);
}

}
