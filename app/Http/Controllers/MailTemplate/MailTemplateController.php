<?php

namespace App\Http\Controllers\MailTemplate;

use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MailTemplateController extends Controller
{
    private function validateType(string $type): void
    {
        abort_unless(in_array($type, ['product', 'gift-card', 'room']), 404);
    }

    private function authorizeRoom(Room $room): void
    {
        abort_unless($room->escaperoom_id === auth()->user()->escaperoom_id, 404);
    }

    private function authorizeTemplate(MailTemplate $template, string $type, ?Room $room): void
    {
        abort_unless(
            $template->escaperoom_id === auth()->user()->escaperoom_id
                && $template->type === $type
                && $template->room_id === ($room?->id ?? 0),
            404
        );
    }

    private function indexUrl(string $type, ?Room $room): string
    {
        return $room ? route('mail-templates.room.index', $room) : route('mail-templates.index', $type);
    }

    // --- Global (product / gift-card) routes ---

    public function index(string $type)
    {
        $this->validateType($type);

        return $this->renderIndex($type, null);
    }

    public function create(string $type)
    {
        $this->validateType($type);

        return $this->renderCreate($type, null);
    }

    public function store(Request $request, string $type)
    {
        $this->validateType($type);

        return $this->handleStore($request, $type, null);
    }

    public function edit(string $type, MailTemplate $template)
    {
        $this->validateType($type);
        $this->authorizeTemplate($template, $type, null);

        return $this->renderEdit($type, $template, null);
    }

    public function update(Request $request, string $type, MailTemplate $template)
    {
        $this->validateType($type);
        $this->authorizeTemplate($template, $type, null);

        return $this->handleUpdate($request, $type, $template, null);
    }

    public function destroy(string $type, MailTemplate $template)
    {
        $this->validateType($type);
        $this->authorizeTemplate($template, $type, null);

        return $this->handleDestroy($type, $template, null);
    }

    public function uploadImage(Request $request, string $type)
    {
        $this->validateType($type);

        return $this->handleUploadImage($request);
    }

    // --- Room-scoped routes ---

    public function roomIndex(Room $room)
    {
        $this->authorizeRoom($room);

        return $this->renderIndex('room', $room);
    }

    public function roomCreate(Room $room)
    {
        $this->authorizeRoom($room);

        return $this->renderCreate('room', $room);
    }

    public function roomStore(Request $request, Room $room)
    {
        $this->authorizeRoom($room);

        return $this->handleStore($request, 'room', $room);
    }

    public function roomEdit(Room $room, MailTemplate $template)
    {
        $this->authorizeRoom($room);
        $this->authorizeTemplate($template, 'room', $room);

        return $this->renderEdit('room', $template, $room);
    }

    public function roomUpdate(Request $request, Room $room, MailTemplate $template)
    {
        $this->authorizeRoom($room);
        $this->authorizeTemplate($template, 'room', $room);

        return $this->handleUpdate($request, 'room', $template, $room);
    }

    public function roomDestroy(Room $room, MailTemplate $template)
    {
        $this->authorizeRoom($room);
        $this->authorizeTemplate($template, 'room', $room);

        return $this->handleDestroy('room', $template, $room);
    }

    public function roomUploadImage(Request $request, Room $room)
    {
        $this->authorizeRoom($room);

        return $this->handleUploadImage($request);
    }

    // --- Shared implementations ---

    private function renderIndex(string $type, ?Room $room)
    {
        $escaperoomId = auth()->user()->escaperoom_id;
        $templates    = MailTemplate::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->where('room_id', $room?->id ?? 0)
            ->orderBy('locale')
            ->get();
        $locales = MailTemplate::locales();

        return view('mailTemplates.index', compact('type', 'room', 'templates', 'locales'));
    }

    private function renderCreate(string $type, ?Room $room)
    {
        $escaperoomId = auth()->user()->escaperoom_id;
        $locales      = MailTemplate::locales();
        $usedLocales  = MailTemplate::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->where('room_id', $room?->id ?? 0)
            ->pluck('locale')
            ->toArray();
        $variables = $this->variableHints($type);

        return view('mailTemplates.form', compact('type', 'room', 'locales', 'usedLocales', 'variables'));
    }

    private function handleStore(Request $request, string $type, ?Room $room)
    {
        $request->validate([
            'locale'     => ['required', 'in:' . implode(',', array_keys(MailTemplate::locales()))],
            'subject'    => ['required', 'string', 'max:255'],
            'body'       => ['required', 'string'],
            'attach_ics' => ['nullable', 'boolean'],
        ]);

        MailTemplate::updateOrCreate(
            [
                'escaperoom_id' => auth()->user()->escaperoom_id,
                'type'          => $type,
                'room_id'       => $room?->id ?? 0,
                'locale'        => $request->locale,
            ],
            [
                'subject'    => $request->subject,
                'body'       => $request->body,
                'attach_ics' => $type === 'room' ? $request->boolean('attach_ics') : false,
            ]
        );

        return redirect()->to($this->indexUrl($type, $room))
            ->with('message', 'Sjabloon opgeslagen.');
    }

    private function renderEdit(string $type, MailTemplate $template, ?Room $room)
    {
        $locales   = MailTemplate::locales();
        $variables = $this->variableHints($type);

        return view('mailTemplates.form', compact('type', 'room', 'template', 'locales', 'variables'));
    }

    private function handleUpdate(Request $request, string $type, MailTemplate $template, ?Room $room)
    {
        $request->validate([
            'subject'    => ['required', 'string', 'max:255'],
            'body'       => ['required', 'string'],
            'attach_ics' => ['nullable', 'boolean'],
        ]);

        $template->update([
            'subject'    => $request->subject,
            'body'       => $request->body,
            'attach_ics' => $type === 'room' ? $request->boolean('attach_ics') : false,
        ]);

        return redirect()->to($this->indexUrl($type, $room))
            ->with('message', 'Sjabloon bijgewerkt.');
    }

    private function handleDestroy(string $type, MailTemplate $template, ?Room $room)
    {
        $template->delete();

        return redirect()->to($this->indexUrl($type, $room))
            ->with('message', 'Sjabloon verwijderd.');
    }

    private function handleUploadImage(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('image')->store(
            'escaperooms/' . auth()->user()->escaperoom_id . '/mail-templates',
            'public'
        );

        return response()->json(['url' => asset(Storage::url($path))]);
    }

    private function variableHints(string $type): array
    {
        $common = [
            '{{customer_name}}'  => 'Volledige naam van de klant',
            '{{first_name}}'     => 'Voornaam van de klant',
            '{{last_name}}'      => 'Achternaam van de klant',
            '{{customer_email}}' => 'E-mailadres van de klant',
            '{{order_number}}'   => 'Ordernummer',
            '{{company_name}}'   => 'Naam van de escaperoom',
            '{{company_email}}'  => 'E-mailadres van de escaperoom',
        ];

        $specific = match ($type) {
            'product' => [
                '{{product_name}}'  => 'Naam van het product',
                '{{variant_name}}'  => 'Naam van de variatie (indien van toepassing)',
                '{{quantity}}'      => 'Aantal besteld',
                '{{product_image}}' => 'Toont de hoofdafbeelding van het product. Plaats deze variabele op de plek waar de foto moet verschijnen.',
            ],
            'gift-card' => [
                '{{gift_card_name}}' => 'Naam van de cadeaubon',
                '{{voucher_code}}'   => 'De unieke boncode',
                '{{voucher_amount}}' => 'Bedrag van de bon (bijv. € 50,00)',
                '{{valid_until}}'    => 'Geldig tot datum',
            ],
            'room' => [
                '{{room_name}}'  => 'Naam van de kamer',
                '{{date}}'       => 'Datum van de afspraak',
                '{{start_time}}' => 'Starttijd van de afspraak',
                '{{end_time}}'   => 'Eindtijd van de afspraak',
                '{{players}}'    => 'Aantal spelers',
                '{{address}}'    => 'Adres van de locatie',
            ],
            default => [],
        };

        return array_merge($common, $specific);
    }
}
