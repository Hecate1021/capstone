<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\EventCalendar;
use App\Models\Events;
use App\Models\Message;
use App\Models\Post;
use App\Models\Review;
use App\Models\Room;
use App\Models\TemporyImage;
use App\Models\tourist;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class UserController extends Controller
{


    public function index()
    {
        // Fetch resorts with user info and availability
        $resorts = User::with('userInfo', 'availability')  // Assuming 'availability' relationship exists
            ->where('role', 'resort')
            ->get()
            ->map(function ($resort) {
                // Attach computed properties
                $resort->averageRating = round(Review::where('resort_id', $resort->id)->avg('rating'), 1) ?? 0;
                $resort->image = $resort->userInfo?->profilePath ?? 'default.jpg';

                // Format the availability data to AM/PM time format
                $resort->availability = $resort->availability->mapWithKeys(function ($availability) {
                    return [$availability->day => [
                        'opening_time' => $availability->opening_time ? Carbon::parse($availability->opening_time)->format('g:i A') : 'Closed',
                        'closing_time' => $availability->closing_time ? Carbon::parse($availability->closing_time)->format('g:i A') : 'Closed',
                    ]];
                });


                return $resort;
            });

        $events = EventCalendar::with('images')->get();

        $authUserId = auth()->id(); // Get the logged-in user's ID

        if (auth()->check()) {
            // Retrieve all users who have messages with the authenticated user
            $users = User::where('id', '!=', $authUserId)
                ->whereHas('messages', function ($query) use ($authUserId) {
                    $query->where('sender_id', $authUserId)
                        ->orWhere('receiver_id', $authUserId);
                })
                ->with('userInfo')
                ->get()
                ->map(function ($user) use ($authUserId) {
                    // Add unread messages count for each user
                    $user->unread_messages_count = Message::where('sender_id', $user->id)
                        ->where('receiver_id', $authUserId)
                        ->where('is_read', false)
                        ->count();
                    return $user;
                });

            // Calculate the total unread messages for the authenticated user
            $totalUnreadMessages = Message::where('receiver_id', $authUserId)
                ->where('is_read', false)
                ->count();
        } else {
            // If user is not authenticated, return empty collections and zero unread messages
            $users = collect();
            $totalUnreadMessages = 0;
        }

        // Fetch tourist spots with images
        $touristSpots = Tourist::with('images')->get();

        return view('index', compact('resorts', 'events', 'touristSpots', 'totalUnreadMessages', 'users'));
    }








    public function balai($id = 2)
    {
        $authUserId = auth()->id(); // Get the logged-in user's ID

        if (auth()->check()) {
            // Retrieve all users who have messages with the authenticated user
            $users = User::where('id', '!=', $authUserId)
                ->whereHas('messages', function ($query) use ($authUserId) {
                    $query->where('sender_id', $authUserId)
                        ->orWhere('receiver_id', $authUserId);
                })
                ->with('userInfo')
                ->get()
                ->map(function ($user) use ($authUserId) {
                    // Add unread messages count for each user
                    $user->unread_messages_count = Message::where('sender_id', $user->id)
                        ->where('receiver_id', $authUserId)
                        ->where('is_read', false)
                        ->count();
                    return $user;
                });

            // Calculate the total unread messages for the authenticated user
            $totalUnreadMessages = Message::where('receiver_id', $authUserId)
                ->where('is_read', false)
                ->count();
        } else {
            // If user is not authenticated, return empty collections and zero unread messages
            $users = collect();
            $totalUnreadMessages = 0;
        }

        // Fetch the resort user by ID with related user info
        $user = User::where('id', $id)
            ->where('role', 'resort')
            ->with('userInfo')
            ->firstOrFail();

        // Fetch the rooms of the resort with their images
        $rooms = Room::with('images')->where('user_id', $user->id)->get();

        // Fetch all events with their images
        $events = Events::with('eventImages')->get();

        // Fetch all categories with their subcategories and related menus/images
        $categories = Category::with('subcategories.menus.images')->get();

        // Fetch reviews for the resort with pagination
        $reviews = Review::with('user.userInfo')->paginate(10);

        // Calculate the average rating for the resort
        $averageRating = Review::where('resort_id', $id)->avg('rating');

        // Fetch posts associated with the resort
        $posts = Post::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Optional: Order by most recent
            ->get();

        // Return the data to the view
        return view('index', compact(
            'user',
            'rooms',
            'users',
            'events',
            'categories',
            'reviews',
            'totalUnreadMessages',
            'averageRating',
            'posts'
        ));
    }




    public function dashboard()
    {

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    }
    // public function welcome()
    // {
    //     $users = User::where('role', 'resort')->with('userInfo')->get();
    //     return view('balai', compact('users'));
    // }
    public function resort($id)
    {
        $authUserId = auth()->id(); // Get the logged-in user's ID

        if (auth()->check()) {
            // Retrieve all users who have messages with the authenticated user
            $users = User::where('id', '!=', $authUserId)
                ->whereHas('messages', function ($query) use ($authUserId) {
                    $query->where('sender_id', $authUserId)
                        ->orWhere('receiver_id', $authUserId);
                })
                ->with('userInfo')
                ->get()
                ->map(function ($user) use ($authUserId) {
                    // Add unread messages count for each user
                    $user->unread_messages_count = Message::where('sender_id', $user->id)
                        ->where('receiver_id', $authUserId)
                        ->where('is_read', false)
                        ->count();
                    return $user;
                });

            // Calculate the total unread messages for the authenticated user
            $totalUnreadMessages = Message::where('receiver_id', $authUserId)
                ->where('is_read', false)
                ->count();
        } else {
            // If user is not authenticated, return empty collections and zero unread messages
            $users = collect();
            $totalUnreadMessages = 0;
        }

        // Fetch the resort user by ID with related user info
        $user = User::where('id', $id)
            ->where('role', 'resort')
            ->with('userInfo')
            ->firstOrFail();

        $rooms = Room::with('images')
            ->where('user_id', $user->id) // Apply filter BEFORE fetching data
            ->get(); // Retrieve data


        // Fetch all events with their images
        $events = Events::with('eventImages')->get()->where('resort_id', $user->id);

        // Fetch all categories with their subcategories and related menus/images
        $categories = Category::with('subcategories.menus.images')->get()->where('resort_id', $user->id);

        // Fetch reviews for the resort with pagination
        $reviews = Review::with('user.userInfo')
            ->where('resort_id', $user->id) // Filter BEFORE fetching data
            ->paginate(10);


        // Calculate the average rating for the resort
        $averageRating = Review::where('resort_id', $id)->avg('rating');

        // Fetch posts associated with the resort
        $posts = Post::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Optional: Order by most recent
            ->get();

        // Return the data to the view
        return view('balai', compact(
            'user',
            'rooms',
            'users',
            'events',
            'categories',
            'reviews',
            'totalUnreadMessages',
            'averageRating',
            'posts'
        ));
    }


    public function resortRoom($name)
    {
        $user = User::where('name', $name)->where('role', 'resort')->with('userinfo')->first();
        $isOwner = false;
        // Fetch reviews for the resort user and calculate the average rating
        $averageRating = Review::where('resort_id', $user->id)->avg('rating');

        // Ensure the average rating does not exceed 5
        $averageRating = min($averageRating, 5);
        $rooms = Room::with('images')->where('user_id', $user->id)->get();
        return view('resort.room', compact('user', 'isOwner', 'rooms', 'averageRating'));
    }

    public function accomodation()
    {
        return view('accomodation');
    }

    public function create()
    {
        return view('auth.register');
    }
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_number' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $temporaryImages = TemporyImage::all();
        if ($validator->fails()) {

            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect('/')->withErrors($validator)->withInput();
        }



        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Create the associated UserInfo entry
        $userInfo = UserInfo::create([
            'user_id' => $user->id,
            'contactNo' => $request->contact_number,
            'address' => $request->address,

        ]);

        foreach ($temporaryImages as $temporaryImage) {
            // Copy image from temporary storage to the final location
            Storage::copy(
                'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file,
                'images/' . $temporaryImage->folder . '/' . $temporaryImage->file
            );

            // Create a new image record
            UserInfo::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profilePhoto' => $temporaryImage->file,
                    'profilePath' => $temporaryImage->folder . '/' . $temporaryImage->file,
                ]
            );

            // Cleanup the temporary directory and delete the temporary image record
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        // Trigger the Registered event
        event(new Registered($user));

        // Log in the new user
        Auth::login($user);

        // Redirect to the desired route after successful registration
        return redirect()->route('balai');
    }

    public function me()
    {
        return view('mobileview.profile');
    }

    public function home()
    {
        return view('index');
    }
}
