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

    public function storeEvent(Request $request){


        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        
        if($user && $user->role_id == 1){
            try{
                $request->validate([
                    //'user_id' => 'required|string', //Auto , Auth:user()
                    'event_type_id' => 'required|integer', // Event's .......
                    'vendor_type_id' => [ 
                        'required',
                        'array',
                        'min:1',
                    ], // Event's .......
                    'duration' => 'required|string', // Event's .......
                    'start_date' => 'required|date', // Event's .......
                    'end_date' => 'required|date', // Event's .......
                    'country' => 'required|string', // Event's .......
                    'state' => 'required|string', // Event's .......
                    'city' => 'required|string', // Event's .......
                    'subcategory' => 'string', // Event's .......
                    'public_or_private' => 'required|integer', // Event's .......
                    'description' => 'required|string|max:255', // Event's .......
                    'vendor_poke' => 'string', // Event's .......
                    'total_amount' => 'required|decimal:2',
                    'is_pay_done' => 'integer'
                ]);


                $is_pay_done = 0;
                //verification du paiement
                // $payStatus
                
                // if ($payStatus == true) {
                //     $is_pay_done = 1;
                // }

                // Créer un évènement avec les données fournies par l'utilisateur
                // $date = Carbon::createFromFormat('d/m/Y', $dateString);

                $event = Event::create([
                    'user_id' => $user->id,
                    'event_type_id' => $request->event_type_id, // Event's .......
                    'vendor_type_id' => json_encode($request->vendor_type_id),
                    'duration' => $request->duration, // Event's .......
                    'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), // Event's .......
                    'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'), // Event's .......
                    'country' => $request->country, // Event's .......
                    'state' => $request->state, // Event's .......
                    'city' => $request->city, // Event's .......
                    'subcategory' => $request->subcategory, // Event's .......
                    'public_or_private' => $request->public_or_private, // Event's .......
                    'description' => $request->description, // Event's .......
                    'vendor_poke' => $request->vendor_poke, // Event's .......
                    'total_amount' => $request->total_amount,
                    'is_pay_done' => $is_pay_done,
                ]);
                
                $successMsg = 'Your event created successfully! You will receive a confirmation email shortly.';

                // Envoyer un mail de confirmation
                Mail::to($user->email)->send(new SuccessMail($successMsg));
                return response()->json([
                   'message'=> 'Success',
                   'success'=> 'Event created successfully!'
                ], 200);

            } catch (ValidationException $e) {
                return response()->json([
                    'message'=> 'Error',
                    'error'=> $e->getMessage(),
                ], 500);
            }
        }else{
                return response()->json([
                    'message'=> 'Error',
                    'error'=> 'You\'re not authorised to do this action!'
                ], 402);
        }
            
    }

    public function myEvent(){
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        if($user){
            $events = Event::where('user_id', $user->id)->get();
            $pastEvents = Event::where('user_id', $user->id)->where('start_date', '<', now()->format('Y-m-d'))->get();
            $futureEvents = Event::where('user_id', $user->id)->where('start_date', '>', now()->format('Y-m-d'))->get();
            $currentEvents = Event::where('user_id', $user->id)->where('start_date', '=', now()->format('Y-m-d'))->get();

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
