<?php
// app/Http/Controllers/CustomerFeedbackController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerFeedback;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CustomerFeedbackController extends Controller
{
    public function index()
    {
        return view('frontend.pages.customer-feedback');
    }

    public function submit(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|min:2|max:100|regex:/^[a-zA-Z\s]+$/',
            'mobile' => 'required|string|regex:/^[0-9]{10}$/',
            'notes' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create feedback record without AI
            $feedback = CustomerFeedback::create([
                'customer_name' => $request->customer_name,
                'mobile' => $request->mobile,
                'notes' => $request->notes,
                'rating' => $request->rating,
                'is_responded' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your feedback!',
                'data' => [
                    'feedback' => $feedback
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Feedback submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    // Admin method to view all feedback
    public function adminIndex()
    {
        $feedbacks = CustomerFeedback::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    // Admin method to view single feedback
    public function adminShow($id)
    {
        $feedback = CustomerFeedback::findOrFail($id);
        return view('admin.feedback.show', compact('feedback'));
    }

    // Admin method to respond to feedback
    public function adminRespond(Request $request, $id)
    {
        $feedback = CustomerFeedback::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'admin_response' => 'required|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $feedback->update([
            'admin_response' => $request->admin_response,
            'is_responded' => true,
            'responded_at' => now(),
        ]);

        return back()->with('success', 'Response sent successfully!');
    }
}