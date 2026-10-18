<x-calc.page
    title="Bed Size Calculator - SolveKit"
    description="Free bed size calculator: standard mattress dimensions for twin, full, queen, king and other beds in the US, UK, Europe, Australia and India, and whether a bed fits your room."
    lede="Look up mattress sizes and check a bed fits your room."
    about="Mattress sizes differ by country: a US queen is 60 × 80 in, a UK double 135 × 190 cm. Sizes vary by a few centimeters between makers. A comfortable bedroom leaves walkways of about 24–30 inches (60–75 cm) at the foot and both sides of the bed, with the head against a wall."
    :calc="['engine' => 'ev-home', 'tool' => 'bed_size', 'fields' => ['region', 'size', 'room_length', 'room_width', 'clearance'], 'unitFields' => ['room_length' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'room_width' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'clearance' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()], 'data' => ['mattresses' => config('everyday_data.mattresses')]]"
    :how-to="[
        ['name' => 'Choose the region', 'text' => 'Sizes are listed smallest first.'],
        ['name' => 'Enter the room', 'text' => 'To check walkways.'],
    ]"
    :faqs="[
        ['question' => 'What size is a queen bed?', 'answer' => '60 × 80 inches (152 × 203 cm) in the US.'],
        ['question' => 'What is the difference between king and California king?', 'answer' => 'A king is wider (76 in); a California king is longer (84 in).'],
        ['question' => 'What room size fits a queen bed?', 'answer' => 'At least about 10 × 10 ft with 24-inch walkways.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="region" label="Region" :options="['us' => 'United States', 'uk' => 'United Kingdom', 'eu' => 'Europe', 'au' => 'Australia', 'in' => 'India']" selected="us" />
        <x-calc.select name="size" label="Size" :options="['0' => '1st size', '1' => '2nd size', '2' => '3rd size', '3' => '4th size', '4' => '5th size', '5' => '6th size']" selected="3" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="room_length" label="Room length (optional)" value="12" min="0" placeholder="Room length (optional)">
            <label for="calc-room_length-unit" class="sr-only">Room length (optional) unit</label>
            <select id="calc-room_length-unit" name="room_length-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="room_width" label="Room width" value="11" min="0" placeholder="Room width">
            <label for="calc-room_width-unit" class="sr-only">Room width unit</label>
            <select id="calc-room_width-unit" name="room_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="clearance" label="Walkway" value="24" min="0" placeholder="Walkway">
            <label for="calc-clearance-unit" class="sr-only">Walkway unit</label>
            <select id="calc-clearance-unit" name="clearance-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Mattress size" />

    <x-calc.options :examples="[
        'US queen, 12 × 11 ft room' => ['region' => 'us', 'size' => '3', 'room_length' => 12, 'room_length-unit' => 'ft', 'room_width' => 11, 'room_width-unit' => 'ft', 'clearance' => 24, 'clearance-unit' => 'in'],
        'UK king' => ['region' => 'uk', 'size' => '3', 'room_length' => 3.5, 'room_length-unit' => 'm', 'room_width' => 3.2, 'room_width-unit' => 'm', 'clearance' => 60, 'clearance-unit' => 'cm'],
        'Australian queen' => ['region' => 'au', 'size' => '3', 'room_length' => '', 'room_length-unit' => 'm', 'room_width' => '', 'room_width-unit' => 'm', 'clearance' => 60, 'clearance-unit' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'area' => ['label' => 'Area'],
            'fit' => ['label' => 'Room fit'],
        ]" />
        <x-calc.quick-ref heading="Sizes in this region" name="sizes" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>fits when length + walkway ≤ room length and width + 2 walkways ≤ room width</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
