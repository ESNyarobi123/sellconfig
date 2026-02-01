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
    public function index()
    {
        $plans = Plan::withCount([
            'configs as total_configs',
            'configs as available_configs' => function ($query) {
                $query->where('status', 'available');
            },
            'configs as sold_configs' => function ($query) {
                $query->where('status', 'sold');
            },
        ])->orderByDesc('created_at')->get();

        return view('admin.plans.index', compact('plans'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:weekly,bi_weekly,monthly',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:100',
            'duration' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'type', 'description', 'price', 'duration']);

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
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:weekly,bi_weekly,monthly',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:100',
            'duration' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'type', 'description', 'price', 'duration']);
        $data['is_active'] = $request->boolean('is_active');

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
