<x-tool-page-layout
    title="Nickels to Dollars Calculator - SolveKit"
    description="Professional nickels to dollars calculator for coin conversion. Convert nickel quantities to dollar amounts with detailed breakdown for counting and financial calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Nickels to Dollars Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Nickels Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="nickelsValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Number of Nickels
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="nickelsValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter number of nickels (e.g., 40)"
                                                                                        step="1"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">nickels</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter the total number of nickels to convert</p>
                                                                            </div>

                                                                            <!-- Nickel Type -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Nickel Type
                                                                                </label>
                                                                                <select 
                                                                                    id="nickelType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="jefferson_nickel" selected>Jefferson Nickel (1938-present)</option>
                                                                                    <option value="buffalo_nickel">Buffalo Nickel (1913-1938)</option>
                                                                                    <option value="liberty_head_nickel">Liberty Head Nickel (1883-1913)</option>
                                                                                    <option value="shield_nickel">Shield Nickel (1866-1883)</option>
                                                                                    <option value="wartime_nickel">Wartime Nickel (1942-1945)</option>
                                                                                    <option value="canadian_nickel">Canadian Nickel</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Value Type -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Value Type
                                                                                </label>
                                                                                <select 
                                                                                    id="valueType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="face_value" selected>Face Value (5 cents each)</option>
                                                                                    <option value="collector_value">Collector/Numismatic Value</option>
                                                                                    <option value="melt_value">Metal Melt Value</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Metal Prices (for melt value) -->
                                                                            <div class="space-y-2" id="metalPricesContainer" style="display: none;">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Metal Prices
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-4">
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="nickelPrice" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                            placeholder="Nickel price"
                                                                                            step="0.01"
                                                                                            min="0"
                                                                                            value="8.50"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-xs">$/lb Ni</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="silverPrice" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                            placeholder="Silver price"
                                                                                            step="0.01"
                                                                                            min="0"
                                                                                            value="24.50"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-xs">$/oz Ag</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Current metal prices (nickel per pound, silver per troy ounce)</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Nickel Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Total Value in Dollars</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter a number of nickels to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-purple-600 hover:text-purple-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Value Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Face Value -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Face Value</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Dollars</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="dollarsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">USD amount</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cents</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="centsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Cent amount</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Per Nickel</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="perNickelDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Value each</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Physical Properties -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Physical Properties</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Total Weight</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="totalWeightDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Grams</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Metal Content</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="metalContentDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Composition</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Era</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="eraDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Time period</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Equivalent Coins -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Equivalent Coins</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Pennies</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="penniesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1¢ coins</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Dimes</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="dimesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">10¢ coins</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg border-l-4 border-rose-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Quarters</h5>
                                                                                            <div class="text-lg font-bold text-rose-600 font-mono" id="quartersDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">25¢ coins</div>
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
                <!-- Quick Nickel Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Nickel Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-nickels="20">20 nickels</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-nickels="40">40 nickels</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-nickels="80">80 nickels</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-nickels="200">200 nickels</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Nickel Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Nickel</strong> = 5 cents</div>
                                                        <div><strong>20 Nickels</strong> = $1.00</div>
                                                        <div><strong>Weight</strong> = 5.000g</div>
                                                        <div><strong>Diameter</strong> = 21.21mm</div>
                                                        <div><strong>Jefferson Nickel</strong> = 1938-present</div>
                                                        <div><strong>Buffalo Nickel</strong> = 1913-1938</div>
                                                        <div><strong>Composition</strong> = 75% Cu, 25% Ni</div>
                                                        <div><strong>Wartime Nickel</strong> = 35% Ag</div>
                                                        <div><strong>Shield Nickel</strong> = 1866-1883</div>
                                                        <div><strong>Liberty Head</strong> = 1883-1913</div>
                                                        <div><strong>Edge</strong> = Plain</div>
                                                        <div><strong>Roll Count</strong> = 40 nickels</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const nickelsValue = document.getElementById('nickelsValue');
                        const nickelType = document.getElementById('nickelType');
                        const valueType = document.getElementById('valueType');
                        const nickelPrice = document.getElementById('nickelPrice');
                        const silverPrice = document.getElementById('silverPrice');
                        const metalPricesContainer = document.getElementById('metalPricesContainer');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const dollarsDisplay = document.getElementById('dollarsDisplay');
                        const centsDisplay = document.getElementById('centsDisplay');
                        const perNickelDisplay = document.getElementById('perNickelDisplay');
                        const totalWeightDisplay = document.getElementById('totalWeightDisplay');
                        const metalContentDisplay = document.getElementById('metalContentDisplay');
                        const eraDisplay = document.getElementById('eraDisplay');
                        const penniesDisplay = document.getElementById('penniesDisplay');
                        const dimesDisplay = document.getElementById('dimesDisplay');
                        const quartersDisplay = document.getElementById('quartersDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Nickel specifications
                        const nickelSpecs = {
                            jefferson_nickel: {
                                weight: 5.000, // grams
                                diameter: '21.21mm',
                                thickness: '1.95mm',
                                composition: '75% Cu, 25% Ni',
                                era: '1938-present',
                                designer: 'Felix Schlag',
                                silverContent: 0,
                                nickelContent: 0.25, // 25%
                                collectorMultiplier: 1.0
                            },
                            buffalo_nickel: {
                                weight: 5.000,
                                diameter: '21.21mm',
                                thickness: '1.95mm',
                                composition: '75% Cu, 25% Ni',
                                era: '1913-1938',
                                designer: 'James Fraser',
                                silverContent: 0,
                                nickelContent: 0.25,
                                collectorMultiplier: 2.5
                            },
                            liberty_head_nickel: {
                                weight: 5.000,
                                diameter: '21.21mm',
                                thickness: '1.95mm',
                                composition: '75% Cu, 25% Ni',
                                era: '1883-1913',
                                designer: 'Charles Barber',
                                silverContent: 0,
                                nickelContent: 0.25,
                                collectorMultiplier: 5.0
                            },
                            shield_nickel: {
                                weight: 5.000,
                                diameter: '20.5mm',
                                thickness: '1.95mm',
                                composition: '75% Cu, 25% Ni',
                                era: '1866-1883',
                                designer: 'James Longacre',
                                silverContent: 0,
                                nickelContent: 0.25,
                                collectorMultiplier: 8.0
                            },
                            wartime_nickel: {
                                weight: 5.000,
                                diameter: '21.21mm',
                                thickness: '1.95mm',
                                composition: '56% Cu, 35% Ag, 9% Mn',
                                era: '1942-1945',
                                designer: 'Felix Schlag',
                                silverContent: 0.05626, // troy oz of silver
                                nickelContent: 0,
                                collectorMultiplier: 1.5
                            },
                            canadian_nickel: {
                                weight: 3.95,
                                diameter: '21.2mm',
                                thickness: '1.76mm',
                                composition: 'Ni-plated steel',
                                era: '1922-present',
                                designer: 'Various',
                                silverContent: 0,
                                nickelContent: 0.045, // plating
                                collectorMultiplier: 1.0
                            }
                        };

                        function formatNumber(num, decimals = 2) {
                            return num.toLocaleString('en-US', { 
                                maximumFractionDigits: decimals, 
                                minimumFractionDigits: decimals 
                            });
                        }

                        function updateMetalPricesVisibility() {
                            const type = valueType.value;
                            metalPricesContainer.style.display = type === 'melt_value' ? 'block' : 'none';
                        }

                        function calculate() {
                            const nickels = parseInt(nickelsValue.value, 10);
                            const type = nickelType.value;
                            const valType = valueType.value;
                            const currentNickelPrice = parseFloat(nickelPrice.value) || 8.50;
                            const currentSilverPrice = parseFloat(silverPrice.value) || 24.50;
                            
                            if (!Number.isNaN(nickels) && nickels >= 0) {
                                const specs = nickelSpecs[type];
                                const faceValue = nickels * 0.05; // 5 cents per nickel
                                let totalValue = faceValue;
                                let perNickelValue = 0.05;

                                // Calculate value based on type
                                if (valType === 'collector_value') {
                                    totalValue = nickels * 0.05 * specs.collectorMultiplier;
                                    perNickelValue = 0.05 * specs.collectorMultiplier;
                                } else if (valType === 'melt_value') {
                                    // Calculate melt value based on metal content
                                    let meltValuePerNickel = 0;
                                    
                                    if (specs.silverContent > 0) {
                                        // Wartime nickels with silver
                                        meltValuePerNickel = specs.silverContent * currentSilverPrice;
                                    } else if (specs.nickelContent > 0) {
                                        // Regular nickels with nickel content
                                        const nickelWeightLbs = (specs.weight * specs.nickelContent) / 453.592; // grams to pounds
                                        meltValuePerNickel = nickelWeightLbs * currentNickelPrice;
                                    }
                                    
                                    totalValue = nickels * Math.max(meltValuePerNickel, 0.05); // Never less than face value
                                    perNickelValue = Math.max(meltValuePerNickel, 0.05);
                                }

                                // Update primary output
                                output.textContent = '$' + formatNumber(totalValue);
                                resultTitle.textContent = valType === 'face_value' ? 'Face Value in Dollars' : 
                                                        valType === 'collector_value' ? 'Collector Value in Dollars' : 'Melt Value in Dollars';
                                resultDescription.textContent = `${nickels.toLocaleString('en-US')} ${nickels === 1 ? 'nickel' : 'nickels'} = $${formatNumber(totalValue)}`;

                                // Display breakdowns
                                dollarsDisplay.textContent = '$' + formatNumber(totalValue);
                                centsDisplay.textContent = Math.round(totalValue * 100) + '¢';
                                perNickelDisplay.textContent = '$' + formatNumber(perNickelValue, 3);

                                // Physical properties
                                const totalWeight = nickels * specs.weight;
                                totalWeightDisplay.textContent = formatNumber(totalWeight, 1) + 'g';
                                metalContentDisplay.textContent = specs.composition;
                                eraDisplay.textContent = specs.era;

                                // Equivalent coins
                                penniesDisplay.textContent = nickels * 5; // 5 pennies per nickel
                                dimesDisplay.textContent = formatNumber(nickels / 2, 1); // 2 nickels per dime
                                quartersDisplay.textContent = formatNumber(nickels / 5, 1); // 5 nickels per quarter

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Total Value in Dollars';
                            resultDescription.textContent = 'Enter a number of nickels to convert';
                            dollarsDisplay.textContent = '--';
                            centsDisplay.textContent = '--';
                            perNickelDisplay.textContent = '--';
                            totalWeightDisplay.textContent = '--';
                            metalContentDisplay.textContent = '--';
                            eraDisplay.textContent = '--';
                            penniesDisplay.textContent = '--';
                            dimesDisplay.textContent = '--';
                            quartersDisplay.textContent = '--';
                        }

                        function clearAll() {
                            nickelsValue.value = '';
                            nickelType.value = 'jefferson_nickel';
                            valueType.value = 'face_value';
                            nickelPrice.value = '8.50';
                            silverPrice.value = '24.50';
                            updateMetalPricesVisibility();
                            clearOutputs();
                            nickelsValue.focus();
                        }

                        // Event listeners
                        nickelsValue.addEventListener('input', calculate);
                        nickelType.addEventListener('change', calculate);
                        valueType.addEventListener('change', function() {
                            updateMetalPricesVisibility();
                            calculate();
                        });
                        nickelPrice.addEventListener('input', calculate);
                        silverPrice.addEventListener('input', calculate);

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const nickels = this.getAttribute('data-nickels');
                                
                                nickelsValue.value = nickels;
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-nickels]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const nickels = this.getAttribute('data-nickels');
                                
                                if (nickels) {
                                    nickelsValue.value = nickels;
                                    calculate();
                                    nickelsValue.focus();
                                }
                            });
                        });

                        // Initialize
                        updateMetalPricesVisibility();
                        nickelsValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
