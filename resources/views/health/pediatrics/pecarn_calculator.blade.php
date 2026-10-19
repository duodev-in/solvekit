<x-calc.page
    title="PECARN Calculator - SolveKit"
    description="Free PECARN calculator: the PECARN head injury rule for children, which identifies those at very low risk of a clinically important brain injury who do not need a CT scan."
    lede="Apply the PECARN head injury rule."
    about="The PECARN rules (Kuppermann et al., Lancet 2009) were derived from over 42,000 children with minor head trauma (GCS 14–15) seen within 24 hours. Separate rules apply under 2 and from 2 years. Children with none of the findings have under 0.02% (under 2) or 0.05% risk of a clinically important brain injury. For clinicians; any worrying head injury needs medical assessment. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'pecarn', 'fields' => ['age', 'ams', 'skull', 'hematoma', 'acting', 'basilar', 'vomiting', 'headache', 'loc', 'mechanism']]"
    :how-to="[
        ['name' => 'Choose the age group', 'text' => ''],
        ['name' => 'Tick the findings', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the risk group for a 5-year-old with vomiting after a fall?', 'answer' => 'Intermediate risk: About 0.9% risk of a clinically important brain injury.'],
    ]"
>
    <x-calc.segmented name="age" legend="Age" :options="['under2' => 'Under 2 years', 'over2' => '2 years or older']" selected="over2" />

    <x-calc.checkbox name="ams" label="GCS 14 or other altered mental status (agitation, sleepiness, repetitive questions, slow response)" :checked="false" />

    <div data-show-when="age:under2" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.checkbox name="skull" label="Palpable skull fracture" :checked="false" />
            <x-calc.checkbox name="hematoma" label="Occipital, parietal or temporal scalp haematoma" :checked="false" />
        </div>
    </div>

    <div data-show-when="age:under2" hidden>
        <x-calc.checkbox name="acting" label="Not acting normally according to the parent" :checked="false" />
    </div>

    <div data-show-when="age:over2">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.checkbox name="basilar" label="Signs of basilar skull fracture" :checked="false" />
            <x-calc.checkbox name="vomiting" label="History of vomiting" :checked="false" />
        </div>
    </div>

    <div data-show-when="age:over2">
        <x-calc.checkbox name="headache" label="Severe headache" :checked="false" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.checkbox name="loc" label="Loss of consciousness (5 seconds or more if under 2)" :checked="false" />
        <x-calc.checkbox name="mechanism" label="Severe mechanism of injury (vehicle crash with ejection or rollover, fall over 1.5 m, 0.9 m if under 2, or head struck by a high-impact object)" :checked="false" />
    </div>

    <x-calc.result label="PECARN risk group" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['age' => 'over2', 'ams' => false, 'skull' => false, 'hematoma' => false, 'acting' => false, 'basilar' => false, 'vomiting' => false, 'headache' => false, 'loc' => false, 'mechanism' => false],
        'Vomiting' => ['age' => 'over2', 'vomiting' => true, 'ams' => false, 'skull' => false, 'hematoma' => false, 'acting' => false, 'basilar' => false, 'headache' => false, 'loc' => false, 'mechanism' => false],
        'Infant haematoma' => ['age' => 'under2', 'hematoma' => true, 'ams' => false, 'skull' => false, 'acting' => false, 'basilar' => false, 'vomiting' => false, 'headache' => false, 'loc' => false, 'mechanism' => false],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'action' => ['label' => 'CT advice'],
            'risk' => ['label' => 'Risk'],
            'source' => ['label' => 'Source'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>high → intermediate → very low</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
