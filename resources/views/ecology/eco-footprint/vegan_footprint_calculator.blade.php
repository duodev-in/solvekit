<x-calc.page
    title="Vegan Footprint Calculator - SolveKit"
    description="Free vegan footprint calculator: greenhouse gas, land and water saved by switching to a vegan diet, from the Scarborough et al. 2023 study of 55,504 UK diets."
    lede="Work out what switching to a vegan diet saves."
    about="Scarborough et al. (2023, Nature Food) linked the diets of 55,504 people in the UK with food life cycle data. Median daily greenhouse gas emissions ranged from 10.24 kg CO₂e for high meat-eaters to 2.47 kg for vegans, with land and water use falling in step. Results are standardised to 2,000 kcal a day."
    :calc="['engine' => 'eco-footprint', 'tool' => 'vegan', 'fields' => ['diet', 'people', 'years'], 'data' => ['diets' => config('ecology_data.diets')]]"
    :how-to="[
        ['name' => 'Choose your current diet', 'text' => 'By how much meat you eat.'],
        ['name' => 'Enter people and years', 'text' => 'For a household or a period.'],
    ]"
    :faqs="[
        ['question' => 'How much CO₂ does a vegan diet save?', 'answer' => 'About 2.8 t CO₂e a year compared with a high meat diet.'],
        ['question' => 'Is vegetarian much better than low meat?', 'answer' => 'The study found their footprints close: 4.16 against 5.37 kg CO₂e a day.'],
        ['question' => 'Does this include food waste?', 'answer' => 'It is based on food eaten, from life cycle data covering farm to retail.'],
    ]"
>
    <x-calc.select name="diet" label="Your current diet" :options="collect(config('ecology_data.diets'))->except('vegan')->map(fn ($d) => $d['name'])->all()" selected="medium_meat" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="people" label="People" value="1" min="1" step="1" />
        <x-calc.field name="years" label="Years" value="1" min="1" step="1" />
    </div>

    <x-calc.result label="Switching to a vegan diet" />

    <x-calc.options :examples="[
        'High meat-eater' => ['diet' => 'high_meat', 'people' => 1, 'years' => 1],
        'Family of 4, medium meat' => ['diet' => 'medium_meat', 'people' => 4, 'years' => 1],
        'Vegetarian, 10 years' => ['diet' => 'vegetarian', 'people' => 1, 'years' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'percent' => ['label' => 'Reduction'],
            'land' => ['label' => 'Land saved'],
            'water' => ['label' => 'Water saved'],
            'daily' => ['label' => 'Per day'],
        ]" />
        <x-calc.quick-ref heading="All diets (kg CO₂e a day)" name="diets" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>saving = (diet − vegan) kg CO₂e a day × 365.25 × people × years</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
