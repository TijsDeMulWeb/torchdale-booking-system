<?php

namespace App\Http\Controllers\MailTemplate;

use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MailTemplateController extends Controller
{
    private function validateType(string $type): void
    {
        abort_unless(in_array($type, ['product', 'gift-card']), 404);
    }

    public function index(string $type)
    {
        $this->validateType($type);

        $escaperoomId = auth()->user()->escaperoom_id;
        $templates    = MailTemplate::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->orderBy('locale')
            ->get();
        $locales = MailTemplate::locales();

        return view('mail-templates.index', compact('type', 'templates', 'locales'));
    }

    public function create(string $type)
    {
        $this->validateType($type);

        $escaperoomId = auth()->user()->escaperoom_id;
        $locales      = MailTemplate::locales();
        $usedLocales  = MailTemplate::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->pluck('locale')
            ->toArray();
        $variables = $this->variableHints($type);

        return view('mail-templates.form', compact('type', 'locales', 'usedLocales', 'variables'));
    }

    public function store(Request $request, string $type)
    {
        $this->validateType($type);

        $request->validate([
            'locale'  => ['required', 'in:' . implode(',', array_keys(MailTemplate::locales()))],
            'subject' => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string'],
        ]);

        MailTemplate::updateOrCreate(
            [
                'escaperoom_id' => auth()->user()->escaperoom_id,
                'type'          => $type,
                'locale'        => $request->locale,
            ],
            [
                'subject' => $request->subject,
                'body'    => $request->body,
            ]
        );

        return redirect()->route('mail-templates.index', $type)
            ->with('message', 'Sjabloon opgeslagen.');
    }

    public function edit(string $type, MailTemplate $template)
    {
        $this->validateType($type);
        abort_unless($template->escaperoom_id === auth()->user()->escaperoom_id && $template->type === $type, 404);

        $locales   = MailTemplate::locales();
        $variables = $this->variableHints($type);

        return view('mail-templates.form', compact('type', 'template', 'locales', 'variables'));
    }

    public function update(Request $request, string $type, MailTemplate $template)
    {
        $this->validateType($type);
        abort_unless($template->escaperoom_id === auth()->user()->escaperoom_id && $template->type === $type, 404);

        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string'],
        ]);

        $template->update([
            'subject' => $request->subject,
            'body'    => $request->body,
        ]);

        return redirect()->route('mail-templates.index', $type)
            ->with('message', 'Sjabloon bijgewerkt.');
    }

    public function uploadImage(Request $request, string $type)
    {
        $this->validateType($type);

        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('image')->store(
            'escaperooms/' . auth()->user()->escaperoom_id . '/mail-templates',
            'public'
        );

        return response()->json(['url' => Storage::url($path)]);
    }

    public function destroy(string $type, MailTemplate $template)
    {
        $this->validateType($type);
        abort_unless($template->escaperoom_id === auth()->user()->escaperoom_id && $template->type === $type, 404);

        $template->delete();

        return redirect()->route('mail-templates.index', $type)
            ->with('message', 'Sjabloon verwijderd.');
    }

    private function variableHints(string $type): array
    {
        $common = [
            '{{customer_name}}'  => 'Volledige naam van de klant',
            '{{customer_email}}' => 'E-mailadres van de klant',
            '{{order_number}}'   => 'Ordernummer',
        ];

        $specific = match ($type) {
            'product' => [
                '{{product_name}}'  => 'Naam van het product',
                '{{variant_name}}'  => 'Naam van de variatie (indien van toepassing)',
                '{{quantity}}'      => 'Aantal besteld',
                '{{product_image}}' => 'URL van de hoofdafbeelding van het product, bijv. <img src="{{product_image}}">',
            ],
            'gift-card' => [
                '{{gift_card_name}}' => 'Naam van de cadeaubon',
                '{{voucher_code}}'   => 'De unieke boncode',
                '{{voucher_amount}}' => 'Bedrag van de bon (bijv. € 50,00)',
                '{{valid_until}}'    => 'Geldig tot datum',
            ],
            default => [],
        };

        return array_merge($common, $specific);
    }
}
