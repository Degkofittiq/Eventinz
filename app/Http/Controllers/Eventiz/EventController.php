<?php

namespace App\Http\Controllers\Eventiz;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Review;
use App\Models\Company;
use App\Mail\SuccessMail;
use App\Models\BidQuotes;
use App\Models\EventType;
use App\Rules\SameSizeAs;
use App\Models\EventQuotes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CanceledEvents;
use App\Models\EventSubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    //
    function generateUniqueEventID()
    {
        do {
            $generic_id = 'EVT-Event-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Event::where('generic_id', $generic_id)->exists());
    
        return $generic_id;
    }

    public function createEventForm(Request $request){

        // Récupérer l'utilisateur authentifié
        $user = $request->user();

        if($user && $user->role_id == 1){
            return response()->json([
                'message'=> 'Success',
                'success'=> 'You\'re able to fill the fields then create your event!'
            ], 200);

            // return view('eventiz.event.create');
        }else{
            return response()->json([
                'message'=> 'Error',
                'error'=> 'You\'re not authorised to do this action!'
            ], 403);
        }
        
    }

    public function eventTypeList(){
        $eventTypes = EventType::all()->makeHidden(['created_at','updated_at']);
        
        if (!$eventTypes) {
            return response()->json([
                'error' => 'No event types found yet'
            ], 404);
        }

        return response()->json([
            'eventTypes' => $eventTypes
        ], 200);
    }

    // eventSubcategoriesList
    
    public function eventSubcategoriesList(){
        $eventSubcategories = EventSubcategory::all()->makeHidden(['created_at','updated_at']);
        
        if (!$eventSubcategories) {
            return response()->json([
                'error' => 'No event Subcategoies found yet'
            ], 404);
        }

        return response()->json([
            'eventSubcategories' => $eventSubcategories
        ], 200);
    }

    public function categoriesSelectVendors(Request $request){
        // Récupérer les IDs des vendors à partir de la requête
        $array = $request->input('vendors_id'); // Utilisation de 'input' pour plus de flexibilité
    // Vérifie que $array est bien un tableau et qu'il n'est pas vide
    if (is_array($array) && !empty($array)) {
        // Convertir les IDs en format JSON pour la requête
        $vendorChooseId = Company::select('id', 'name','images')
        // ->where('is_subscribed', 0)
        ->where(function($query) use ($array) {
            foreach ($array as $id) {
                $query->orWhereRaw('JSON_CONTAINS(vendor_categories_id, ?)', [$id]);
            }
        })->get();
        foreach ($vendorChooseId as $company) {
            $company['user_generic_id'] = $company->makeHidden(['user'])->user->generic_id;
            // 
        }
    } else {
        // Si le tableau est vide ou invalide, retourner une réponse appropriée
        $vendorChooseId = collect(); // Collection vide si pas de IDs
    }
    
        return response()->json([
            'VendorsChooseList' => $vendorChooseId
        ], 200);
    }

    public function storeEvent(Request $request){
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        
        if($user && $user->role_id == 1){
            try {
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
                        'aprx_budget' => 'required|numeric|between:0,999999.99',
                        'guest_number' => 'required|integer',
                        'travel' => 'required|string|min:2',
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
                        'vendor_poke' => [
                            'required',
                            'array',
                            'min:1',
                        ],
                    ]);
                }
            } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $e->errors(),
                ], 422); // Code 422 pour les erreurs de validation
            } 
                
                $is_pay_done = $request->input('is_pay_done', 0);
                
                //verification du paiement
                // $payStatus
                
                // if ($payStatus == true) {
                //     $is_pay_done = 1;
                // }

                // Créer un évènement avec les données fournies par l'utilisateur
                // $date = Carbon::createFromFormat('d/m/Y', $dateString);

                $event = Event::create([                    
                    'generic_id' =>  $this->generateUniqueEventID(),
                    'user_id' => $user->id,
                    'event_type_id' => $request->event_type_id,
                    'vendor_type_id' => json_encode($request->vendor_type_id),
                    'duration' => $request->duration,
                    'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
                    'aprx_budget' => $request->aprx_budget,
                    'guest_number' => $request->guest_number,
                    'travel' => $request->travel,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'subcategory' => $request->subcategory,
                    'public_or_private' => $request->public_or_private,
                    'description' => $request->description,
                    'vendor_poke' => json_encode($request->vendor_poke) ?? null,
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
            $pastEvents = Event::where('user_id', $user->id)->whereDate('start_date', '<', now()->format('Y-m-d'))->get();
            $futureEvents = Event::where('user_id', $user->id)->whereDate('start_date', '>', now()->format('Y-m-d'))->get();
            $currentEvents = Event::where('user_id', $user->id)->whereDate('start_date', '=', now()->format('Y-m-d'))->get();
            $activeEvents = Event::where('user_id', $user->id)->where('status', 'Yes')->get();
            // $events = DB::select('SELECT * FROM `events` WHERE `user_id` = ? AND `start_date` = CURDATE()', [2]);

            return response()->json([
                'message'=> 'Success',
                 'All events:' => count($events) > 0 ? ["Events" =>$events,  "Number" =>count($events)] : 0,
                 'Past Events:'=> count($pastEvents) > 0 ? ["Events" =>$pastEvents,  "Number" =>count($pastEvents)] : 0,
                 'Future Events: '=> count($futureEvents) > 0 ? ["Events" =>$futureEvents,  "Number" =>count($futureEvents)] : 0,
                 'Current Events: '=> count($currentEvents) > 0 ? ["Events" =>$currentEvents,  "Number" =>count($currentEvents)] : 0,
                 'Active Events: '=> count($activeEvents) > 0 ? ["Events" =>$activeEvents,  "Number" =>count($activeEvents)]: 0
             ], 200);
        }else{
            return response()->json([
               'message'=> 'Error',
                'error'=> 'You\'re not authorised to do this action!'
            ], 401);
        }
    }

    // Show specific event based on his Id /*
    public function showEvent(Request $request , $id){

        // $event = Event::find($id);

        $authUser = auth()->user();
        $event = Event::where('id', $id)->/*where('user_id', $authUser->id)->*/first();
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
    // */

    //Reviews section
    public function storeReview(Request $request, $eventId){

        // dd($request);
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // dd($event->user_id);
        if ($user) {        
            $event = Event::where('id', $eventId)->first();
            if ($user->id == $event->user_id || in_array($user->id, json_decode($event->vendor_type_id, true)) || in_array($user->id, json_decode($event->vendor_poke, true))) {

                try {
                    $reviewValidation = $request->validate([
                        // "event_id" => 'required|integer',
                        'review_cible' => 'required|integer',
                        'review_content' => 'required|string',
                        'start_for_cibe' => 'integer|required',
                    ]);

                    $review = Review::create([
                        'event_id' => $eventId,
                        'user_id' => $user->id,
                        'review_cible' => $reviewValidation['review_cible'],
                        'review_content' => $reviewValidation['review_content'],
                        'date_review' => Carbon::today()->format('Y-m-d'),
                        'start_for_cibe' => $reviewValidation['start_for_cibe'],
                    ]);
        
                    return response()->json([
                        'message' => 'Success',
                        'success' => 'Review created successfully!'
                    ], 200);
        
                } catch (ValidationException $e) {
                    return response()->json([
                        'message' => 'Validation Error',
                        'errors' => $e->errors(),
                    ], 422);
                }
            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'You are not link to this event!'
                ], 403);            
            }
        } else {
            return response()->json([
                'message' => 'Unauthorized',
                'error' => 'You need to login!'
            ], 402);   
        }
    }

    //Quote section
    public function storeQuote(Request $request, $eventId){
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        if ($user->credit > 0) {
            if ($user && $user->role_id == 2) {
                // Récupération de l'entreprise de l'utilisateur
                $userCompany = Company::where('users_id', $user->id)->first();
                if ($userCompany) {   
                    try { 
                        $dataValidate = $request->validate([
                            'servicename' => 'bail|array|min:1', // Le tableau doit contenir au moins 1 élément
                            'servicename.*' => 'bail|string|min:1|required', // Valider chaque élément du tableau
                            'type' =>  ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                            'type.*' => 'bail|required|string', // Valider chaque élément du tableau
                            'rate' =>  ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                            'rate.*' => 'bail|required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Valider chaque élément du tableau
                            'duration' =>  ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                            'duration.*' => 'bail|required|string', // Valider chaque élément du tableau
                            'total' =>  ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                            'total.*' => 'bail|required|numeric|regex:/^\d+(\.\d{1,2})?$/', // Valider chaque élément du tableau
                            'subdetails' => 'bail|string|nullable',
                            'travel' => 'bail|string|nullable',
                            'obligatory' =>  ['bail', 'array', new SameSizeAs('servicename')], // Le tableau doit contenir au moins 1 élément
                            'obligatory.*' => 'bail|required|string' // Valider chaque élément du tableau
                        ]);
                                        
                    } catch (ValidationException $e) {
                        return response()->json([
                            'message' => 'Validation Error',
                            'errors' => $e->errors(),
                        ], 422); // Code 422 pour les erreurs de validation
                    }
                
                    $quoteCode = Str::random(4) . "-". $eventId . "-" . $userCompany->id;
                    BidQuotes::create([
                        'quote_code' => $quoteCode,
                        'event_id' => $eventId,
                        'status' => 'Pending'
                    ]);
                
                    // Boucle sur les services pour créer les devis si 'servicename' est un tableau
                    if (isset($dataValidate['servicename']) && is_array($dataValidate['servicename'])) {
                        foreach ($dataValidate['servicename'] as $index => $service) {
                            EventQuotes::create([
                                'quote_code' => $quoteCode,
                                'event_id' => $eventId,
                                'company_id' => $userCompany->id, // Utilisation de l'entreprise de l'utilisateur
                                'servicename' => $service,
                                'type' => $dataValidate['type'][$index],
                                'rate' => $dataValidate['rate'][$index],
                                'duration' => $dataValidate['duration'][$index],
                                'total' => $dataValidate['total'][$index],
                                'subdetails' => $dataValidate['subdetails'], // Peut rester en dehors de la boucle s'il est commun
                                'travel' => $dataValidate['travel'], // Peut rester en dehors de la boucle s'il est commun
                                'obligatory' => $dataValidate['obligatory'][$index] // obligatory => yes or no_obligatory => no
                            ]);
                        }
                    }
                
                    $restCredit = $user->credit - 1;
                
                    // Mise à jour du crédit de l'utilisateur authentifié
                    $user->update([
                        'credit' => $restCredit
                    ]);
                
                    return response()->json([
                        'message' => 'Success',
                        'error' => 'Quote have been created!'
                    ], 200);
                }

            } else {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'You need to be a vendor to create a quote!'
                ], 403);
            }
        } else {
            return response()->json([
                'message' => 'Error',
                'error' => 'You don\'t have enough credit!'
            ], 403);
        }
    }

    // Show Bids
    public function showBids($eventId){
        // Bids
        $bids = BidQuotes::where('event_id', $eventId)->get();

        return response()->json([
            'message' => 'Success',
            'bids' => $bids
        ]);
    }

    // Show Quote
    public function showQuote($quoteCode){

        // Récupérer toutes les entreprises associées aux devis pour un quote_code spécifique
        $companies = Company::whereHas('eventQuotes', function ($query) use ($quoteCode) {
            $query->where('quote_code', $quoteCode);
        })->with(['eventQuotes' => function ($query) use ($quoteCode) {
            $query->where('quote_code', $quoteCode)->where('status', null)->orWhere('status', 'accepted'); // accepted or remove (the event's user dont want)
        }])->get();

        
        return response()->json([
            'message' => 'Success',
            'companies' => $companies
        ], 200);
    }

    // Remove Quote Item
    public function removeQuoteItem($quoteId){
        $foundQuoteItem = EventQuotes::find($quoteId);

        // dd($foundQuoteItem);
        if ($foundQuoteItem) {
            if ($foundQuoteItem->obligatory == "no") {
                $foundQuoteItem->update([
                    'status' => "removed"
                ]);
            }else {
                return response()->json([
                    'message' => 'Error',
                    'error' => 'You can\'t remove thiis quote item!'
                ], 403);
            }
        } else {
            return response()->json([
                'message' => 'Error',
                'error' => 'Quote item not found!'
            ], 400);
        }
        
    }

    // Validate (Accept the Bid or Reject)
    public function validateQuotesBid(Request $request, $quoteCode){
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        $foundBid = BidQuotes::where('quote_code',$quoteCode)->first();
        $foundBidEvent = Event::where('id',$foundBid->event_id)->first();

        // dd($foundBid);

        if ($foundBid) {
            $foundBid->update([
                'status' => 'Accepted'
            ]);
            
            $foundBid->update([
                'status' => 'Yes' // Yes => Active or No => Inactive
            ]);
            
            return response()->json([
                'message' => 'Success',
                'error' => 'Bid accepted!'
            ]);

        } else {
            return response()->json([
                'message' => 'Error',
                'error' => 'Bid not found!'
            ], 400);
        }
        

    }
    
    // Validate (Accept the Bid or Reject)
    public function rejectQuotesBid(Request $request, $quoteCode){
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        $foundBid = BidQuotes::where('quote_code',$quoteCode)->first();

        // dd($foundBid);

        if ($foundBid) {
            $foundBid->update([
                'status' => 'Rejected'
            ]);

            return response()->json([
                'message' => 'Success',
                'error' => 'Bid reject!'
            ]);

        } else {
            return response()->json([
                'message' => 'Error',
                'error' => 'Bid not found!'
            ], 400);
        }
        

    }

    // Cancel one event
    public function cancelEvent(Request $request, $eventId){
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        $foundEvent = Event::find($eventId);

        try {
            $cancelInformation = $request->validate([
                'canceled_reason' => 'required|min:10|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422); // Code 422 pour les erreurs de validation
        }

        if ($foundEvent) {
            // On vérifie que cet évènement appartient bien à l'utilisateur authentifié
            if ($foundEvent->user_id == $user->id) {

                CanceledEvents::create([
                    'event_id' => $eventId,
                    'canceled_reason' => $cancelInformation['canceled_reason']
                ]);

                // On supprime les devis liés à cet évènement
                EventQuotes::where('event_id', $eventId)->update([
                    'status' => 'Event canceled'
                ]);

                BidQuotes::where('event_id', $eventId)->update([
                    'status' => 'Event canceled'
                ]);
                // On supprime l'évènement
                $foundEvent->update([
                    'cancelstatus' => 'Canceled'
                ]);
                return response()->json([
                   'message' => 'Success',
                    'error' => 'Event has been canceled!'
                ], 200);
            } else {
                return response()->json([
                   'message' => 'Unauthorized',
                    'error' => 'You are not the owner of this event!'
                ], 403);
            }
        } else {
            return response()->json([
               'message' => 'Unauthorized',
                'error' => 'Event not found!'
            ], 401);
        }    
    }

    // Complete event
    public function completeEvent(Request $request, $eventId){
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();
        $foundEvent = Event::find($eventId);

        if ($foundEvent) {
            // On vérifie que cet évènement appartient bien à l'utilisateur authentifié
            if ($foundEvent->user_id == $user->id) {
                $foundEvent->update([
                    'cancelstatus' => 'Completed'
                ]);
                return response()->json([
                   'message' => 'Success',
                    'error' => 'Event has been completed!'
                ], 200);
            } else {
                return response()->json([
                   'message' => 'Unauthorized',
                    'error' => 'You are not the owner of this event!'
                ], 403);
            }
        } else {
            return response()->json([
               'message' => 'Unauthorized',
                'error' => 'Event not found!'
            ], 401);
        }    

    }
}
