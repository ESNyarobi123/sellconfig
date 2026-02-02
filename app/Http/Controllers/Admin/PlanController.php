<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    /**
     * Show all plans
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'all');

        $query = Plan::withCount([
            'configs as total_configs',
            'configs as available_configs' => function ($query) {
                $query->where('status', 'available');
            },
            'configs as sold_configs' => function ($query) {
                $query->where('status', 'sold');
            },
        ]);

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $plans = $query->orderByDesc('created_at')->get();

        return view('admin.plans.index', compact('plans', 'type'));
    }

    /**
     * Show create plan form
     */
    public function create()
    {
        return view('admin.plans.create');
    }

    /**
     * Store new plan
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:weekly,bi_weekly,monthly,other',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:100',
            'duration' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        // If type is 'other', require duration_days
        if ($request->type === 'other') {
            $rules['duration_days'] = 'required|integer|min:1|max:365';
        }

        $request->validate($rules);

        $data = $request->only(['name', 'type', 'description', 'price', 'duration']);

        // Add duration_days for 'other' type
        if ($request->type === 'other' && $request->duration_days) {
            $data['duration_days'] = $request->duration_days;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('plans', 'public');
            $data['image'] = $path;
        }

        Plan::create($data);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan imeundwa kikamilifu!');
    }

    /**
     * Show edit plan form
     */
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update plan
     */
    public function update(Request $request, Plan $plan)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:weekly,bi_weekly,monthly,other',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:100',
            'duration' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        // If type is 'other', require duration_days
        if ($request->type === 'other') {
            $rules['duration_days'] = 'required|integer|min:1|max:365';
        }

        $request->validate($rules);

        $data = $request->only(['name', 'type', 'description', 'price', 'duration']);
        $data['is_active'] = $request->boolean('is_active');

        // Add duration_days for 'other' type
        if ($request->type === 'other' && $request->duration_days) {
            $data['duration_days'] = $request->duration_days;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($plan->image) {
                Storage::disk('public')->delete($plan->image);
            }
            $path = $request->file('image')->store('plans', 'public');
            $data['image'] = $path;
        }

        $plan->update($data);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan imesasishwa!');
    }

    /**
     * Delete plan
     */
    public function destroy(Plan $plan)
    {
        // Check if plan has sold configs
        if ($plan->configs()->where('status', 'sold')->exists()) {
            return back()->with('error', 'Huwezi kufuta plan ambayo ina configs zilizouzwa.');
        }

        if ($plan->image) {
            Storage::disk('public')->delete($plan->image);
        }

        $plan->delete();

        return back()->with('success', 'Plan imefutwa.');
    }

    /**
     * Toggle plan active status
     */
    public function toggle(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);

        return back()->with('success', 'Hali ya plan imebadilishwa.');
    }
}
