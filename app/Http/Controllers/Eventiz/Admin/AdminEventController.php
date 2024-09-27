<?php

namespace App\Http\Controllers\Eventiz\Admin;

use App\Models\User;
use App\Models\Event;
use App\Models\Company;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\EventSubcategory;
use App\Models\EventsViewStatus;
use App\Models\VendorCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
    //
    
    // Event Management

    public function adminEventList(){
        $events = Event::all();
        return view('eventinz_admin.events.list_events', compact('events'));
    }

    public function adminEventDetails(Request $request, $eventId){
        $event = Event::find($eventId);

        $eventTypes = EventType::all();
        $vendorCategories = VendorCategories::all();
        $companies = Company::all();
        $privateOrPublic = EventsViewStatus::all();
        $status = [
            'Yes',
            'No'
        ];
        $canceledEvents = [
            "Canceled", //'cancelstatus' if event canceled
            "Completed" //'cancelstatus' if event completed
        ];
        $is_pay_dones = [
            0, // 'Not yet',
            1 // 'Yes'  // paid
        ];

        // dd(json_decode($event->vendor_type_id));
        if (!$event) {
            return back()->with('error', 'Event not found');
        }
        if (!$event) {
            return back()->with('error', 'Event not found');
        }
        return view('eventinz_admin.events.details_event', compact('event','eventTypes','vendorCategories','companies','privateOrPublic','status','canceledEvents','is_pay_dones'));
    }

    public function adminEventUpdate(Request $request, $eventId){

        $event = Event::find($eventId);
    
        if (!$event) {
            return back()->with('error', 'Event not found');
        }
    
        $eventViewStatuses = EventsViewStatus::all();
        $publicId = null;
        foreach ($eventViewStatuses as $eventViewStatus) {
            if (strtolower($eventViewStatus->name) == strtolower("public")) {
                $publicId = $eventViewStatus->id;
                // dd($publicId);
            }
        }

        // try {
            
        $dataValidate =  $request->validate([
            'event_type_id' => 'required|integer',
            'vendor_type_id' => [
                'required',
                'array',
                'min:1',
            ],
            'duration' => 'required|string',
            'start_date' => 'required|date',
            'aprx_budget' => 'required|numeric|between:0,999999.99',
            'guest_number' => 'required|integer',
            'travel' => !empty($request->input('travel')) 
                ? 'required|string|min:2' 
                : 'nullable|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'subcategory' => 'nullable|string',
            'public_or_private' => 'required|integer',
            'description' => 'required|string|max:255',
            'is_pay_done' => 'nullable|boolean',
            'total_amount' => count($request->input('vendor_type_id')) > 1 
                ? 'required|numeric|regex:/^\d+(\.\d{1,2})?$/' 
                : 'nullable',
            'vendor_poke' => $request->input('public_or_private') == $publicId
                ? 'nullable' 
                : 'required',
                'cancelstatus' => 'required|string',
                'status' => 'required|string',
        ]);
        // } catch (\Throwable $th) {
        //     if ($request->input('public_or_private') != $publicId) {
        //         return back()->with('error', 'Validation Error, you want to make the event view status to Public, so '.$th->getMessage());
        //     }

        //     return back()->with('error', $th->getMessage());
        // }
        // json_encode

        $dataValidate['vendor_type_id'] = json_encode($dataValidate['vendor_type_id']);
        $dataValidate['vendor_type_id'] = str_replace('"', '',$dataValidate['vendor_type_id']);

        if ($request->vendor_poke) {
            $dataValidate['vendor_poke'] = json_encode($dataValidate['vendor_poke']);
            $dataValidate['vendor_poke'] = str_replace('"', '',$dataValidate['vendor_poke']);
        }
        
        // dd($dataValidate);
        if (empty($request->input('travel'))) {
            $dataValidate['travel'] = 'No';
        }
    
        $update = $event->update($dataValidate);
    
        return back()->with('success', 'Event has been updated!');
    }
    
    // Event Type Management
    public function eventTypeList(Request $request){
        $eventTypes = EventType::all();

        return view('eventinz_admin.event_type_management.list_event_type', compact('eventTypes'));
    }

    public function eventTypeEditForm(Request $request, $eventTypeId){
        $eventTypeFound = EventType::find($eventTypeId);
        if (!$eventTypeFound) {
            return back()->with('error', 'Event Type not found');
        }

        return view('eventinz_admin.event_type_management.edit_event_type', compact('eventTypeFound'));
    }
    
    public function eventTypeAddForm(Request $request){

        return view('eventinz_admin.event_type_management.create_event_type');
    }
    
    public function eventTypeAdd(Request $request){
        $dataValidation = $request->validate([
            'name'  =>  'required|string|max:255',
            'description'  =>  'required|string|max:255'
        ]);

        $creation = EventType::create($dataValidation);

        if (!$creation) {
            return back()->with('error', 'Failed to create event type');
        }

        return back()->with('success', 'Event Type created');
    }
        
    public function eventTypeUpdate(Request $request, $eventTypeId){
        $eventTypeFound = EventType::find($eventTypeId);
        if (!$eventTypeFound) {
            return back()->with('error', 'Event Type not found');
        }
        $dataValidation = $request->validate([
            'name'  =>  'required|string|max:255',
            'description'  =>  'required|string|max:255'
        ]);
        $update = $eventTypeFound->update($dataValidation);
        if (!$update) {
            return back()->with('error', 'Failed to update event type');
        }
        return back()->with('success', 'Event Type updated');
    }
    
    public function eventTypeDeleteForm(Request $request, $eventTypeId){
        $eventTypeFound = EventType::find($eventTypeId);
        if (!$eventTypeFound) {
            return back()->with('error', 'Event Type not found');
        }

        return view('eventinz_admin.event_type_management.delete_event_type', compact('eventTypeFound'));
    }

    public function eventTypeDelete(Request $request, $eventTypeId){
        $eventTypeFound = EventType::find($eventTypeId);

        if (!$eventTypeFound) {
            return back()->with('error', 'Event Type not found');
        }

        $eventTypeName = $eventTypeFound->name ?? "";
        $delete = $eventTypeFound->delete();

        return redirect()->route('admin.list.eventtypes')->with('success', 'Event Type '. $eventTypeName .' has been deleted');
    }
    
        
    // Event Subcategory Management 
    public function eventSubcategoryList(Request $request){
        $eventSubcategories = EventSubcategory::all();

        return view('eventinz_admin.event_subcategory_management.list_event_subcategory', compact('eventSubcategories'));
    }

    public function eventSubcategoryEditForm(Request $request, $eventSubcategoryId){
        $eventSubcategoryFound = EventSubcategory::find($eventSubcategoryId);
        $eventTypes = EventType::all();
        if (!$eventSubcategoryFound) {
            return back()->with('error', 'Event Subcategory not found');
        }

        return view('eventinz_admin.event_subcategory_management.edit_event_subcategory', compact('eventSubcategoryFound','eventTypes'));
    }
    
    public function eventSubcategoryAddForm(Request $request){
        $eventTypes = EventType::all();

        return view('eventinz_admin.event_subcategory_management.create_event_subcategory', compact('eventTypes'));
    }
    
    public function eventSubcategoryAdd(Request $request){
        $dataValidation = $request->validate([
            'name'  =>  'required|string|max:255',
            'description'  =>  'required|string|max:255',
            'event_types_id'  =>  'required|integer'
        ]);

        $dataValidation['created_by'] = Auth::user()->name;
        
        $creation = EventSubcategory::create($dataValidation);

        if (!$creation) {
            return back()->with('error', 'Failed to create event subcategory');
        }

        return back()->with('success', 'Event Subcategory created');
    }
        
    public function eventSubcategoryUpdate(Request $request, $eventSubcategoryId){
        $eventSubcategoryFound = EventSubcategory::find($eventSubcategoryId);
        if (!$eventSubcategoryFound) {
            return back()->with('error', 'Event Subcategory not found');
        }
        $dataValidation = $request->validate([
            'name'  =>  'required|string|max:255',
            'description'  =>  'required|string|max:255',
            'event_types_id'  =>  'required|integer'
        ]);
        $dataValidation['created_by'] = Auth::user()->name;

        $update = $eventSubcategoryFound->update($dataValidation);
        if (!$update) {
            return back()->with('error', 'Failed to update event subcategory');
        }
        return back()->with('success', 'Event Subcategory updated');
    }
    
    public function eventSubcategoryDeleteForm(Request $request, $eventSubcategoryId){
        $eventSubcategoryFound = EventSubcategory::find($eventSubcategoryId);
        if (!$eventSubcategoryFound) {
            return back()->with('error', 'Event Subcategory not found');
        }

        return view('eventinz_admin.event_subcategory_management.delete_event_subcategory', compact('eventSubcategoryFound'));
    }

    public function eventSubcategoryDelete(Request $request, $eventSubcategoryId){
        $eventSubcategoryFound = EventSubcategory::find($eventSubcategoryId);

        if (!$eventSubcategoryFound) {
            return back()->with('error', 'Event Subcategory not found');
        }
        $eventSubcategoryName = $eventSubcategoryFound->name ?? "";

        $delete = $eventSubcategoryFound->delete();

        return redirect()->route('admin.list.eventsubcategories')->with('success', 'Event Subcategory '. $eventSubcategoryName .' has been deleted');
    }

    // Events View Status Management | eventViewStatusList-eventViewStatusAddForm-eventViewStatusAdd-eventViewStatusEditForm-eventViewStatusUpdate-eventViewStatusDelete-eventViewStatusDeleteForm
    public function eventViewStatusList(Request $request){
        $eventViewStatuses = EventsViewStatus::all();

        return view('eventinz_admin.events_view_status_management.list_event_view_status', compact('eventViewStatuses'));
    }

    public function eventViewStatusEditForm(Request $request, $eventViewStatusId){
        $eventViewStatusFound = EventsViewStatus::find($eventViewStatusId); // EventsViewStatus
        if (!$eventViewStatusFound) {
            return back()->with('error', 'Event View Status not found');
        }

        return view('eventinz_admin.events_view_status_management.edit_event_view_status', compact('eventViewStatusFound'));
    }
    
    public function eventViewStatusAddForm(Request $request){

        return view('eventinz_admin.events_view_status_management.create_event_view_status');
    }
    
    public function eventViewStatusAdd(Request $request){
        $dataValidation = $request->validate([
            'name'  =>  'required|string|max:255',
            'description'  =>  'required|string|max:255',
            'price'  =>  'required|numeric|min:0'
        ]);
        // $dataValidation['created_by'] = Auth::user()->name;
        $dataValidation['price'] ?? 0;

        $creation = EventsViewStatus::create($dataValidation);

        if (!$creation) {
            return back()->with('error', 'Failed to create event event view status');
        }

        return back()->with('success', 'Event ViewStatus created');
    }
        
    public function eventViewStatusUpdate(Request $request, $eventViewStatusId){
        $eventViewStatusFound = EventsViewStatus::find($eventViewStatusId);
        if (!$eventViewStatusFound) {
            return back()->with('error', 'Event View Status not found');
        }
        $dataValidation = $request->validate([
            'name'  =>  'required|string|max:255',
            'description'  =>  'required|string|max:255',
            'price'  =>  'required|numeric|min:0'
        ]);
        // $dataValidation['created_by'] = Auth::user()->name;
        $dataValidation['price'] ?? 0;

        $update = $eventViewStatusFound->update($dataValidation);

        if (!$update) {
            return back()->with('error', 'Failed to update event View Status');
        }
        return back()->with('success', 'Event View Status updated');
    }
    
    public function eventViewStatusDeleteForm(Request $request, $eventViewStatusId){
        $eventViewStatusFound = EventsViewStatus::find($eventViewStatusId);
        if (!$eventViewStatusFound) {
            return back()->with('error', 'Event View Status not found');
        }

        return view('eventinz_admin.events_view_status_management.delete_event_view_status', compact('eventViewStatusFound'));
    }

    public function eventViewStatusDelete(Request $request, $eventViewStatusId){
        $eventViewStatusFound = EventsViewStatus::find($eventViewStatusId);

        if (!$eventViewStatusFound) {
            return back()->with('error', 'Event ViewStatus not found');
        }

        $eventViewStatusName = $eventViewStatusFound->name ?? "";
        $delete = $eventViewStatusFound->delete();

        return redirect()->route('admin.list.eventviewstatus')->with('success', 'Event ViewStatus '. $eventViewStatusName .' has been deleted');
    }
}
