<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserApproved;
use App\Mail\UserRejected;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
// use App\Http\Requests\ApplyRequest;

class UserController extends Controller
{
    // Guests can apply for a membership
    public function apply(Request $request){
        // $validated = $request->validated();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'dni' => 'required|string|unique:users,dni',
            'phone' => 'required|string|unique:users,phone',
        ]);

        $supporterRole = Role::where('name','supporter')->first();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'dni' => $validated['dni'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['dni']), // DNI as temp password
            'role_id' => $supporterRole->id,
            'status' => 'pending',
        ]);
        return response()->json(['message' => 'Aplicación enviada'], 201);
    }
    // Display the list of users with pending status
    public function index(Request $request)
    {
        $status = $request->query('status');

        $users = User::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        // $users = User::where('status', 'pending')->get();
        return Inertia::render('admin/users', [
            'users' => $users,
            'filters' => [
                'status' => $status
            ],
        ]);
    }

    public function apiIndex(Request $request)
    {
        $status = $request->query('status');

        $users = User::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->get();

        return response()->json([
            'users' => $users,
            'filters' => [
                'status' => $status
            ]
        ]);
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'membership_id' => 'required_if:action,approve|exists:memberships,id',
        ]);

        if ($validated['action'] === 'approve') {
            $memberRole = Role::where('name', 'member')->first();

            DB::transaction(function () use ($user, $validated, $memberRole) {
                $user->update([
                    'role_id' => $memberRole->id,
                    'status' => 'approved',
                ]);

                $user->memberships()->attach($validated['membership_id'], [
                    'starts_at' => now(),
                    'expires_at' => now()->addDays(30),
                ]);
            });

            return redirect()->back()->with('success', 'User approved successfully.');
        }

        // Rejection logic
        $user->update([
            'status' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'User rejected successfully.');
    }

    //Reject a user
    public function reject(User $user) {
        
        // Update user status to reject
        $user->status = 'rejected';
        $user->save();

        // Send rejection email
        // Mail::to($user->email)->send(new UserRejected($user));

        // Redirect with a success message
        return Inertia::location(route('UsersList'))->with('status','User rejected successfully');
    }
}
