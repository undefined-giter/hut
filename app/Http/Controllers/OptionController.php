<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::all();
        return Inertia::render('Admin/Options', [
            'options' => $options
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/OptionCreateEdit');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.create')->with('error', ['En tant que fake_admin, vous ne pouvez pas enregistrer de nouvelle option.']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'available' => 'required|boolean',
            'preselected' => 'required|boolean',
            'by_day' => 'sometimes|boolean',
            'by_day_display' => 'sometimes|boolean',
            'by_day_preselected' => 'required|boolean',
        ]);

        Option::create($validated);
        return redirect()->route('admin.options.index')->with('success', ['Option ajoutée']);
    }

    public function edit(Option $option)
    {
        return Inertia::render('Admin/OptionCreateEdit', [
            'option' => $option
        ]);
    }

    public function update(Request $request, Option $option)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.create')->with('error', ['En tans que fake_admin, vous ne pouvez pas modifier d\'option.']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'available' => 'required|boolean',
            'preselected' => 'required|boolean',
            'by_day' => 'sometimes|boolean',
            'by_day_display' => 'sometimes|boolean',
            'by_day_preselected' => 'required|boolean',
        ]);
        
        $option->update($validated);
        return redirect()->route('admin.options.index')->with('success', ['Option mise à jour']);
    }

    public function toggleAvailability(Request $request, Option $option)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.index')->with('error', ["En tans que fake_admin, vous n'êtes pas autorisé à changer la disponibilité de l'option.<br>Elle correspond à afficher ou non l'option dans la page de réservation."]);
        }

        $option->update([
            'available' => $request->available,
        ]);

        return redirect()->back()->with('success', ['Disponibilité mise à jour']);
    }

    public function togglePreselected(Request $request, Option $option)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.index')->with('error', ["En tans que fake_admin, vous n'êtes pas autorisé à changer la présélection de l'option.<br>Elle correspond à préselectionner l'option ou non (visuel vert ou orange sur la page de réservation)."]);
        }

        $option->update([
            'preselected' => $request->preselected,
        ]);

        return redirect()->back()->with('success', ['Statut de présélection mis à jour']);
    }

    public function toggleByDayDisplay(Request $request, Option $option)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.index')->with('error', ["En tans que fake_admin... vous n'allez pas toutes les essayer, si ?<br>Affichage de l'input \"par jour ?\" en bas à droite de l'option sur la page de réservation."]);
        }

        $option->update([
            'by_day_display' => $request->by_day_display,
        ]);

        return redirect()->back()->with('success', ['Affichage "Par jour" mis à jour']);
    }

    public function toggleByDayPreselected(Request $request, Option $option)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.index')->with('error', ["En tans que fake_admin, vous n'êtes pas autorisé à changer la présélection de l'option d'option \"Par jour ?\"<br>Cela correspond préselectionner l'option d'option ou non."]);
        }

        $option->update([
            'by_day_preselected' => $request->by_day_preselected,
        ]);

        return redirect()->back()->with('success', ['Statut "Présélection par jour" mis à jour']);
    }

    public function destroy(Option $option)
    {
        if (auth()->user()->role === 'fake_admin') {
            return redirect()->route('admin.options.index')->with('error', ["Comment osez-vous cliquer sur ce bouton fake_admin ?! ;)"]);
        }

        $option->delete();
        return redirect()->route('admin.options.index')->with('success', ['Option supprimée.']);
    }
}
