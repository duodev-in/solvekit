<x-calc.page
    title="Dry Matter Calculator - SolveKit"
    description="Free dry matter calculator: convert pet food nutrients from as-fed to dry-matter basis and compare wet and dry foods."
    lede="Convert a pet food label to dry-matter basis to compare foods fairly."
    about="Labels show nutrients as fed, including water. Wet food is about 75 to 80% water, so its percentages look low next to kibble. Dividing by the dry-matter share (100% − moisture) puts every food on the same footing."
    :calc="['engine' => 'animals', 'tool' => 'dry_matter', 'fields' => ['nutrient', 'moisture', 'nutrient_b', 'moisture_b']]"
    :how-to="[
        ['name' => 'Read the label', 'text' => 'Guaranteed analysis: the nutrient and moisture.'],
        ['name' => 'Add a second food', 'text' => 'To compare wet and dry fairly.'],
    ]"
    :faqs="[
        ['question' => 'Why use dry matter?', 'answer' => 'It removes water so foods with different moisture can be compared.'],
        ['question' => 'Is the guaranteed analysis exact?', 'answer' => 'No: it gives minimums and maximums, so the true value may differ a little.'],
        ['question' => 'Which has more protein, wet or dry food?', 'answer' => 'Often wet food, once water is removed; this calculator shows it.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nutrient" label="Nutrient as fed (e.g. protein)" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="moisture" label="Moisture" value="78" min="0" max="100" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nutrient_b" label="Second food nutrient (optional)" value="26" min="0" max="100" suffix="%" placeholder="Optional" />
        <x-calc.field name="moisture_b" label="Second food moisture" value="10" min="0" max="100" suffix="%" placeholder="Optional" />
    </div>

    <x-calc.result label="Dry-matter basis" />

    <x-calc.options :examples="[
        'Wet 10% vs dry 26%' => ['nutrient' => 10, 'moisture' => 78, 'nutrient_b' => 26, 'moisture_b' => 10],
        'Fat in kibble' => ['nutrient' => 16, 'moisture' => 10, 'nutrient_b' => '', 'moisture_b' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'dm' => ['label' => 'Dry matter'],
            'second' => ['label' => 'Second food'],
            'compare' => ['label' => 'Comparison'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>DM% = as-fed % ÷ (1 − moisture %)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
