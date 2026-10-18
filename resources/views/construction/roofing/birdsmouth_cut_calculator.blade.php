<x-calc.page
    title="Birdsmouth Cut Calculator - SolveKit"
    description="Free birdsmouth cut calculator: plumb (heel) cut height, notch depth and heel height for a rafter seat cut, with the notch depth check."
    lede="Work out the birdsmouth cut for a rafter."
    about="The seat cut sits flat on the wall plate and the plumb cut runs vertically. For a seat of length s at roof angle θ, the plumb cut is s × tan θ and the notch cuts s × sin θ into the rafter's depth. NDS 4.4.3 limits notches at the ends of sawn lumber on the tension side to a quarter of the depth; carpenters often quote a third."
    :calc="['engine' => 'con-roof', 'tool' => 'birdsmouth', 'fields' => ['pitch', 'depth', 'seat'], 'unitFields' => ['depth' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'seat' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the pitch and rafter depth', 'text' => 'Actual depth: a 2×8 is 7¼ in.'],
        ['name' => 'Enter the seat length', 'text' => 'Usually the wall plate width, 3½ in.'],
    ]"
    :faqs="[
        ['question' => 'How deep is a birdsmouth on a 2×8 at 6/12?', 'answer' => 'With a 3½ in seat, the plumb cut is 1¾ in and the notch 1 9/16 in deep.'],
        ['question' => 'How deep can a birdsmouth be?', 'answer' => 'NDS limits end notches to ¼ of the depth; many builders use ⅓ as the rule.'],
        ['question' => 'What is the heel height?', 'answer' => 'The rafter\'s height above the wall plate at the outside of the wall.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="pitch" label="Pitch (rise per 12)" value="6" min="0.5" step="0.5" />
        <x-calc.field name="depth" label="Rafter depth (actual)" value="7.25" min="0" placeholder="Rafter depth (actual)">
            <label for="calc-depth-unit" class="sr-only">Rafter depth (actual) unit</label>
            <select id="calc-depth-unit" name="depth-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="seat" label="Seat cut (bearing)" value="3.5" min="0" placeholder="Seat cut (bearing)">
            <label for="calc-seat-unit" class="sr-only">Seat cut (bearing) unit</label>
            <select id="calc-seat-unit" name="seat-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Plumb cut (heel cut) height" />

    <x-calc.options :examples="[
        '2×8 at 6/12' => ['pitch' => 6, 'depth' => 7.25, 'depth-unit' => 'in', 'seat' => 3.5, 'seat-unit' => 'in'],
        '2×10 at 8/12, 2×6 wall' => ['pitch' => 8, 'depth' => 9.25, 'depth-unit' => 'in', 'seat' => 5.5, 'seat-unit' => 'in'],
        '2×6 at 12/12' => ['pitch' => 12, 'depth' => 5.5, 'depth-unit' => 'in', 'seat' => 3.5, 'seat-unit' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'notch' => ['label' => 'Notch depth'],
            'heel' => ['label' => 'Heel height'],
            'remaining' => ['label' => 'Left at bearing'],
            'check' => ['label' => 'Check'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>plumb = seat × tan θ</li>
            <li>notch depth = seat × sin θ</li>
            <li>heel = depth ÷ cos θ − plumb</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
