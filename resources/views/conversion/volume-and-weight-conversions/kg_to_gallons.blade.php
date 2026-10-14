<x-tool-page-layout
    title="Kg to Gallons Converter (Advanced) - SolveKit"
    description="Advanced kg to gallons converter for various substances. Convert weight to volume based on density for liquids, dairy, oils, and cooking ingredients."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Kg to Gallons</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Category Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Select Category
                                                                                </label>
                                                                                <select 
                                                                                    id="category" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option selected disabled>Select category</option>
                                                                                    <option>Liquids</option>
                                                                                    <option>Dairy</option>
                                                                                    <option>Oils</option>
                                                                                    <option>Fruits & vegetables</option>
                                                                                    <option>Flour</option>
                                                                                    <option>Sweeteners</option>
                                                                                    <option>Cereals</option>
                                                                                    <option>Nuts</option>
                                                                                    <option>Sauces and condiments</option>
                                                                                    <option>Herbs and spices</option>
                                                                                    <option>Others</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Item Selection -->
                                                                            <div class="space-y-2" id="itemField" style="display: none;">
                                                                                <label for="item" class="block text-sm font-semibold text-slate-700">
                                                                                    Select Item
                                                                                </label>
                                                                                <select 
                                                                                    id="item" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    disabled
                                                                                >
                                                                                    <option>Select a category first</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Density Display -->
                                                                            <div class="space-y-2" id="densityField" style="display: none;">
                                                                                <label for="densityDisplay" class="block text-sm font-semibold text-slate-700">
                                                                                    Item Density
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="text" 
                                                                                        id="densityDisplay" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50 text-lg font-medium" 
                                                                                        placeholder="Select item first"
                                                                                        readonly
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">g/cm³</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Weight Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="kg" class="block text-sm font-semibold text-slate-700">
                                                                                    Weight
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="kg" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter weight (e.g., 100)"
                                                                                        step="0.1"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">kg</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result - US Gallons -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Volume (US Gallons)</h4>
                                                                                        <p class="text-[11px] text-slate-500">Calculated volume</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">gal</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Volume Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Liters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="litersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Quarts</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="quartsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Pints</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="pintsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Density Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• Water: 1.0 g/cm³</div>
                                                        <div>• Milk: 1.03 g/cm³</div>
                                                        <div>• Oil: 0.92 g/cm³</div>
                                                        <div>• Honey: 1.42 g/cm³</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Weight to Volume Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Density-Based Conversion</h4>
                                    <p>Converting weight to volume requires knowing the substance's density. Different materials have different densities, so the same weight can occupy very different volumes.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Cooking Applications</h4>
                                    <p>Essential for recipe conversions, ingredient substitutions, and scaling recipes up or down when measurements are given in different units.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Cooking Tip:</strong> Densities can vary with temperature and composition. For best results, use ingredients at room temperature!
                                </p>
                            </div>
                        </div>

                        <!-- Common Ingredient Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Cooking Conversions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="Liquids" data-item="Water" data-weight="1">1 kg</div>
                                    <div class="text-[11px] text-slate-500">~0.26 gallons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Milk</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="Dairy" data-item="Milk" data-weight="2">2 kg</div>
                                    <div class="text-[11px] text-slate-500">~0.51 gallons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Honey</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="Sweeteners" data-item="Honey" data-weight="1">1 kg</div>
                                    <div class="text-[11px] text-slate-500">~0.19 gallons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Olive Oil</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-category="Oils" data-item="Olive oil" data-weight="0.5">0.5 kg</div>
                                    <div class="text-[11px] text-slate-500">~0.14 gallons</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const categorySelect = document.getElementById('category');
                        const itemSelect = document.getElementById('item');
                        const itemField = document.getElementById('itemField');
                        const densityField = document.getElementById('densityField');
                        const densityDisplay = document.getElementById('densityDisplay');
                        const kgInput = document.getElementById('kg');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const litersOutput = document.getElementById('litersOutput');
                        const quartsOutput = document.getElementById('quartsOutput');
                        const pintsOutput = document.getElementById('pintsOutput');

                        // Densities in g/cm³ (which equals kg/L)
                        const densities = {
                            "Liquids": { 
                                "Water": 1.0, 
                                "Grape soda": 1.03, 
                                "Juice": 1.04,
                                "Coffee": 1.0,
                                "Tea": 1.0 
                            },
                            "Dairy": { 
                                "Milk": 1.03, 
                                "Cream": 0.97, 
                                "Yogurt": 1.05,
                                "Buttermilk": 1.03,
                                "Heavy cream": 0.99 
                            },
                            "Oils": { 
                                "Olive oil": 0.91, 
                                "Vegetable oil": 0.92, 
                                "Coconut oil": 0.925,
                                "Canola oil": 0.915,
                                "Sunflower oil": 0.920 
                            },
                            "Fruits & vegetables": { 
                                "Tomato puree": 1.05, 
                                "Apple sauce": 1.1, 
                                "Pumpkin puree": 1.05,
                                "Orange juice": 1.04,
                                "Lemon juice": 1.03 
                            },
                            "Flour": { 
                                "All-purpose flour": 0.55, 
                                "Whole-wheat flour": 0.59,
                                "Bread flour": 0.56,
                                "Cake flour": 0.53,
                                "Self-rising flour": 0.55 
                            },
                            "Sweeteners": { 
                                "Honey": 1.42, 
                                "Maple syrup": 1.37, 
                                "Molasses": 1.45,
                                "Corn syrup": 1.36,
                                "Agave nectar": 1.35 
                            },
                            "Cereals": { 
                                "Rice": 0.85, 
                                "Oats": 0.39,
                                "Quinoa": 0.84,
                                "Barley": 0.78,
                                "Wheat": 0.82 
                            },
                            "Nuts": { 
                                "Peanut butter": 1.09, 
                                "Almond butter": 0.96,
                                "Tahini": 1.0,
                                "Cashew butter": 0.98,
                                "Sunflower seed butter": 1.02 
                            },
                            "Sauces and condiments": { 
                                "Ketchup": 1.17, 
                                "Mayonnaise": 0.94, 
                                "Soy sauce": 1.24,
                                "Vinegar": 1.01,
                                "Hot sauce": 1.05 
                            },
                            "Herbs and spices": { 
                                "Olive paste": 1.1, 
                                "Mustard": 1.02,
                                "Garlic paste": 1.08,
                                "Ginger paste": 1.05,
                                "Vanilla extract": 0.94 
                            },
                            "Others": { 
                                "Sugar": 0.85, 
                                "Salt": 1.2,
                                "Baking powder": 0.9,
                                "Cocoa powder": 0.48,
                                "Powdered sugar": 0.56 
                            }
                        };

                        function formatNumber(num) {
                            if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }
                        }

                        function convert() {
                            const category = categorySelect.value;
                            const item = itemSelect.value;
                            const kg = parseFloat(kgInput.value);
                            
                            if (densities[category] && densities[category][item] && !isNaN(kg) && kg > 0) {
                                // Get density in kg/L
                                const density = densities[category][item];
                                
                                // Calculate volume in liters
                                const liters = kg / density;
                                
                                // Convert to US gallons
                                const gallons = liters * 0.264172;
                                
                                // Additional conversions
                                const quarts = gallons * 4;
                                const pints = gallons * 8;

                                output.textContent = formatNumber(gallons);
                                litersOutput.textContent = formatNumber(liters) + ' L';
                                quartsOutput.textContent = formatNumber(quarts) + ' qt';
                                pintsOutput.textContent = formatNumber(pints) + ' pt';
                            } else {
                                output.textContent = '--';
                                litersOutput.textContent = '--';
                                quartsOutput.textContent = '--';
                                pintsOutput.textContent = '--';
                            }
                        }

                        function populateItems(category) {
                            const items = densities[category];
                            itemSelect.innerHTML = '<option disabled selected>Select item</option>';
                            
                            if (items) {
                                Object.keys(items).forEach(item => {
                                    itemSelect.innerHTML += `<option value="${item}">${item}</option>`;
                                });
                                itemSelect.disabled = false;
                                itemField.style.display = 'block';
                            } else {
                                itemSelect.disabled = true;
                                itemField.style.display = 'none';
                            }
                            
                            densityField.style.display = 'none';
                            densityDisplay.value = '';
                            convert();
                        }

                        function updateDensity() {
                            const category = categorySelect.value;
                            const item = itemSelect.value;
                            
                            if (densities[category] && densities[category][item]) {
                                densityDisplay.value = densities[category][item];
                                densityField.style.display = 'block';
                            } else {
                                densityDisplay.value = '';
                                densityField.style.display = 'none';
                            }
                            convert();
                        }

                        function selectDefaultIngredient() {
                            categorySelect.value = 'Liquids';
                            populateItems('Liquids');
                            itemSelect.value = 'Water';
                            updateDensity();
                        }

                        function clearAll() {
                            kgInput.value = '';
                            selectDefaultIngredient();
                            kgInput.focus();
                        }

                        // Event listeners
                        categorySelect.addEventListener('change', () => {
                            populateItems(categorySelect.value);
                        });

                        itemSelect.addEventListener('change', updateDensity);
                        kgInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to example ingredients
                        const exampleIngredients = document.querySelectorAll('[data-category]');
                        exampleIngredients.forEach(element => {
                            element.addEventListener('click', function() {
                                const category = this.getAttribute('data-category');
                                const item = this.getAttribute('data-item');
                                const weight = this.getAttribute('data-weight');
                                
                                categorySelect.value = category;
                                populateItems(category);
                                
                                // Small delay to ensure options are populated
                                setTimeout(() => {
                                    itemSelect.value = item;
                                    updateDensity();
                                    kgInput.value = weight;
                                    convert();
                                }, 50);
                                
                                kgInput.focus();
                            });
                        });

                        // Initialize
                        kgInput.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            }
                        });

                        // Default to water so results appear immediately
                        selectDefaultIngredient();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
