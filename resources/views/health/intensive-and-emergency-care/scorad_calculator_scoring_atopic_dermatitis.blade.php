<x-calc.page
    title="SCORAD Calculator - SCORing Atopic Dermatitis - SolveKit"
    description="Free SCORAD calculator: atopic dermatitis (eczema) severity from extent, six intensity signs, itch and sleep loss (0–103)."
    lede="Score eczema severity with SCORAD."
    about="SCORAD (European Task Force on Atopic Dermatitis 1993) = A ÷ 5 + 7B ÷ 2 + C, where A is the affected body surface (%, rule of nines), B the sum of six intensity items scored 0–3, and C the itch and sleeplessness scores (0–10 each) over the last three days. Under 25 is mild, 25–50 moderate and over 50 severe. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-clinical', 'tool' => 'scorad', 'fields' => ['extent', 'erythema', 'oedema', 'oozing', 'excoriation', 'lichen', 'dryness', 'itch', 'sleep']]"
    :how-to="[
        ['name' => 'Estimate the area affected', 'text' => 'Rule of nines.'],
        ['name' => 'Grade the six signs on a typical area', 'text' => ''],
        ['name' => 'Rate itch and sleep loss', 'text' => 'Average of the last 3 nights.'],
    ]"
    :faqs="[
        ['question' => 'What is the SCORAD for 20% area, intensity 8, itch 5 and sleep loss 3?', 'answer' => '40.0: Moderate (25–50).'],
    ]"
>
    <x-calc.field name="extent" label="Body surface affected (A)" value="20" min="0" max="100" step="any" suffix="%" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="erythema" label="Redness" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="2" />
        <x-calc.select name="oedema" label="Swelling or papules" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="oozing" label="Oozing or crusts" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="excoriation" label="Scratch marks" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="lichen" label="Skin thickening" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="1" />
        <x-calc.select name="dryness" label="Dryness (unaffected skin)" :options="['0' => '0 – none', '1' => '1 – mild', '2' => '2 – moderate', '3' => '3 – severe']" selected="2" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="itch" label="Itch (C, 0–10)" value="5" min="0" max="10" step="1" />
        <x-calc.field name="sleep" label="Sleeplessness (C, 0–10)" value="3" min="0" max="10" step="1" />
    </div>

    <x-calc.result label="SCORAD" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['extent' => 20, 'erythema' => '2', 'oedema' => '1', 'oozing' => '1', 'excoriation' => '1', 'lichen' => '1', 'dryness' => '2', 'itch' => 5, 'sleep' => 3],
        'Severe' => ['extent' => 60, 'erythema' => '3', 'oedema' => '2', 'oozing' => '2', 'excoriation' => '3', 'lichen' => '2', 'dryness' => '3', 'itch' => 9, 'sleep' => 8],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'objective' => ['label' => 'Objective SCORAD'],
            'parts' => ['label' => 'Working'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>SCORAD = A/5 + 7B/2 + C</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
