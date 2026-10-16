<x-calc.page
    title="Chicken Coop Size Calculator - SolveKit"
    description="Free chicken coop size calculator: coop and run floor area, nest boxes and roost length for your flock."
    lede="Work out the coop and run space for your hens."
    about="Common extension guidance for backyard flocks is about 4 ft² of coop floor and 10 ft² of run per standard hen, about half for bantams and more for large breeds. Add one nest box for every four hens and 8 in of roost per bird."
    :calc="['engine' => 'animals', 'tool' => 'chicken_coop', 'fields' => ['hens', 'breed']]"
    :how-to="[
        ['name' => 'Count the hens', 'text' => 'Plan for the flock size you will grow to.'],
        ['name' => 'Pick the breed size', 'text' => 'Bantam, standard or large.'],
    ]"
    :faqs="[
        ['question' => 'How much space does a chicken need?', 'answer' => 'About 4 ft² inside and 10 ft² in the run for a standard hen.'],
        ['question' => 'How many nest boxes?', 'answer' => 'One for every 4 hens; they share.'],
        ['question' => 'How high should roosts be?', 'answer' => 'About 2 to 4 ft off the floor, higher than the nest boxes.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="hens" label="Number of hens" value="6" min="1" step="1" />
        <x-calc.select name="breed" label="Breed size" :options="['bantam' => 'Bantam', 'standard' => 'Standard', 'large' => 'Large (Brahma, Cochin)']" selected="standard" />
    </div>

    <x-calc.result label="Coop floor area" />

    <x-calc.options :examples="[
        '6 standard hens' => ['hens' => 6, 'breed' => 'standard'],
        '10 bantams' => ['hens' => 10, 'breed' => 'bantam'],
        '4 Brahmas' => ['hens' => 4, 'breed' => 'large'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'run' => ['label' => 'Run area'],
            'coop_m2' => ['label' => 'Coop in m²'],
            'nests' => ['label' => 'Nest boxes'],
            'roost' => ['label' => 'Roost length'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>coop = hens × 2 / 4 / 5 ft² (bantam / standard / large)</li>
            <li>run = hens × 5 / 10 / 15 ft²</li>
            <li>nests = ⌈hens ÷ 4⌉</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
