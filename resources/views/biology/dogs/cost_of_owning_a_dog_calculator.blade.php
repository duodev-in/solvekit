<x-calc.page
    title="Cost of Owning a Dog Calculator - SolveKit"
    description="Free cost of owning a dog calculator: monthly, yearly, first-year and lifetime cost from food, vet, insurance and other costs."
    lede="Add up what a dog costs per month, per year and over its life."
    about="Enter your own costs; the defaults are only example amounts and vary a lot by country, size and breed. Lifetime cost uses a typical lifespan for the size."
    :calc="['engine' => 'pets', 'tool' => 'dog_cost', 'fields' => ['size', 'food', 'treats', 'insurance', 'grooming', 'supplies', 'other', 'vet', 'boarding', 'setup']]"
    :how-to="[
        ['name' => 'Enter monthly costs', 'text' => 'Food, treats, insurance and so on.'],
        ['name' => 'Enter yearly costs', 'text' => 'Vet care and boarding.'],
        ['name' => 'Add setup', 'text' => 'One-off costs in the first year.'],
    ]"
    :faqs="[
        ['question' => 'How much does a dog cost a year?', 'answer' => 'Commonly $1,500 to $3,000 or more, depending on size and location.'],
        ['question' => 'What is the biggest cost?', 'answer' => 'Usually food and vet care; emergencies can add thousands.'],
        ['question' => 'Is pet insurance worth it?', 'answer' => 'It depends; it spreads the cost of unexpected illness.'],
    ]"
>
    <x-calc.select name="size" label="Size" :options="['small' => 'Small (under 20 lb)', 'medium' => 'Medium (21–50 lb)', 'large' => 'Large (51–100 lb)', 'giant' => 'Giant (over 100 lb)']" selected="medium" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="food" label="Food a month" value="50" min="0" suffix="$" />
        <x-calc.field name="treats" label="Treats a month" value="10" min="0" suffix="$" />
        <x-calc.field name="insurance" label="Insurance a month" value="40" min="0" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="grooming" label="Grooming a month" value="20" min="0" suffix="$" />
        <x-calc.field name="supplies" label="Toys and supplies a month" value="15" min="0" suffix="$" />
        <x-calc.field name="other" label="Other a month" value="0" min="0" suffix="$" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="vet" label="Vet care a year" value="500" min="0" suffix="$" />
        <x-calc.field name="boarding" label="Boarding a year" value="300" min="0" suffix="$" />
        <x-calc.field name="setup" label="One-off setup" value="600" min="0" suffix="$" help="Adoption, neutering, crate, bed" />
    </div>

    <x-calc.result label="Yearly cost" />

    <x-calc.options :examples="[
        'Medium dog (example)' => ['size' => 'medium', 'food' => 50, 'treats' => 10, 'insurance' => 40, 'grooming' => 20, 'supplies' => 15, 'other' => 0, 'vet' => 500, 'boarding' => 300, 'setup' => 600],
        'Giant dog (example)' => ['size' => 'giant', 'food' => 120, 'treats' => 15, 'insurance' => 80, 'grooming' => 40, 'supplies' => 25, 'other' => 0, 'vet' => 900, 'boarding' => 500, 'setup' => 900],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'month' => ['label' => 'Per month'],
            'first' => ['label' => 'First year'],
            'lifetime' => ['label' => 'Lifetime'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>yearly = 12 × monthly costs + yearly costs</li>
            <li>lifetime = first year + yearly × (lifespan − 1)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
