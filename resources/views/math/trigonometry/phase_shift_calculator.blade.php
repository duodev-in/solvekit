<x-calc.page
    title="Phase Shift Calculator - SolveKit"
    description="Free phase shift calculator: amplitude, period, phase shift and vertical shift of y = A sin(Bx − C) + D, with a graph."
    lede="Find the phase shift."
    about="For y = A sin(Bx − C) + D the amplitude is |A|, the period 2π/|B|, the phase (horizontal) shift C/B and the midline y = D. Rewrite as A sin(B(x − C/B)) + D to see the shift."
    :calc="['engine' => 'mt-trig', 'tool' => 'phase_shift', 'fields' => ['fn', 'a', 'b', 'c', 'd']]"
    :how-to="[
        ['name' => 'Enter the angle or value', 'text' => 'Angles can be in degrees, radians or multiples of π.'],
        ['name' => 'Read the result', 'text' => 'Standard angles give exact values (roots and fractions); the working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the phase shift of y = 2 sin(3x − 1.5) + 1?', 'answer' => '0.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="fn" label="Function" :options="['sin' => 'sin', 'cos' => 'cos', 'tan' => 'tan']" selected="sin" />
        <x-calc.field name="a" label="A (amplitude)" value="2" step="any" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="b" label="B" value="3" step="any" />
        <x-calc.field name="c" label="C" value="1.5" step="any" />
        <x-calc.field name="d" label="D (vertical shift)" value="1" step="any" />
    </div>

    <x-calc.result label="Phase shift" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['fn' => 'sin', 'a' => 2, 'b' => 3, 'c' => 1.5, 'd' => 1],
        'Cosine' => ['fn' => 'cos', 'a' => -1, 'b' => 0.5, 'c' => -1, 'd' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Graph" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'amplitude' => ['label' => 'Amplitude'],
            'period' => ['label' => 'Period'],
            'shift' => ['label' => 'Phase shift'],
            'vertical' => ['label' => 'Vertical shift'],
            'range' => ['label' => 'Range'],
            'frequency' => ['label' => 'Frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>shift = C ÷ B, period = 2π ÷ |B|</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
