<x-calc.page
    title="GVWR Calculator - SolveKit"
    description="Free GVWR calculator: payload capacity left under a vehicle's gross vehicle weight rating after passengers, cargo and trailer tongue weight, and a GCWR check."
    lede="Check whether your loaded vehicle is within its weight rating."
    about="Payload capacity = GVWR − curb weight. Everything in or on the vehicle counts against it: passengers, cargo and the trailer's tongue weight (usually 10–15% of the trailer). The gross combined weight rating (GCWR) limits the vehicle plus trailer. Ratings are on the door-jamb sticker; weigh the vehicle on a scale for real numbers."
    :calc="['engine' => 'ev-transport', 'tool' => 'gvwr', 'fields' => ['gvwr', 'curb', 'people', 'cargo', 'tongue', 'gcwr', 'trailer'], 'unitFields' => ['gvwr' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'curb' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'people' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'cargo' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'tongue' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'gcwr' => collect(config('units.mass'))->only(['lb', 'kg'])->all(), 'trailer' => collect(config('units.mass'))->only(['lb', 'kg'])->all()]]"
    :how-to="[
        ['name' => 'Enter the ratings', 'text' => 'From the door-jamb sticker.'],
        ['name' => 'Add the load', 'text' => 'People, cargo and tongue weight.'],
    ]"
    :faqs="[
        ['question' => 'How do I calculate payload?', 'answer' => 'GVWR − curb weight.'],
        ['question' => 'Does tongue weight count against payload?', 'answer' => 'Yes, all of it.'],
        ['question' => 'What happens if I exceed GVWR?', 'answer' => 'Brakes, tires and suspension are overloaded, and it may be illegal.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gvwr" label="GVWR" value="7000" min="0" placeholder="GVWR">
            <label for="calc-gvwr-unit" class="sr-only">GVWR unit</label>
            <select id="calc-gvwr-unit" name="gvwr-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="curb" label="Curb weight" value="5200" min="0" placeholder="Curb weight">
            <label for="calc-curb-unit" class="sr-only">Curb weight unit</label>
            <select id="calc-curb-unit" name="curb-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="people" label="Passengers" value="450" min="0" placeholder="Passengers">
            <label for="calc-people-unit" class="sr-only">Passengers unit</label>
            <select id="calc-people-unit" name="people-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="cargo" label="Cargo" value="400" min="0" placeholder="Cargo">
            <label for="calc-cargo-unit" class="sr-only">Cargo unit</label>
            <select id="calc-cargo-unit" name="cargo-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="tongue" label="Trailer tongue weight" value="600" min="0" placeholder="Trailer tongue weight">
            <label for="calc-tongue-unit" class="sr-only">Trailer tongue weight unit</label>
            <select id="calc-tongue-unit" name="tongue-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="gcwr" label="GCWR (optional)" value="14000" min="0" placeholder="GCWR (optional)">
            <label for="calc-gcwr-unit" class="sr-only">GCWR (optional) unit</label>
            <select id="calc-gcwr-unit" name="gcwr-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="trailer" label="Loaded trailer (optional)" value="6000" min="0" placeholder="Loaded trailer (optional)">
            <label for="calc-trailer-unit" class="sr-only">Loaded trailer (optional) unit</label>
            <select id="calc-trailer-unit" name="trailer-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['lb', 'kg']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'lb')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Payload left" />

    <x-calc.options :examples="[
        'Pickup towing a camper' => ['gvwr' => 7000, 'gvwr-unit' => 'lb', 'curb' => 5200, 'curb-unit' => 'lb', 'people' => 450, 'people-unit' => 'lb', 'cargo' => 400, 'cargo-unit' => 'lb', 'tongue' => 600, 'tongue-unit' => 'lb', 'gcwr' => 14000, 'gcwr-unit' => 'lb', 'trailer' => 6000, 'trailer-unit' => 'lb'],
        'Overloaded SUV' => ['gvwr' => 2600, 'gvwr-unit' => 'kg', 'curb' => 2100, 'curb-unit' => 'kg', 'people' => 350, 'people-unit' => 'kg', 'cargo' => 120, 'cargo-unit' => 'kg', 'tongue' => 80, 'tongue-unit' => 'kg', 'gcwr' => '', 'gcwr-unit' => 'kg', 'trailer' => '', 'trailer-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'kg' => ['label' => 'In kg'],
            'capacity' => ['label' => 'Payload capacity'],
            'gross' => ['label' => 'Gross weight'],
            'gcwr' => ['label' => 'GCWR check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>payload capacity = GVWR − curb weight</li>
            <li>left = capacity − (people + cargo + tongue)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
