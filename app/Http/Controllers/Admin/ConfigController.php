<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Plan;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Show configs for a plan
     */
    public function index(Request $request)
    {
        $plans = Plan::all();
        $selectedPlan = null;
        $configs = null;

        if ($request->filled('plan_id')) {
            $selectedPlan = Plan::find($request->plan_id);
            if ($selectedPlan) {
                $configs = $selectedPlan->configs()
                    ->with('soldToUser')
                    ->orderByDesc('created_at')
                    ->paginate(20);
            }
        }

        return view('admin.configs.index', compact('plans', 'selectedPlan', 'configs'));
    }

    /**
     * Show upload form
     */
    public function create(Request $request)
    {
        $plans = Plan::where('is_active', true)->get();
        $selectedPlanId = $request->plan_id;

        return view('admin.configs.create', compact('plans', 'selectedPlanId'));
    }

    /**
     * Store single config
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'content' => 'required|string',
        ]);

        Config::create([
            'plan_id' => $validated['plan_id'],
            'content' => $validated['content'],
            'status' => 'available',
        ]);

        return redirect()->route('admin.configs.index', ['plan_id' => $validated['plan_id']])
            ->with('success', 'Config imeongezwa!');
    }

    /**
     * Bulk upload configs
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'configs' => 'required|string',
            'separator' => 'required|in:newline,comma,semicolon',
        ]);

        $separator = match ($validated['separator']) {
            'comma' => ',',
            'semicolon' => ';',
            default => "\n",
        };

        $configTexts = array_filter(
            array_map('trim', explode($separator, $validated['configs']))
        );

        if (empty($configTexts)) {
            return back()->with('error', 'Hakuna configs zilizopatikana.');
        }

        $created = 0;
        foreach ($configTexts as $content) {
            if (!empty($content)) {
                Config::create([
                    'plan_id' => $validated['plan_id'],
                    'content' => $content,
                    'status' => 'available',
                ]);
                $created++;
            }
        }

        return redirect()->route('admin.configs.index', ['plan_id' => $validated['plan_id']])
            ->with('success', "Configs {$created} zimeongezwa!");
    }

    /**
     * Edit config
     */
    public function edit(Config $config)
    {
        if ($config->status === 'sold') {
            return back()->with('error', 'Huwezi kuhariri config iliyouzwa.');
        }

        return view('admin.configs.edit', compact('config'));
    }

    /**
     * Update config
     */
    public function update(Request $request, Config $config)
    {
        if ($config->status === 'sold') {
            return back()->with('error', 'Huwezi kuhariri config iliyouzwa.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $config->update(['content' => $validated['content']]);

        return redirect()->route('admin.configs.index', ['plan_id' => $config->plan_id])
            ->with('success', 'Config imesasishwa!');
    }

    /**
     * Delete config
     */
    public function destroy(Config $config)
    {
        if ($config->status === 'sold') {
            return back()->with('error', 'Huwezi kufuta config iliyouzwa.');
        }

        $planId = $config->plan_id;
        $config->delete();

        return redirect()->route('admin.configs.index', ['plan_id' => $planId])
            ->with('success', 'Config imefutwa.');
    }

    /**
     * Delete all available configs for a plan
     */
    public function destroyAll(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $deleted = Config::where('plan_id', $request->plan_id)
            ->where('status', 'available')
            ->delete();

        return back()->with('success', "Configs {$deleted} zimefutwa.");
    }
}
