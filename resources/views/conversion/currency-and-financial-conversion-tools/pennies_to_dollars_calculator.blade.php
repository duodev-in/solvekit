<x-tool-page-layout
    title="Pennies to Dollars Calculator - SolveKit"
    description="Professional pennies to dollars calculator for coin conversion. Convert penny quantities to dollar amounts with detailed breakdown for counting and financial calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Pennies to Dollars Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Pennies Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="penniesValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Number of Pennies
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="penniesValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter number of pennies (e.g., 150)"
                                                                                        step="1"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">pennies</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter the total number of pennies to convert</p>
                                                                            </div>

                                                                            <!-- Penny Type -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Penny Type
                                                                                </label>
                                                                                <select 
                                                                                    id="pennyType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="lincoln_cent" selected>Lincoln Cent (1909-present)</option>
                                                                                    <option value="wheat_penny">Wheat Penny (1909-1958)</option>
                                                                                    <option value="indian_head_penny">Indian Head Penny (1859-1909)</option>
                                                                                    <option value="flying_eagle_cent">Flying Eagle Cent (1856-1858)</option>
                                                                                    <option value="large_cent">Large Cent (1793-1857)</option>
                                                                                    <option value="steel_penny">Steel Penny (1943)</option>
                                                                                    <option value="canadian_penny">Canadian Penny (1858-2013)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Value Assessment -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Value Assessment
                                                                                </label>
                                                                                <select 
                                                                                    id="valueAssessment" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="face_value" selected>Face Value (1 cent each)</option>
                                                                                    <option value="collector_value">Collector/Numismatic Value</option>
                                                                                    <option value="metal_value">Metal/Melt Value</option>
                                                                                    <option value="average_condition">Average Circulated Condition</option>
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
                                                                                            id="copperPrice" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                            placeholder="Copper price"
                                                                                            step="0.01"
                                                                                            min="0"
                                                                                            value="4.20"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-xs">$/lb Cu</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="relative">
                                                                                        <input 
                                                                                            type="number" 
                                                                                            id="zincPrice" 
                                                                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                            placeholder="Zinc price"
                                                                                            step="0.01"
                                                                                            min="0"
                                                                                            value="1.25"
                                                                                        >
                                                                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                            <span class="text-gray-500 text-xs">$/lb Zn</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Current metal prices per pound</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Penny Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl border-l-4 border-yellow-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Total Value in Dollars</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter a number of pennies to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-yellow-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-yellow-600 hover:text-yellow-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Value Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Face Value -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Monetary Value</h4>

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
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="totalCentsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Cent amount</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Per Penny</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="perPennyDisplay">--</div>
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
                                                                                            <div class="text-xs text-gray-500 mt-1">Grams / Pounds</div>
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

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Nickels</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="nickelsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">5¢ coins</div>
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
                <!-- Quick Penny Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Penny Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-pennies="100">100 pennies</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-pennies="250">250 pennies</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-pennies="500">500 pennies</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-yellow-100 text-gray-700 hover:text-yellow-700 rounded-lg transition-colors" data-pennies="1000">1000 pennies</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Penny Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Penny</strong> = 1 cent</div>
                                                        <div><strong>100 Pennies</strong> = $1.00</div>
                                                        <div><strong>Weight</strong> = 2.5g (modern)</div>
                                                        <div><strong>Diameter</strong> = 19.05mm</div>
                                                        <div><strong>Lincoln Cent</strong> = 1909-present</div>
                                                        <div><strong>Wheat Penny</strong> = 1909-1958</div>
                                                        <div><strong>Composition</strong> = 97.5% Zn, 2.5% Cu</div>
                                                        <div><strong>Pre-1982</strong> = 95% Cu, 5% Zn</div>
                                                        <div><strong>Steel Penny</strong> = 1943 only</div>
                                                        <div><strong>Indian Head</strong> = 1859-1909</div>
                                                        <div><strong>Roll Count</strong> = 50 pennies</div>
                                                        <div><strong>Box Count</strong> = 2500 pennies</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const penniesValue = document.getElementById('penniesValue');
                        const pennyType = document.getElementById('pennyType');
                        const valueAssessment = document.getElementById('valueAssessment');
                        const copperPrice = document.getElementById('copperPrice');
                        const zincPrice = document.getElementById('zincPrice');
                        const metalPricesContainer = document.getElementById('metalPricesContainer');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const dollarsDisplay = document.getElementById('dollarsDisplay');
                        const totalCentsDisplay = document.getElementById('totalCentsDisplay');
                        const perPennyDisplay = document.getElementById('perPennyDisplay');
                        const totalWeightDisplay = document.getElementById('totalWeightDisplay');
                        const metalContentDisplay = document.getElementById('metalContentDisplay');
                        const eraDisplay = document.getElementById('eraDisplay');
                        const nickelsDisplay = document.getElementById('nickelsDisplay');
                        const dimesDisplay = document.getElementById('dimesDisplay');
                        const quartersDisplay = document.getElementById('quartersDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Penny specifications
                        const pennySpecs = {
                            lincoln_cent: {
                                weight: 2.5, // grams (post-1982)
                                diameter: '19.05mm',
                                thickness: '1.55mm',
                                composition: '97.5% Zn, 2.5% Cu',
                                era: '1909-present',
                                designer: 'Victor Brenner',
                                edge: 'Plain',
                                copperContent: 0.025, // 2.5%
                                zincContent: 0.975, // 97.5%
                                collectorMultiplier: 1.0
                            },
                            wheat_penny: {
                                weight: 3.11, // grams (pre-1982)
                                diameter: '19.05mm',
                                thickness: '1.55mm',
                                composition: '95% Cu, 5% Zn',
                                era: '1909-1958',
                                designer: 'Victor Brenner',
                                edge: 'Plain',
                                copperContent: 0.95, // 95%
                                zincContent: 0.05, // 5%
                                collectorMultiplier: 3.0
                            },
                            indian_head_penny: {
                                weight: 3.11,
                                diameter: '19.05mm',
                                thickness: '1.55mm',
                                composition: '95% Cu, 5% Zn',
                                era: '1859-1909',
                                designer: 'James Longacre',
                                edge: 'Plain',
                                copperContent: 0.95,
                                zincContent: 0.05,
                                collectorMultiplier: 15.0
                            },
                            flying_eagle_cent: {
                                weight: 4.67,
                                diameter: '19.3mm',
                                thickness: '1.6mm',
                                composition: '88% Cu, 12% Ni',
                                era: '1856-1858',
                                designer: 'James Longacre',
                                edge: 'Plain',
                                copperContent: 0.88,
                                zincContent: 0,
                                collectorMultiplier: 50.0
                            },
                            large_cent: {
                                weight: 10.89,
                                diameter: '28-29mm',
                                thickness: '2-3mm',
                                composition: '100% Cu',
                                era: '1793-1857',
                                designer: 'Various',
                                edge: 'Plain/Lettered',
                                copperContent: 1.0,
                                zincContent: 0,
                                collectorMultiplier: 100.0
                            },
                            steel_penny: {
                                weight: 2.7,
                                diameter: '19.05mm',
                                thickness: '1.55mm',
                                composition: 'Steel, Zn plated',
                                era: '1943',
                                designer: 'Victor Brenner',
                                edge: 'Plain',
                                copperContent: 0,
                                zincContent: 0.01, // zinc plating
                                collectorMultiplier: 50.0
                            },
                            canadian_penny: {
                                weight: 2.25,
                                diameter: '19.05mm',
                                thickness: '1.45mm',
                                composition: '94% Steel, 6% Cu',
                                era: '1858-2013',
                                designer: 'Various',
                                edge: 'Plain',
                                copperContent: 0.06,
                                zincContent: 0,
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
                            const assessment = valueAssessment.value;
                            metalPricesContainer.style.display = assessment === 'metal_value' ? 'block' : 'none';
                        }

                        function calculate() {
                            const pennies = parseInt(penniesValue.value, 10);
                            const type = pennyType.value;
                            const assessment = valueAssessment.value;
                            const currentCopperPrice = parseFloat(copperPrice.value) || 4.20;
                            const currentZincPrice = parseFloat(zincPrice.value) || 1.25;
                            
                            if (!Number.isNaN(pennies) && pennies >= 0) {
                                const specs = pennySpecs[type];
                                const faceValue = pennies * 0.01; // 1 cent per penny
                                let totalValue = faceValue;
                                let perPennyValue = 0.01;

                                // Calculate value based on assessment
                                if (assessment === 'collector_value') {
                                    totalValue = pennies * 0.01 * specs.collectorMultiplier;
                                    perPennyValue = 0.01 * specs.collectorMultiplier;
                                } else if (assessment === 'metal_value') {
                                    // Calculate melt value based on metal content
                                    const weightLbs = specs.weight / 453.592; // grams to pounds
                                    const copperValue = weightLbs * specs.copperContent * currentCopperPrice;
                                    const zincValue = weightLbs * specs.zincContent * currentZincPrice;
                                    const meltValuePerPenny = copperValue + zincValue;
                                    
                                    totalValue = pennies * Math.max(meltValuePerPenny, 0.01); // Never less than face value
                                    perPennyValue = Math.max(meltValuePerPenny, 0.01);
                                } else if (assessment === 'average_condition') {
                                    // Average circulated condition (slight premium for older coins)
                                    const conditionMultiplier = specs.collectorMultiplier > 1 ? 
                                        Math.min(specs.collectorMultiplier * 0.1, 2.0) : 1.0;
                                    totalValue = pennies * 0.01 * conditionMultiplier;
                                    perPennyValue = 0.01 * conditionMultiplier;
                                }

                                // Update primary output
                                output.textContent = '$' + formatNumber(totalValue);
                                resultTitle.textContent = assessment === 'face_value' ? 'Face Value in Dollars' : 
                                                        assessment === 'collector_value' ? 'Collector Value in Dollars' : 
                                                        assessment === 'metal_value' ? 'Metal Value in Dollars' : 'Average Value in Dollars';
                                resultDescription.textContent = `${pennies.toLocaleString('en-US')} ${pennies === 1 ? 'penny' : 'pennies'} = $${formatNumber(totalValue)}`;

                                // Display breakdowns
                                dollarsDisplay.textContent = '$' + formatNumber(totalValue);
                                totalCentsDisplay.textContent = Math.round(totalValue * 100) + '¢';
                                perPennyDisplay.textContent = '$' + formatNumber(perPennyValue, 4);

                                // Physical properties
                                const totalWeight = pennies * specs.weight;
                                const totalWeightLbs = totalWeight / 453.592;
                                totalWeightDisplay.textContent = formatNumber(totalWeight, 1) + 'g / ' + formatNumber(totalWeightLbs, 3) + 'lb';
                                metalContentDisplay.textContent = specs.composition;
                                eraDisplay.textContent = specs.era;

                                // Equivalent coins
                                nickelsDisplay.textContent = formatNumber(pennies / 5, 1); // 5 pennies per nickel
                                dimesDisplay.textContent = formatNumber(pennies / 10, 1); // 10 pennies per dime
                                quartersDisplay.textContent = formatNumber(pennies / 25, 1); // 25 pennies per quarter
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Total Value in Dollars';
                            resultDescription.textContent = 'Enter a number of pennies to convert';
                            dollarsDisplay.textContent = '--';
                            totalCentsDisplay.textContent = '--';
                            perPennyDisplay.textContent = '--';
                            totalWeightDisplay.textContent = '--';
                            metalContentDisplay.textContent = '--';
                            eraDisplay.textContent = '--';
                            nickelsDisplay.textContent = '--';
                            dimesDisplay.textContent = '--';
                            quartersDisplay.textContent = '--';
                        }

                        function clearAll() {
                            penniesValue.value = '';
                            pennyType.value = 'lincoln_cent';
                            valueAssessment.value = 'face_value';
                            copperPrice.value = '4.20';
                            zincPrice.value = '1.25';
                            updateMetalPricesVisibility();
                            clearOutputs();
                            penniesValue.focus();
                        }

                        // Event listeners
                        penniesValue.addEventListener('input', calculate);
                        pennyType.addEventListener('change', calculate);
                        valueAssessment.addEventListener('change', function() {
                            updateMetalPricesVisibility();
                            calculate();
                        });
                        copperPrice.addEventListener('input', calculate);
                        zincPrice.addEventListener('input', calculate);

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
                                const pennies = this.getAttribute('data-pennies');
                                
                                penniesValue.value = pennies;
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-yellow-100', 'text-yellow-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-yellow-100', 'text-yellow-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-pennies]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const pennies = this.getAttribute('data-pennies');
                                
                                if (pennies) {
                                    penniesValue.value = pennies;
                                    calculate();
                                    penniesValue.focus();
                                }
                            });
                        });

                        // Initialize
                        updateMetalPricesVisibility();
                        penniesValue.focus();

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
