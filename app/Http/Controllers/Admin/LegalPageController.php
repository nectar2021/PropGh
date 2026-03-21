<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalPageController extends Controller
{
    public function index(): View
    {
        $pages = LegalPage::orderBy('title')->get();

        return view('admin.legal-pages.index', compact('pages'));
    }

    public function edit(LegalPage $legalPage): View
    {
        return view('admin.legal-pages.edit', ['page' => $legalPage]);
    }

    public function update(Request $request, LegalPage $legalPage): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'sections' => ['required', 'array', 'min:1'],
            'sections.*.anchor' => ['required', 'string', 'max:100'],
            'sections.*.title' => ['required', 'string', 'max:255'],
            'sections.*.content' => ['required', 'string', 'max:10000'],
        ]);

        $legalPage->update([
            'title' => $data['title'],
            'meta_description' => $data['meta_description'],
            'sections' => $data['sections'],
        ]);

        return back()->with('status', "{$legalPage->title} updated successfully.");
    }
}
