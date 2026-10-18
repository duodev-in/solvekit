<x-calc.page
    title="Rivet Size Calculator - SolveKit"
    description="Free rivet size calculator: solid rivet diameter, length, edge distance and pitch from sheet thickness, by FAA AC 43.13-1B practice."
    lede="Work out the rivet diameter, length and spacing for a joint."
    about="FAA Advisory Circular 43.13-1B practice for solid rivets: a diameter of about three times the thicker sheet, a shank length of the grip plus 1½ diameters, an edge distance of at least two diameters and a pitch of three to four diameters. These are layout rules; a joint's strength must still be checked."
    :calc="['engine' => 'con-mech', 'tool' => 'rivet', 'fields' => ['thick', 'grip'], 'unitFields' => ['thick' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all(), 'grip' => collect(config('units.length'))->only(['in', 'mm', 'cm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the thicker sheet', 'text' => 'And the total stack thickness (grip).'],
    ]"
    :faqs="[
        ['question' => 'What rivet for 0.040 in sheet?', 'answer' => '⅛ in (3 × 0.040 = 0.120 in).'],
        ['question' => 'How long should a rivet be?', 'answer' => 'Grip plus 1½ times the diameter.'],
        ['question' => 'How far from the edge?', 'answer' => 'At least two diameters.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="thick" label="Thicker sheet" value="0.04" min="0" placeholder="Thicker sheet">
            <label for="calc-thick-unit" class="sr-only">Thicker sheet unit</label>
            <select id="calc-thick-unit" name="thick-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="grip" label="Total grip (all sheets)" value="0.072" min="0" placeholder="Total grip (all sheets)">
            <label for="calc-grip-unit" class="sr-only">Total grip (all sheets) unit</label>
            <select id="calc-grip-unit" name="grip-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'mm', 'cm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Rivet diameter" />

    <x-calc.options :examples="[
        '0.040 + 0.032 in sheet' => ['thick' => 0.04, 'thick-unit' => 'in', 'grip' => 0.072, 'grip-unit' => 'in'],
        '0.063 in sheets' => ['thick' => 0.063, 'thick-unit' => 'in', 'grip' => 0.126, 'grip-unit' => 'in'],
        '1 mm sheets' => ['thick' => 1, 'thick-unit' => 'mm', 'grip' => 2, 'grip-unit' => 'mm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'length' => ['label' => 'Rivet length'],
            'edge' => ['label' => 'Edge distance'],
            'pitch' => ['label' => 'Rivet pitch'],
            'mm' => ['label' => 'Metric'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>D ≈ 3 × thicker sheet</li>
            <li>length = grip + 1.5 D</li>
            <li>edge ≥ 2 D; pitch 3–4 D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
