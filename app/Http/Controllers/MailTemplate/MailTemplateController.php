<?php

namespace App\Http\Controllers\MailTemplate;

use App\Http\Controllers\Controller;
use App\Models\MailTemplate;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MailTemplateController extends Controller
{
    private const ROOM_SUBTYPES = ['confirmation', 'reminder', 'cancellation'];

    private function validateType(string $type): void
    {
        abort_unless(in_array($type, ['product', 'gift-card']), 404);
    }

    private function validateSubtype(string $subtype): void
    {
        abort_unless(in_array($subtype, self::ROOM_SUBTYPES), 404);
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
        return $room ? route('mail-templates.room.index', [$room, substr($type, 5)]) : route('mail-templates.index', $type);
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

    public function roomIndex(Room $room, string $subtype)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);

        return $this->renderIndex('room_' . $subtype, $room);
    }

    public function roomCreate(Room $room, string $subtype)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);

        return $this->renderCreate('room_' . $subtype, $room);
    }

    public function roomStore(Request $request, Room $room, string $subtype)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);

        return $this->handleStore($request, 'room_' . $subtype, $room);
    }

    public function roomEdit(Room $room, string $subtype, MailTemplate $template)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);
        $this->authorizeTemplate($template, 'room_' . $subtype, $room);

        return $this->renderEdit('room_' . $subtype, $template, $room);
    }

    public function roomUpdate(Request $request, Room $room, string $subtype, MailTemplate $template)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);
        $this->authorizeTemplate($template, 'room_' . $subtype, $room);

        return $this->handleUpdate($request, 'room_' . $subtype, $template, $room);
    }

    public function roomDestroy(Room $room, string $subtype, MailTemplate $template)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);
        $this->authorizeTemplate($template, 'room_' . $subtype, $room);

        return $this->handleDestroy('room_' . $subtype, $template, $room);
    }

    public function roomUploadImage(Request $request, Room $room, string $subtype)
    {
        $this->authorizeRoom($room);
        $this->validateSubtype($subtype);

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
        $subtype = $room ? substr($type, 5) : null;

        return view('mailTemplates.index', compact('type', 'room', 'templates', 'locales', 'subtype'));
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
                'attach_ics' => in_array($type, ['room_confirmation', 'room_reminder'], true) ? $request->boolean('attach_ics') : false,
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
            'attach_ics' => in_array($type, ['room_confirmation', 'room_reminder'], true) ? $request->boolean('attach_ics') : false,
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
            '{{customer_name}}'  => __('mailTemplates.var_customer_name'),
            '{{first_name}}'     => __('mailTemplates.var_first_name'),
            '{{last_name}}'      => __('mailTemplates.var_last_name'),
            '{{customer_email}}' => __('mailTemplates.var_customer_email'),
            '{{order_number}}'   => __('mailTemplates.var_order_number'),
            '{{company_name}}'   => __('mailTemplates.var_company_name'),
            '{{company_email}}'  => __('mailTemplates.var_company_email'),
        ];

        $specific = match ($type) {
            'product' => [
                '{{product_name}}'  => __('mailTemplates.var_product_name'),
                '{{variant_name}}'  => __('mailTemplates.var_variant_name'),
                '{{quantity}}'      => __('mailTemplates.var_quantity'),
                '{{product_image}}' => __('mailTemplates.var_product_image'),
            ],
            'gift-card' => [
                '{{gift_card_name}}' => __('mailTemplates.var_gift_card_name'),
                '{{voucher_code}}'   => __('mailTemplates.var_voucher_code'),
                '{{voucher_amount}}' => __('mailTemplates.var_voucher_amount'),
                '{{valid_until}}'    => __('mailTemplates.var_valid_until'),
            ],
            'room_confirmation', 'room_reminder' => [
                '{{room_name}}'  => __('mailTemplates.var_room_name'),
                '{{date}}'       => __('mailTemplates.var_date'),
                '{{start_time}}' => __('mailTemplates.var_start_time'),
                '{{end_time}}'   => __('mailTemplates.var_end_time'),
                '{{players}}'    => __('mailTemplates.var_players'),
                '{{address}}'    => __('mailTemplates.var_address'),
            ],
            'room_cancellation' => [
                '{{room_name}}'      => __('mailTemplates.var_room_name'),
                '{{date}}'           => __('mailTemplates.var_date'),
                '{{start_time}}'     => __('mailTemplates.var_start_time'),
                '{{end_time}}'       => __('mailTemplates.var_end_time'),
                '{{players}}'        => __('mailTemplates.var_players'),
                '{{address}}'        => __('mailTemplates.var_address'),
                '{{voucher_code}}'   => __('mailTemplates.var_voucher_code_optional'),
                '{{voucher_amount}}' => __('mailTemplates.var_voucher_amount_optional'),
                '{{valid_until}}'    => __('mailTemplates.var_valid_until_optional'),
            ],
            default => [],
        };

        return array_merge($common, $specific);
    }
}
