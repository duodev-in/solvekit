<x-calc.page
    title="Sperm Analysis Calculator - SolveKit"
    description="Free semen analysis calculator: total and motile sperm counts from volume, concentration and motility, compared with the WHO 2021 lower reference limits."
    lede="Check a semen analysis against WHO limits."
    about="The WHO laboratory manual (6th edition, 2021) gives fifth-centile values from men whose partners conceived within a year: volume 1.4 mL, concentration 16 million/mL, total 39 million, total motility 42%, progressive motility 30%, normal forms 4% and vitality 54%. Results below them are not proof of infertility, and semen quality varies between samples, so tests are usually repeated. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-pregnancy', 'tool' => 'sperm', 'fields' => ['volume', 'concentration', 'motility', 'progressive', 'morphology', 'vitality']]"
    :how-to="[
        ['name' => 'Enter the results from the report', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'What is the total motile count for 3 mL, 40 million/mL and 55% motility?', 'answer' => '66.0 million: At or above every WHO 2021 lower reference limit entered.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="volume" label="Volume" value="3" min="0" step="any" suffix="mL" />
        <x-calc.field name="concentration" label="Concentration" value="40" min="0" step="any" suffix="million/mL" />
        <x-calc.field name="motility" label="Total motility" value="55" min="0" max="100" step="any" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="progressive" label="Progressive motility" value="40" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="morphology" label="Normal forms" value="5" min="0" max="100" step="any" suffix="%" />
        <x-calc.field name="vitality" label="Vitality (optional)" value="70" min="0" max="100" step="any" suffix="%" />
    </div>

    <x-calc.result label="Total motile sperm count" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['volume' => 3, 'concentration' => 40, 'motility' => 55, 'progressive' => 40, 'morphology' => 5, 'vitality' => 70],
        'Low' => ['volume' => 1.2, 'concentration' => 10, 'motility' => 35, 'progressive' => 20, 'morphology' => 3, 'vitality' => 60],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'total' => ['label' => 'Total sperm number'],
            'progressive' => ['label' => 'Progressively motile'],
            'note' => ['label' => 'Note'],
            'source' => ['label' => 'Source'],
        ]" />
        <x-calc.grid heading="WHO limits" name="limits" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>TMSC = volume × concentration × motility</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
