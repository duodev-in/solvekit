<x-calc.page
    title="Garlic Clove to Powder Converter & More - SolveKit"
    description="Free garlic converter: cloves to minced garlic, jarred garlic, garlic powder, granulated garlic and garlic salt, and back."
    lede="Convert garlic cloves to powder, minced and more."
    about="One medium clove (about 3 g, USDA) gives about 1 teaspoon minced fresh garlic and is usually replaced by ½ teaspoon jarred minced garlic, ¼ teaspoon granulated garlic or ⅛ teaspoon garlic powder (spice makers' guidance). Garlic salt is about three parts salt to one part garlic powder, so ½ teaspoon holds ⅛ teaspoon of garlic and ⅜ teaspoon of salt. These are kitchen conventions; adjust to taste."
    :calc="['engine' => 'fd-convert', 'tool' => 'garlic', 'fields' => ['amount', 'from']]"
    :how-to="[
        ['name' => 'Enter the amount', 'text' => ''],
        ['name' => 'Choose the form you have or the recipe gives', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How much garlic powder equals 2 cloves?', 'answer' => '¼ tsp.'],
        ['question' => 'How many cloves is 1 teaspoon of garlic powder?', 'answer' => '8 cloves cloves.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="amount" label="Amount" value="2" min="0" step="any" />
        <x-calc.select name="from" label="Form" :options="['clove' => 'Cloves (medium)', 'minced' => 'Teaspoons minced fresh', 'jarred' => 'Teaspoons jarred minced', 'granulated' => 'Teaspoons granulated', 'powder' => 'Teaspoons garlic powder', 'salt' => 'Teaspoons garlic salt']" selected="clove" />
    </div>

    <x-calc.result label="Fresh garlic" />

    <x-calc.options :decimals="false" :examples="[
        '2 cloves' => ['amount' => 2, 'from' => 'clove'],
        '1 tsp powder' => ['amount' => 1, 'from' => 'powder'],
        '1 tbsp jarred' => ['amount' => 3, 'from' => 'jarred'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'minced' => ['label' => 'Minced fresh'],
            'jarred' => ['label' => 'Jarred minced'],
            'granulated' => ['label' => 'Granulated'],
            'powder' => ['label' => 'Garlic powder'],
            'salt' => ['label' => 'Garlic salt'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>1 clove = 1 tsp minced = ½ tsp jarred = ¼ tsp granulated = ⅛ tsp powder</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
