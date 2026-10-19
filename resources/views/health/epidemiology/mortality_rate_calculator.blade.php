<x-calc.page
    title="Mortality Rate Calculator - SolveKit"
    description="Free mortality rate calculator: crude death rate, case fatality rate or age-adjusted death rate by direct standardisation to the US 2000 standard population."
    lede="Calculate a mortality rate."
    about="The crude death rate = deaths ÷ population × 100,000. The case fatality rate = deaths ÷ cases. Because older populations have more deaths, comparisons use age-adjusted rates: each age group's rate is weighted by the US 2000 standard population (as CDC and NCHS do) and the results added up. For information and education, not a diagnosis or medical advice."
    :calc="['engine' => 'hl-misc', 'tool' => 'mortality', 'fields' => ['mode', 'deaths', 'population', 'deaths', 'cases', 'groups', 'per']]"
    :how-to="[
        ['name' => 'Choose the rate', 'text' => ''],
        ['name' => 'Enter deaths and population', 'text' => 'Or each age group for age adjustment.'],
    ]"
    :faqs="[
        ['question' => 'What is the crude death rate for 850 deaths in 100,000 people?', 'answer' => '850.0 per 100,000.'],
        ['question' => 'And the age-adjusted rate for the sample age groups?', 'answer' => '2263.8 per 100,000 (Crude rate 2790.2 per 100,000).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Rate" :options="['crude' => 'Crude death rate', 'cfr' => 'Case fatality rate', 'adjusted' => 'Age-adjusted']" selected="crude" />

    <div data-show-when="mode:crude">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="deaths" label="Deaths" value="850" min="0" step="1" />
            <x-calc.field name="population" label="Population" value="100000" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:cfr" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="deaths" label="Deaths" value="850" min="0" step="1" />
            <x-calc.field name="cases" label="Cases" value="12000" min="0" step="1" />
        </div>
    </div>

    <div data-show-when="mode:adjusted" hidden>
        <x-calc.rows-editor name="groups" label="Deaths and population by age group" :columns="['group' => 'Age group', 'deaths' => 'Deaths', 'population' => 'Population']" :rows="[['Under 1', '20', '3800'], ['1–4', '5', '15000'], ['5–14', '8', '40000'], ['15–24', '40', '42000'], ['25–34', '60', '45000'], ['35–44', '110', '42000'], ['45–54', '280', '40000'], ['55–64', '600', '38000'], ['65–74', '1200', '30000'], ['75–84', '2600', '18000'], ['85 and over', '4000', '6000']]" add-label="Add group" :text="['group', 'deaths', 'population']" />
    </div>

    <x-calc.select name="per" label="Per" :options="['1000' => '1,000', '100000' => '100,000']" selected="100000" />

    <x-calc.result label="Death rate" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'crude', 'deaths' => 850, 'population' => 100000, 'cases' => 12000, 'per' => '100000', 'groups' => 'Under 1	20	3800
1–4	5	15000
5–14	8	40000
15–24	40	42000
25–34	60	45000
35–44	110	42000
45–54	280	40000
55–64	600	38000
65–74	1200	30000
75–84	2600	18000
85 and over	4000	6000'],
        'CFR' => ['mode' => 'cfr', 'deaths' => 850, 'population' => 100000, 'cases' => 12000, 'per' => '100000', 'groups' => 'Under 1	20	3800
1–4	5	15000
5–14	8	40000
15–24	40	42000
25–34	60	45000
35–44	110	42000
45–54	280	40000
55–64	600	38000
65–74	1200	30000
75–84	2600	18000
85 and over	4000	6000'],
        'Adjusted' => ['mode' => 'adjusted', 'deaths' => 850, 'population' => 100000, 'cases' => 12000, 'per' => '100000', 'groups' => 'Under 1	20	3800
1–4	5	15000
5–14	8	40000
15–24	40	42000
25–34	60	45000
35–44	110	42000
45–54	280	40000
55–64	600	38000
65–74	1200	30000
75–84	2600	18000
85 and over	4000	6000'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'crude' => ['label' => 'Crude rate'],
            'method' => ['label' => 'Method'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.grid heading="Age groups" name="groups" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>adjusted = Σ rateᵢ × standard weightᵢ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
