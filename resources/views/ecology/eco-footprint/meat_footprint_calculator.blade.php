<x-calc.page
    title="Meat Footprint Calculator - SolveKit"
    description="Free meat footprint calculator: greenhouse gas, land and water footprint of the beef, lamb, pork, chicken, fish, cheese, eggs and milk you eat, from Poore & Nemecek."
    lede="Work out the carbon, land and water footprint of the meat and animal foods you eat."
    about="Footprints are the global median per kg of product from Poore & Nemecek (2018), the largest study of food life cycles, published by Our World in Data. Beef from beef herds is about 100 kg CO₂e per kg, chicken about 10 and eggs about 5. How a food is produced matters: the same food can vary several-fold between farms."
    :calc="['engine' => 'eco-footprint', 'tool' => 'meat', 'fields' => ['beef_beef_herd', 'beef_dairy_herd', 'lamb_mutton', 'pig_meat', 'poultry_meat', 'fish_farmed', 'prawns_farmed', 'cheese', 'eggs', 'milk'], 'data' => ['food' => config('ecology_data.food')]]"
    :how-to="[
        ['name' => 'Enter what you eat each week', 'text' => 'In grams (an egg is about 60 g).'],
    ]"
    :faqs="[
        ['question' => 'What is the footprint of beef?', 'answer' => 'About 99 kg CO₂e per kg from beef herds (median).'],
        ['question' => 'Is chicken better than beef?', 'answer' => 'Per kg, chicken has about a tenth of the greenhouse gas of beef from beef herds.'],
        ['question' => 'Why is dairy beef lower?', 'answer' => 'Part of the cow\'s footprint is assigned to the milk it produced.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="beef_beef_herd" label="Beef (beef herd)" value="300" min="0" suffix="g/week" />
        <x-calc.field name="beef_dairy_herd" label="Beef (dairy herd)" value="0" min="0" suffix="g/week" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lamb_mutton" label="Lamb and mutton" value="0" min="0" suffix="g/week" />
        <x-calc.field name="pig_meat" label="Pork" value="200" min="0" suffix="g/week" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="poultry_meat" label="Chicken and poultry" value="500" min="0" suffix="g/week" />
        <x-calc.field name="fish_farmed" label="Farmed fish" value="150" min="0" suffix="g/week" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="prawns_farmed" label="Farmed prawns" value="0" min="0" suffix="g/week" />
        <x-calc.field name="cheese" label="Cheese" value="200" min="0" suffix="g/week" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="eggs" label="Eggs" value="300" min="0" suffix="g/week" />
        <x-calc.field name="milk" label="Milk" value="2000" min="0" suffix="g/week" help="1 L of milk is about 1,030 g" />
    </div>

    <x-calc.result label="Footprint of these foods" />

    <x-calc.options :examples="[
        'Mixed diet' => ['beef_beef_herd' => 300, 'beef_dairy_herd' => 0, 'lamb_mutton' => 0, 'pig_meat' => 200, 'poultry_meat' => 500, 'fish_farmed' => 150, 'prawns_farmed' => 0, 'cheese' => 200, 'eggs' => 300, 'milk' => 2000],
        'Beef lover' => ['beef_beef_herd' => 1200, 'beef_dairy_herd' => 0, 'lamb_mutton' => 200, 'pig_meat' => 200, 'poultry_meat' => 200, 'fish_farmed' => 0, 'prawns_farmed' => 0, 'cheese' => 300, 'eggs' => 300, 'milk' => 2000],
        'Chicken and fish only' => ['beef_beef_herd' => 0, 'beef_dairy_herd' => 0, 'lamb_mutton' => 0, 'pig_meat' => 0, 'poultry_meat' => 700, 'fish_farmed' => 300, 'prawns_farmed' => 0, 'cheese' => 100, 'eggs' => 300, 'milk' => 1000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'land' => ['label' => 'Land'],
            'water' => ['label' => 'Fresh water'],
            'per_week' => ['label' => 'Per week'],
        ]" />
        <x-calc.quick-ref heading="By food" name="foods" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>footprint = Σ kg a year × footprint per kg</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
