<x-calc.page
    title="Cell Doubling Time Calculator - SolveKit"
    description="Free cell doubling time calculator: population doubling time, growth rate and fold change from two cell counts."
    lede="Work out how long a cell population takes to double."
    about="For exponential growth N = N₀ × 2^(t ÷ Td), so Td = t × ln 2 ÷ ln(N ÷ N₀). Mammalian cell lines typically double every 18 to 48 hours."
    :calc="['engine' => 'lab', 'tool' => 'doubling_time', 'fields' => ['start', 'end', 'time']]"
    :how-to="[
        ['name' => 'Enter the counts', 'text' => 'Seeded and harvested cell numbers.'],
        ['name' => 'Enter the time', 'text' => 'Hours in culture between counts.'],
    ]"
    :faqs="[
        ['question' => 'What is a normal doubling time for HeLa?', 'answer' => 'About 20 to 24 hours.'],
        ['question' => 'Should I include the lag phase?', 'answer' => 'No, seed and wait for cells to attach and start dividing, or the doubling time looks longer.'],
        ['question' => 'What is the growth rate?', 'answer' => 'ln(N ÷ N₀) ÷ t, the specific growth rate per hour.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting count" value="200000" min="0" />
        <x-calc.field name="end" label="Final count" value="800000" min="0" />
    </div>

    <x-calc.field name="time" label="Time between counts" value="48" min="0" suffix="h" />

    <x-calc.result label="Doubling time" />

    <x-calc.options :examples="[
        '4× in 48 h' => ['start' => 200000, 'end' => 800000, 'time' => 48],
        'Slow line' => ['start' => 100000, 'end' => 250000, 'time' => 72],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'rate' => ['label' => 'Growth rate'],
            'fold' => ['label' => 'Fold change'],
            'doublings' => ['label' => 'Doublings'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Td = t × ln 2 ÷ ln(N ÷ N₀)</li>
            <li>μ = ln(N ÷ N₀) ÷ t</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
