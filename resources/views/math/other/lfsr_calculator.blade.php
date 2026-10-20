<x-calc.page
    title="LFSR Calculator - SolveKit"
    description="Free LFSR calculator: the output sequence, states and period of a Fibonacci or Galois linear-feedback shift register."
    lede="Run a linear-feedback shift register."
    about="An LFSR shifts its bits and feeds back the XOR of the tapped bits. With taps forming a primitive polynomial, an n-bit register visits all 2ⁿ − 1 non-zero states before repeating; 16, 14, 13, 11 is a classic 16-bit choice. LFSRs generate test patterns, CRCs and pseudo-random bits (not secure randomness)."
    :calc="['engine' => 'mt-other', 'tool' => 'lfsr', 'fields' => ['bits', 'taps', 'seed', 'steps', 'type']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the period of the 16-bit LFSR with taps 16, 14, 13, 11?', 'answer' => '65,535.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="bits" label="Register length (bits)" value="16" min="2" max="32" step="1" />
        <x-calc.field name="taps" label="Taps" value="16, 14, 13, 11" type="text" inputmode="text" />
        <x-calc.field name="seed" label="Seed (binary or 0x hex)" value="0xACE1" type="text" inputmode="text" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="steps" label="Bits to output" value="32" min="1" max="512" step="1" />
        <x-calc.select name="type" label="Type" :options="['fibonacci' => 'Fibonacci', 'galois' => 'Galois']" selected="fibonacci" />
    </div>

    <x-calc.result label="Output bits" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['bits' => 16, 'taps' => '16, 14, 13, 11', 'seed' => '0xACE1', 'steps' => 32, 'type' => 'fibonacci'],
        'Small' => ['bits' => 4, 'taps' => '4, 3', 'seed' => '1000', 'steps' => 20, 'type' => 'fibonacci'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'period' => ['label' => 'Period'],
            'maximal' => ['label' => 'Maximal length?'],
            'states' => ['label' => 'First states'],
            'ones' => ['label' => 'Balance'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>xₙ = ⊕ taps</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
