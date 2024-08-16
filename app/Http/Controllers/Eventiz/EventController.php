<?php

namespace App\Http\Controllers\Eventiz;

use Carbon\Carbon;
use App\Models\Event;
use App\Mail\SuccessMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    //

    public function createEventForm(Request $request){

        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        if($user && $user->role_id == 1){
            return response()->json([
                'message'=> 'Success',
                'success'=> 'You\'re able to fill the fields then create your event!'
            ], 402);

            // return view('eventiz.event.create');
        }else{
            return response()->json([
                'message'=> 'Error',
                'error'=> 'You\'re not authorised to do this action!'
            ], 402);
        }
        
    }

    public function storeEvent(Request $request)
{
    // Récupérer l'utilisateur authentifié
    $user = $request->user();

    if ($user && $user->role_id == 1) {
        try {
            $request->validate([
                'event_type_id' => 'required|integer',
                'vendor_type_id' => [
                    'required',
                    'array',
                    'min:1',
                ],
                'duration' => 'required|string',
                'start_date' => 'required|date_format:d/m/Y',
                'end_date' => 'required|date_format:d/m/Y',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'subcategory' => 'nullable|string',
                'public_or_private' => 'required|integer',
                'description' => 'required|string|max:255',
                // 'vendor_poke' => 'nullable|string',
                // 'total_amount' => 'required|numeric|between:0,999999.99',
                'is_pay_done' => 'nullable|boolean',
            ]);

            // Validation conditionnelle basée sur la taille de 'vendor_type_id'
            if (count($request->input('vendor_type_id')) > 1) {
                $request->validate([
                    'total_amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
                ]);
            } else {
                $request->validate([
                    'total_amount' => 'nullable'
                ]);
            }

            if ($request->input('public_or_private') == 0) {
                $request->validate([ 
                    'vendor_poke' => 'nullable',
                ]);
                //
            } else {
                $request->validate([ 
                    'vendor_poke' => 'required',
                ]);
            }
            


            $is_pay_done = $request->input('is_pay_done', 0);

            $event = Event::create([
                'user_id' => $user->id,
                'event_type_id' => $request->event_type_id,
                'vendor_type_id' => json_encode($request->vendor_type_id),
                'duration' => $request->duration,
                'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'subcategory' => $request->subcategory,
                'public_or_private' => $request->public_or_private,
                'description' => $request->description,
                'vendor_poke' => $request->vendor_poke,
                'total_amount' => $request->total_amount,
                'is_pay_done' => $is_pay_done,
            ]);

            $successMsg = 'Your event was created successfully! You will receive a confirmation email shortly.';

            // Envoyer un mail de confirmation
            // Mail::to($user->email)->send(new SuccessMail($successMsg));
            return response()->json([
                'message' => 'Success',
                'success' => 'Event created successfully!'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422); // Code 422 pour les erreurs de validation
        }
    } else {
        return response()->json([
            'message' => 'Unauthorized',
            'error' => 'You are not authorized to perform this action!'
        ], 403); // Code 403 pour les erreurs d'autorisation
    }
}


    public function myEvent(){
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        if($user){
            $events = Event::where('user_id', $user->id)->get();
            $pastEvents = Event::where('user_id', $user->id)->where('start_date', '<', now()->format('Y-m-d'))->get();
            $futureEvents = Event::where('user_id', $user->id)->where('start_date', '>', now()->format('Y-m-d'))->get();

            $currentEvents = Event::where('user_id', $user->id)->whereDate('start_date', '>', now()->format('Y-m-d'))->get();

            return response()->json([
               'message'=> 'Success',
                // 'events'=> count($events) > 0 ? $events : 0,
                // 'pastEvents'=> count($pastEvents) > 0 ? $events : 0,
                // 'futureEvents'=> count($futureEvents) > 0 ? $events : 0,
                'currentEvents'=> count($currentEvents) > 0 ? $events : 0,
            ], 200);
        }else{
            return response()->json([
               'message'=> 'Error',
                'error'=> 'You\'re not authorised to do this action!'
            ], 401);
        }
    }

    /*
    public function showEvent($id){
        $event = Event::find($id);
        if($event){
            return response()->json([
               'message'=> 'Success',
                'event'=> $event
            ], 200);
        }else{
            return response()->json([
               'message'=> 'Error',
                'error'=> 'Event not found!'
            ], 404);
        }
    }
    */
}
