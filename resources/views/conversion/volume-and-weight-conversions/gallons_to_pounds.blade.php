<x-tool-page-layout
    title="Gallons to Pounds Converter - SolveKit"
    description="Professional gallons to pounds converter for liquids. Convert gallon volume to weight in pounds based on substance density. Perfect for cooking and industry."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Gallons to Pounds</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Substance Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="substance" class="block text-sm font-semibold text-slate-700">
                                                                                    Select Substance
                                                                                </label>
                                                                                <select 
                                                                                    id="substance" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">Select substance</option>
                                                                                    <option value="Water" selected>Water</option>
                                                                                    <option value="Milk">Milk</option>
                                                                                    <option value="Cooking oil">Cooking oil</option>
                                                                                    <option value="Diesel">Diesel fuel</option>
                                                                                    <option value="Gasoline">Gasoline</option>
                                                                                    <option value="Honey">Honey</option>
                                                                                    <option value="Mercury">Mercury</option>
                                                                                    <option value="Ethanol">Ethanol (Alcohol)</option>
                                                                                    <option value="Propane">Propane (liquid)</option>
                                                                                    <option value="Kerosene">Kerosene</option>
                                                                                    <option value="Custom">Custom substance</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Density Field -->
                                                                            <div class="space-y-2" id="customDensityContainer" style="display: none;">
                                                                                <label for="customDensity" class="block text-sm font-semibold text-slate-700">
                                                                                    Custom Density
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customDensity" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter density"
                                                                                        step="0.01"
                                                                                        min="0.1"
                                                                                        max="20"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">lb/US gal</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Enter pounds per US gallon</p>
                                                                            </div>

                                                                            <!-- Density Display -->
                                                                            <div class="space-y-2">
                                                                                <label for="densityDisplay" class="block text-sm font-semibold text-slate-700">
                                                                                    Substance Density
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="text" 
                                                                                        id="densityDisplay" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50 text-lg font-medium" 
                                                                                        placeholder="Select substance first"
                                                                                        readonly
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">lb/US gal</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Volume Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="gallons" class="block text-sm font-semibold text-slate-700">
                                                                                    Volume
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="gallons" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter volume (e.g., 10)"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">US gallons</span>
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

                                                                            <!-- Primary Result - Pounds -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Weight in Pounds</h4>
                                                                                        <p class="text-[11px] text-slate-500">Total weight of liquid</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="pounds">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">lb</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Weight Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kilograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="kgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Ounces</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="ozOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Metric Tons</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="tonnesOutput">--</div>
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
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Common Liquid Densities</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• Water: 8.34 lb/gal</div>
                                                        <div>• Gasoline: 6.07 lb/gal</div>
                                                        <div>• Milk: 8.6 lb/gal</div>
                                                        <div>• Cooking oil: 7.68 lb/gal</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Gallon to Pound Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Density Matters</h4>
                                    <p>The weight of a gallon depends entirely on the substance's density. Water weighs about 8.34 pounds per gallon, while gasoline weighs only about 6.07 pounds per gallon.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Essential for fuel calculations, chemical mixing, shipping weights, cooking measurements, and any application where liquid volume needs to be converted to weight.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Temperature Note:</strong> Liquid density can vary with temperature. These calculations assume standard room temperature conditions!
                                </p>
                            </div>
                        </div>

                        <!-- Common Volume Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Liquid Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water Gallon</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="Water" data-volume="1">1 gal</div>
                                    <div class="text-[11px] text-slate-500">~8.34 pounds</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Gas Tank</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="Gasoline" data-volume="15">15 gal</div>
                                    <div class="text-[11px] text-slate-500">~91 pounds</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Cooking Oil</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="Cooking oil" data-volume="0.5">0.5 gal</div>
                                    <div class="text-[11px] text-slate-500">~3.84 pounds</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Milk Jug</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-substance="Milk" data-volume="1">1 gal</div>
                                    <div class="text-[11px] text-slate-500">~8.6 pounds</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const substanceSelect = document.getElementById('substance');
                        const customDensityContainer = document.getElementById('customDensityContainer');
                        const customDensity = document.getElementById('customDensity');
                        const densityDisplay = document.getElementById('densityDisplay');
                        const gallonsInput = document.getElementById('gallons');
                        const clearButton = document.getElementById('clearButton');
                        const poundsOutput = document.getElementById('pounds');
                        const kgOutput = document.getElementById('kgOutput');
                        const ozOutput = document.getElementById('ozOutput');
                        const tonnesOutput = document.getElementById('tonnesOutput');

                        // Density in pounds per US gallon
                        const densities = {
                            "Water": 8.34,
                            "Milk": 8.6,
                            "Cooking oil": 7.68,
                            "Diesel": 7.14,
                            "Gasoline": 6.07,
                            "Honey": 11.42,
                            "Mercury": 112.0,
                            "Ethanol": 6.58,
                            "Propane": 4.24,
                            "Kerosene": 6.8
                        };

                        function formatNumber(num) {
                            if (num >= 1000000 || (num !== 0 && Math.abs(num) < 0.000001)) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }
                        }

                        function convert() {
                            const gal = parseFloat(gallonsInput.value);
                            let density;
                            
                            if (substanceSelect.value === 'Custom') {
                                density = parseFloat(customDensity.value);
                            } else {
                                density = densities[substanceSelect.value];
                            }

                            if (!isNaN(gal) && !isNaN(density) && gal >= 0 && density > 0) {
                                const pounds = gal * density;
                                const kg = pounds * 0.453592;
                                const oz = pounds * 16;
                                const tonnes = kg / 1000;

                                poundsOutput.textContent = formatNumber(pounds);
                                kgOutput.textContent = formatNumber(kg) + ' kg';
                                ozOutput.textContent = formatNumber(oz) + ' oz';
                                tonnesOutput.textContent = formatNumber(tonnes) + ' t';
                            } else {
                                poundsOutput.textContent = '--';
                                kgOutput.textContent = '--';
                                ozOutput.textContent = '--';
                                tonnesOutput.textContent = '--';
                            }
                        }

                        function updateDensityDisplay() {
                            const substance = substanceSelect.value;
                            
                            if (substance === 'Custom') {
                                customDensityContainer.style.display = 'block';
                                densityDisplay.value = customDensity.value || '';
                            } else if (substance && densities[substance]) {
                                customDensityContainer.style.display = 'none';
                                densityDisplay.value = densities[substance];
                                customDensity.value = '';
                            } else {
                                customDensityContainer.style.display = 'none';
                                densityDisplay.value = '';
                                customDensity.value = '';
                            }
                            convert();
                        }

                        function clearAll() {
                            gallonsInput.value = '';
                            customDensity.value = '';
                            substanceSelect.value = 'Water';
                            updateDensityDisplay();
                            gallonsInput.focus();
                        }

                        // Event listeners
                        substanceSelect.addEventListener('change', updateDensityDisplay);
                        customDensity.addEventListener('input', () => {
                            densityDisplay.value = customDensity.value;
                            convert();
                        });
                        gallonsInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to example liquids
                        const exampleLiquids = document.querySelectorAll('[data-substance]');
                        exampleLiquids.forEach(element => {
                            element.addEventListener('click', function() {
                                const substance = this.getAttribute('data-substance');
                                const volume = this.getAttribute('data-volume');
                                
                                substanceSelect.value = substance;
                                gallonsInput.value = volume;
                                updateDensityDisplay();
                                gallonsInput.focus();
                            });
                        });

                        // Initialize
                        gallonsInput.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            }
                        });

                        // Initialize density for the default substance and run the conversion
                        updateDensityDisplay();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
